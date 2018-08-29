<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\Constant\HTTPHeader;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
use LINE\LINEBot\Event;
use LINE\LINEBot\Event\BaseEvent;
use LINE\LINEBot\Event\MessageEvent;
use LINE\LINEBot\MessageBuilder;
use LINE\LINEBot\MessageBuilder\TextMessageBuilder;
use LINE\LINEBot\MessageBuilder\StickerMessageBuilder;
use LINE\LINEBot\MessageBuilder\ImageMessageBuilder;
use LINE\LINEBot\MessageBuilder\LocationMessageBuilder;
use LINE\LINEBot\MessageBuilder\AudioMessageBuilder;
use LINE\LINEBot\MessageBuilder\VideoMessageBuilder;
use LINE\LINEBot\ImagemapActionBuilder;
use LINE\LINEBot\ImagemapActionBuilder\AreaBuilder;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapMessageActionBuilder ;
use LINE\LINEBot\ImagemapActionBuilder\ImagemapUriActionBuilder;
use LINE\LINEBot\MessageBuilder\Imagemap\BaseSizeBuilder;
use LINE\LINEBot\MessageBuilder\ImagemapMessageBuilder;
use LINE\LINEBot\MessageBuilder\MultiMessageBuilder;
use LINE\LINEBot\TemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\DatetimePickerTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\MessageTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\PostbackTemplateActionBuilder;
use LINE\LINEBot\TemplateActionBuilder\UriTemplateActionBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateMessageBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ButtonTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\CarouselColumnTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ConfirmTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselTemplateBuilder;
use LINE\LINEBot\MessageBuilder\TemplateBuilder\ImageCarouselColumnTemplateBuilder;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
use Carbon\Carbon;

use App\Prize;
use App\Exam_New as Exam_New;

define('LINE_MESSAGE_CHANNEL_ID', '1602719598');
define('LINE_MESSAGE_CHANNEL_SECRET', 'adc5d09e0446060bdba4cbf68a877ee9');
define('LINE_MESSAGE_ACCESS_TOKEN', 'iU3Z5u+f3Aj+nbHhqkb1NCuoXaI71Z1MUFyUfg2u8Nqb6hxMpsQw0eKEL0W2j6tFEX7XqG5tKq8RmNgkbBwcYlaBeq0l1V29lklaLNXOU6g+lDhRC2SNAhzc1b9C4SgRxUCLuIXFxH5iCyrFr5yTEQdB04t89/1O/w1cDnyilFU=');

define('SERV_NAME', 'https://pkwang.herokuapp.com/');


class BotController extends Controller
{
    public function index()
    {
        // เชื่อมต่อกับ LINE Messaging API
        $httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
        $bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));

        // คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
        $content = file_get_contents('php://input');
        $events = json_decode($content, true);


        if(!is_null($events)){
            // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
            // $replyToken = $event->getReplyToken();
            // //$replyInfo = $events['events']['type'];
            // $userId = $event->getUserId();
            // $typeMessage = $event->getMessageType();
            // $userMessage = $event->getText();

            foreach ($events['events'] as $event) {
                // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
                $replyToken = $event['replyToken'];
                $replyInfo = $event['type'];
                $userId = $event['source']['userId'];

                if ($replyInfo == "postback") {
                    $postbackData = $event['postback']['data'];
                    list($postback_action_part, $postback_id_part) = explode("&", $postbackData, 2);
                    list($postback_title, $postback_action) = explode("=", $postback_action_part);
                    if ($postback_action == "exchange") {
                        list($postback_title, $postback_id) = explode("=", $postback_id_part);
                        $selected = DB::table('prizes')
                            ->where('id', $postback_id)
                            ->first();
                        $student = DB::table('students')
                            ->where('line_code', $userId)
                            ->first();
                        if ($student->point >= $selected->point) {
                            DB::table('students')
                                ->where('line_code', $userId)
                                ->update(['point' => $student->point - $selected->point]);

                            if ($selected->type_id === 1) {
                                $avail_code = DB::table('codes')
                                    ->where('prize_id', $selected->id)
                                    ->where('status', 0)
                                    ->first();
                                DB::table('codes')
                                    ->where('id', $avail_code->id)
                                    ->update(['status' => 1]);
                                DB::table('exchanges')->insert([
                                    'line_code' => $userId,
                                    'send' => 1,
                                    'code_id' => $avail_code->id,
                                    'time' => Carbon::now()
                                ]);
                                $replyData = "เก่งมาก นำโค้ดนี้ไปใช้นะ " . $avail_code->code;
                            } elseif ($selected->type_id === 2) {
                                DB::table('exchanges')->insert([
                                    'line_code' => $userId,
                                    'send' => 1,
                                    'time' => Carbon::now()
                                ]);
                                $replyData = "รอส่งสินค้านะจ๊ะ";
                            }
                        } else {
                            $replyData = "แต้มไม่พอนี่นา แลกไม่ได้นะเนี่ย";
                        }
                        $bot->replyMessage($replyToken, new TextMessageBuilder($replyData));
                    }
                    continue;
                } else if ($replyInfo == "message") {
                    $typeMessage = $event['message']['type'];
                    $userMessage = $event['message']['text'];

                    //------ SET VAR ---------
                    $pos1 = strrpos($userMessage, 'หรม');
                    $pos2 = strrpos($userMessage, 'ครน');

                    //------ RICH MENU -------
                    if ($userMessage == "เปลี่ยนวิชา") {
                        $imageMapUrl = 'https://github.com/anan211139/NECTECinternship/blob/master/img/final_subject.png?raw=true';
                        $replyData = new ImagemapMessageBuilder(
                            $imageMapUrl,
                            "รายการวิชา",
                            new BaseSizeBuilder(546, 1040),
                            array(
                                new ImagemapMessageActionBuilder(
                                    "วิชาคณิตศาสตร์",
                                    new AreaBuilder(91, 199, 873, 155)
                                ),
                                new ImagemapMessageActionBuilder(
                                    "วิชาภาษาอังกฤษ",
                                    new AreaBuilder(87, 350, 873, 155)
                                ),
                            ));
                    } else if ($userMessage == "เปลี่ยนหัวข้อ" || $userMessage == "วิชาคณิตศาสตร์") {

                        $imageMapUrl = 'https://github.com/anan211139/NECTECinternship/blob/master/img/final_lesson.png?raw=true';
                        $replyData = new ImagemapMessageBuilder(
                            $imageMapUrl,
                            'หัวข้อที่ต้องการเรียน',
                            new BaseSizeBuilder(546, 1040),
                            array(
                                new ImagemapMessageActionBuilder(
                                    'สมการ',
                                    new AreaBuilder(91, 199, 873, 155)
                                ),
                                new ImagemapMessageActionBuilder(
                                    'หรม./ครน.',
                                    new AreaBuilder(87, 350, 873, 155)
                                ),
                            ));
                    } else if($userMessage =="ดูคะแนน"){
                        $arr_replyData = array();
                        $arr_replyData[] = $this->declare_point($userId);
                        


                        $actionBuilder = array(
                            new UriTemplateActionBuilder(
                                'ดูคะแนนย้อนหลัง', // ข้อความแสดงในปุ่ม
                                //'https://pkwang.herokuapp.com/selectoverall/'.$userId
                                SERV_NAME.'selectoverall/'.$userId
                            ),   
                        );
                        $imageUrl = 'https://github.com/anan211139/NECTECinternship/blob/master/img/graph.png?raw=true/700';
                        $arr_replyData[] = new TemplateMessageBuilder('Button Template',
                            new ButtonTemplateBuilder(
                                    'ดูคะแนนย้อนหลัง', // กำหนดหัวเรื่อง
                                    'หากต้องการดูคะแนนย้อนหลังทั้งหมดสามารถดูได้จากด้านล่างเลยจ้าาา', // กำหนดรายละเอียด
                                    $imageUrl, // กำหนด url รุปภาพ
                                    $actionBuilder  // กำหนด action object
                            )
                        );              

                        $multiMessage = new MultiMessageBuilder;
                        foreach ($arr_replyData as $arr_Reply) {
                            $multiMessage->add($arr_Reply);
                        }
                        $replyData = $multiMessage;
                    } else if ($userMessage == "สะสมแต้ม") {
                        $score = DB::table('students')
                            ->where('line_code', $userId)
                            ->first();
                        $point_st = $score->point;
                        $actionBuilder = array(
                            new MessageTemplateActionBuilder(
                                'แลกของรางวัล', // ข้อความแสดงในปุ่ม
                                'แลกของรางวัล'
                            )
                        );

                        $replyData = new TemplateMessageBuilder('Button Template',
                            new ButtonTemplateBuilder(
                                'ดูแต้มกันดีกว่า', // กำหนดหัวเรื่อง
                                'ตอนนี้น้องมีแต้มทั้งหมด ' . $point_st . 'แต้มจ้า', // กำหนดรายละเอียด
                                'https://github.com/anan211139/NECTECinternship/blob/master/img/score.png?raw=true/700', // กำหนด url รุปภาพ
                                $actionBuilder  // กำหนด action object
                            )

                        );
                    } else if ($userMessage == "แลกของรางวัล") {

                        $re_prizes = Prize::all()->toArray();
                        $columnTemplateBuilders = array();
                        foreach ($re_prizes as $prize) {
                            $columnTemplateBuilder = new CarouselColumnTemplateBuilder(
                                $prize['name'],
                                'ใช้ ' . $prize['point'] . ' แต้มในการแลก',
                                //'https://pkwang.herokuapp.com/' . $prize['local_pic'],
                                SERV_NAME.$prize['local_pic'],
                                [
                                    new PostbackTemplateActionBuilder('แลก', http_build_query(array('action' => 'exchange', 'id' => $prize['id'])))
                                    ,]
                            );
                            array_push($columnTemplateBuilders, $columnTemplateBuilder);
                        }

                        $carouselTemplateBuilder = new CarouselTemplateBuilder($columnTemplateBuilders);
                        $replyData = new TemplateMessageBuilder('รายการ Sponser', $carouselTemplateBuilder);

                    } else if ($userMessage == "ดู Code") {
                        $arr_replyData = array();

                        $textReplyMessage = "ข้อมูลด้านล่างใช้เพื่อเชื่อมต่อเว็บไซต์ โดยน้องสามารถกดลิงค์ด้านล่างได้เลยจ้า แต่หากไม่สะดวกกดลิงค์พี่หมีแนะนำว่าให้ใช QR Code เพื่อป้องกันความผิดพลาดจ้า";
                        $arr_replyData[] = new TextMessageBuilder($textReplyMessage);

                        //$connectChild = 'https://pkwang.herokuapp.com/connectchild/' . $userId;
                        $connectChild = SERV_NAME.'connectchild/'. $userId;
                        $dataQR = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=' . $connectChild . '&choe=UTF-8';

                        $arr_replyData[] = new TextMessageBuilder($connectChild);

                        //------QR CODE-----------

                        $picFullSize = $dataQR;
                        $picThumbnail = $dataQR . '/240';

                        $arr_replyData[] = new ImageMessageBuilder($picFullSize, $picThumbnail);


                        //--------REPLY----------
                        $multiMessage = new MultiMessageBuilder;
                        foreach ($arr_replyData as $arr_Reply) {
                            $multiMessage->add($arr_Reply);
                        }
                        $replyData = $multiMessage;
                    } else if ($userMessage == "เกี่ยวกับพี่หมี") {
                        $arr_replyData = array();
                        $textReplyMessage = "\t  สวัสดีครับน้องๆ พี่มีชื่อว่า \" พี่หมีติวเตอร์ \" ซึ่งพี่หมีจะมาช่วยน้องๆทบทวนบทเรียน\n\t โดยจะมาเป็นติวเตอร์ส่วนตัวให้กับน้องๆ ซึ่งน้องๆสามารถเลือกบทเรียนได้เอง \n\t  จะทบทวนบทเรียนตอนไหนก็ได้ตามความสะดวก ในการทบทวนบทเรียนในเเต่ละครั้ง \n\t  พี่หมีจะมีการเก็บคะแนนน้องๆไว้ เพื่อมอบของรางวัลให้น้องๆอีกด้วย \n\t  เห็นข้อดีอย่างนี้เเล้ว น้องๆจะรออะไรอยู่เล่า มาเริ่มทบทวนบทเรียนกันเถอะ!!!";
                        $arr_replyData[] = new TextMessageBuilder($textReplyMessage);

                        $textReplyMessage = "https://www.youtube.com/embed/Yad6t_EgwVw";
                        $arr_replyData[] = new TextMessageBuilder($textReplyMessage);

                        $multiMessage = new MultiMessageBuilder;
                        foreach ($arr_replyData as $arr_Reply) {
                            $multiMessage->add($arr_Reply);
                        }
                        $replyData = $multiMessage;

                    } //------ หรม./ครน. -------
                    else if ($pos1 !== false || $pos2 !== false) {
                        DB::table('students')
                            ->where('line_code', $userId)
                            ->update(['chapter_id' => 2]);
                        $arr_replyData = $this->start_exam($userId, 2);
                        $multiMessage = new MultiMessageBuilder;
                        foreach ($arr_replyData as $arr_Reply) {
                            $multiMessage->add($arr_Reply);
                        }
                        $replyData = $multiMessage;
                    }
                    // else if ($userMessage == "ลองNOTI"){
                    //     $user_select = DB::table('groups')
                    //         ->where('status', false)
                    //         ->pluck('line_code')
                    //         ->all();
                        
                        

                    //     $user_select = array_unique($user_select);

                    //     // dd($user_select);

                    //     // foreach ($user_select as $line_u) {

                    //         $join_log_group = DB::table('groups')
                    //             ->join('logChildrenQuizzes', 'logChildrenQuizzes.group_id', '=', 'groups.id')
                    //             ->join('chapters', 'chapters.id', '=', 'groups.chapter_id')
                    //             ->select('logChildrenQuizzes.id as log_id','chapters.name as chap_name', 'groups.id as group_id', 'groups.line_code','logChildrenQuizzes.time')
                    //             // ->where('groups.line_code', $line_u)
                    //             ->where('groups.line_code', $userId)
                    //             ->orderBy('groups.id','ASC')
                    //             ->orderBy('logChildrenQuizzes.time', 'DESC')
                    //             ->get();

                            

                    //         $unfin_log = array_unique($join_log_group->pluck('chap_name')->all());

                    //         // dd($unfin_log);
                    //         $chap_text7 = "";
                    //         $chap_text3 = "";
                    //         $del_group = false;

                    //         foreach ($unfin_log as $rest_chap) {
                    //             $del_subj = $join_log_group->where('chap_name', $rest_chap)->first();
                    //             if ((new Carbon($del_subj->time))->diffInDays(Carbon::now()) >= 6) {
                    //                 DB::table('groupRandoms')
                    //                     ->where('group_id', $del_subj->group_id)
                    //                     ->delete();
                    //                 DB::table('logChildrenQuizzes')
                    //                     ->where('group_id', $del_subj->group_id)
                    //                     ->delete();
                    //                 DB::table('groups')
                    //                     ->where('id', $del_subj->group_id)
                    //                     ->delete();
                    //                 echo "DELETE".$del_subj->group_id;
                    //                 $del_group = true;
                    //                 $chap_text7 = $chap_text7." ".$rest_chap.",";
                    //                 echo "MORE6".$rest_chap;
                    //             }
                    //             else if ((new Carbon($del_subj->time))->diffInDays(Carbon::now()) >= 2) {
                    //                 $chap_text3 = $chap_text3." ".$rest_chap.",";
                    //                 echo "MORE2".$rest_chap;
                    //             }
                    //         }
                    //         if ($del_group == true) {
                    //             $chap_text7 = rtrim($chap_text7, ',');
                    //             $textReplyMessage = "ข้อสอบเรื่อง".$chap_text7." ที่ทำค้างไว้ถูกลบแล้วนะครับบบบ";
                    //             echo $textReplyMessage;
                    //             $replyData = new TextMessageBuilder($textReplyMessage);
                    //             // $response = $bot->pushMessage($line_u ,$replyData);
                    //             $response = $bot->pushMessage($userId ,$replyData);
                    //         }
                    //         if (strlen($chap_text3) > 0) {
                    //             $chap_text3 = rtrim($chap_text3, ',');
                    //             $textReplyMessage = "กลับมาทำโจทย์เรื่อง".$chap_text3." กับพี่หมีกันเถอะ !!!!!!";
                    //             echo $textReplyMessage;
                    //             $replyData = new TextMessageBuilder($textReplyMessage);
                    //             // $response = $bot->pushMessage($line_u ,$replyData);
                    //             $response = $bot->pushMessage($userId ,$replyData);
                    //         }
                    //     //}
                    // }
                    //------ สมการ -------
                    else if ($userMessage == "สมการ") {
                        DB::table('students')
                            ->where('line_code', $userId)
                            ->update(['chapter_id' => 1]);
                        $arr_replyData = $this->start_exam($userId, 1);
                        $multiMessage = new MultiMessageBuilder;
                        foreach ($arr_replyData as $arr_Reply) {
                            $multiMessage->add($arr_Reply);
                        }
                        echo "สมการ";
                    
                        $replyData = $multiMessage;
                    } 
                    else if ($userMessage == "ลงทะเบียน"){


                        $actionBuilder = array(
                            new UriTemplateActionBuilder(
                                'ลงทะเบียน', // ข้อความแสดงในปุ่ม
                                SERV_NAME.'studentinfo/'.$userId
                            ),   
                        );
                        $imageUrl = SERV_NAME.'img/img/card_regis.png';
                        $replyData = new TemplateMessageBuilder('Button Template',
                            new ButtonTemplateBuilder(
                                'ละทะเบียนเข้าใช้งาน', // กำหนดหัวเรื่อง
                                'ก่อนจะเข้าใช้งานพี่หมีติวเตอร์ พี่หมีขอรบกวนน้องๆ กรอกข้อมูลให้พี่หมีหน่อยนะครับ', 
                                $imageUrl, // กำหนด url รุปภาพ
                                $actionBuilder  // กำหนด action object
                            )
                        );              

                    }
                    else if ($userMessage == '1' || $userMessage == '2' || $userMessage == '3' || $userMessage == '4') {
                        echo "1234";

                        $multiMessage = new MultiMessageBuilder;
                        $std = DB::table('students')
                            ->where('line_code', $userId)
                            ->first();
                        
                        $urgroup = DB::table('groups')
                            ->where('line_code', $userId)
                            ->where('chapter_id', $std->chapter_id)
                            ->orderBy('id', 'DESC')
                            ->first();
                        // dd($urgroup);
                        $currentlog = DB::table('logChildrenQuizzes')
                            ->where('group_id', $urgroup->id)
                            ->orderBy('id', 'DESC')
                            ->first();

                        //  dd ($currentlog);

                        $ans = DB::table('exams')
                            ->where('id', $currentlog->exam_id)
                            ->orderBy('id', 'DESC')
                            ->first();

                         //dd ($ans); 

                        $princ = DB::table('printciples')
                            ->where('id', $ans->principle_id)
                            ->first();
                        // dd($princ);
                        $count_quiz = DB::table('logChildrenQuizzes')
                            ->where('group_id', $urgroup->id)
                            ->count();
                        // dd($count_quiz);
                        $princ_pic = $princ->local_pic;
                        $ans_status = $currentlog->is_correct;
                        $sec_chance = $currentlog->second_chance;

                        $arr_replyData = array();

                        echo "REPLY";
                        $check_st_end = false;

                        if ($ans_status === null) {
                            if ((int)$userMessage == $ans->answer) {
                                echo "correct";
                                $arr_replyData[] = new TextMessageBuilder("ถูกต้อง! เก่งจังเลย");
                                $ansst = true;
                                $check_st_end = true;

                                DB::table('logChildrenQuizzes')
                                ->where('id', $currentlog->id)
                                ->update(['answer' => $userMessage, 'is_correct' => $ansst, 'time' => Carbon::now()]);

                                if ($count_quiz < 20) {
                                    foreach ($arr_replyData as $arr_Reply) {
                                        $multiMessage->add($arr_Reply);
                                    }
                                    $arr_replyData = $this->randQuiz($ans->chapter_id, $ans->level_id, $urgroup->id);
                                    foreach ($arr_replyData as $arr_Reply) {
                                        $multiMessage->add($arr_Reply);
                                    }
                                    $arr_replyData = array();
                                } 
                                // else {
                                //     $arr_replyData[] = $this->close_group($urgroup->id);
                                // }

                            } else {
                                echo "incorrect";
                                $arr_replyData[] = new TextMessageBuilder("ผิดแล้ว พี่หมีจะสอนให้");
                                $ansst = false;

                                DB::table('logChildrenQuizzes')
                                ->where('id', $currentlog->id)
                                ->update(['answer' => $userMessage, 'is_correct' => $ansst, 'time' => Carbon::now()]);


                                //$pathtoprinc = 'https://pkwang.herokuapp.com/' . $princ_pic . '/';
                                $pathtoprinc = SERV_NAME.$princ_pic;
                                echo $pathtoprinc;
                                $arr_replyData[] = new ImageMessageBuilder($pathtoprinc, $pathtoprinc);
                                $arr_replyData[] = new TextMessageBuilder("น้องลองตอบใหม่อีกครั้งสิจ๊ะ");
                                echo "ลองตอบใหม่";

                            }
                            // DB::table('logChildrenQuizzes')
                            //     ->where('id', $currentlog->id)
                            //     ->update(['answer' => $userMessage, 'is_correct' => $ansst, 'time' => Carbon::now()]);
                            echo "END_LOOP_firstcheck";
                        } else if ($ans_status == 0 && $sec_chance == 0) {

                            echo "Check";
                            $check_st_end = true;
                            if ((int)$userMessage == $ans->answer) {
                                $textReplyMessage = "ถูกต้อง! เก่งจังเลย";
                                $ansst = true;
                                echo "ST";
                            } else {
                                $textReplyMessage = "ยังผิดอยู่เลย ไปแก้ตัวที่ข้อต่อไปกันดีกว่า";
                                $ansst = false;
                                echo "SF";
                            }
                            echo "END_LOOP_sccheck";
                            $arr_replyData[] = new TextMessageBuilder($textReplyMessage);

                            DB::table('logChildrenQuizzes')
                                ->where('id', $currentlog->id)
                                ->update(['second_chance' => 1, 'is_correct_second' => $ansst]);
                            echo "afterDB";
                            if ($count_quiz < 20) {
                                echo "lessthan20";
                                foreach ($arr_replyData as $arr_Reply) {
                                    $multiMessage->add($arr_Reply);
                                }
                                echo "สุดยอดดดดดด";
                                $arr_replyData = $this->randQuiz($ans->chapter_id, $ans->level_id, $urgroup->id);
                                echo "afterRand";
                                foreach ($arr_replyData as $arr_Reply) {
                                    $multiMessage->add($arr_Reply);
                                }
                                $arr_replyData = array();
                            } 
                      
                            // else {
                            //     $arr_replyData[] = $this->close_group($urgroup->id);
                            // }
                        }
                        // test close group where 20
                        if($count_quiz == 20 && $check_st_end == true){
                            $arr_replyData[] = $this->close_group($urgroup->id);
                        }

                        // $multiMessage = new MultiMessageBuilder;
                        foreach ($arr_replyData as $arr_Reply) {
                            $multiMessage->add($arr_Reply);
                        }
                        $replyData = $multiMessage;
                        // $replyData = new TextMessageBuilder("อิอิ");
                        // echo "จบแล้วโว้ยยยยย";
                    } else if ($userMessage == "content") {
                        $replyData = new TextMessageBuilder($content);
                        echo "ANAN-- YOOOOO!!!!!";
                    
                    } else if ($userMessage == "ลองflex") {
                        $this->replymessage7($replyToken,'flex_message_menu');
                        $replyData = new TextMessageBuilder("พี่พลอย");
                    } 
                    else if ($userMessage == "ลองquery_choice_pic") {
                        $this->replymessage7($replyToken,'flex_choice_pic');
                        $replyData = new TextMessageBuilder("test");
                    }
                    else if ($userMessage == "ลองquery_choice_nonpic") {
                        $this->replymessage7($replyToken,'flex_choice_nonpic');
                        $replyData = new TextMessageBuilder("test");
                    }
                    else {
                        $replyData = new TextMessageBuilder("พี่หมีไม่ค่อยเข้าใจคำว่า \"" . $userMessage . "\" พี่หมีขอโทษนะ");
                    }
                } else if ($replyInfo == "follow") {
                    $multiMessage = new MultiMessageBuilder;
                    //--------INSERT AND CHECK DB--------
                    $checkIMG = DB::table('students')
                    ->where('line_code', $userId)
                    ->count();
                    if ($checkIMG == 0) {

                        $response = $bot->getProfile($userId);
                        $stdprofile = $response->getJSONDecodedBody();
                        $arr_replyData[] = new TextMessageBuilder("สวัสดีจ้านี่พี่หมีเอง\nยินดีที่เราได้เป็นเพื่อนกันนะน้อง ".$stdprofile['displayName']);
                        $arr_replyData[] = new TextMessageBuilder("ก่อนเริ่มบทเรียน ควรดูคลิปวิธีการใช้งานด้านล่างนี้ก่อนนะ\nhttps://www.youtube.com/watch?v=ub39BTOdjeo&feature=youtu.be");

                        $actionBuilder = array(
                            new UriTemplateActionBuilder(
                                'ลงทะเบียน', // ข้อความแสดงในปุ่ม
                                SERV_NAME.'studentinfo/'.$userId
                            ),   
                        );
                        $imageUrl = SERV_NAME.'/img/img/card_regis.png';
                        $arr_replyData[] = new TemplateMessageBuilder('Button Template',
                            new ButtonTemplateBuilder(
                                'ละทะเบียนเข้าใช้งาน', // กำหนดหัวเรื่อง
                                'ก่อนจะเข้าใช้งานพี่หมีติวเตอร์ พี่หมีขอรบกวนน้องๆ กรอกข้อมูลให้พี่หมีหน่อยนะครับ', 
                                $imageUrl, // กำหนด url รุปภาพ
                                $actionBuilder  // กำหนด action object
                            )
                        );  


                        $arr_replyData[] = new TextMessageBuilder("เอาล่ะ! ถ้าพร้อมแล้ว เรามาเลือกวิชาแรกที่จะทำข้อสอบกันเถอะ");
                        $imageMapUrl = 'https://github.com/anan211139/NECTECinternship/blob/master/img/final_subject.png?raw=true';
                        $arr_replyData[] = new ImagemapMessageBuilder(
                            $imageMapUrl,
                            "รายการวิชา",
                            new BaseSizeBuilder(546, 1040),
                            array(
                                new ImagemapMessageActionBuilder(
                                    "วิชาคณิตศาสตร์",
                                    new AreaBuilder(91, 199, 873, 155)
                                ),
                                new ImagemapMessageActionBuilder(
                                    "วิชาภาษาอังกฤษ",
                                    new AreaBuilder(87, 350, 873, 155)
                                ),
                            ));
                        foreach ($arr_replyData as $arr_Reply) {
                            $multiMessage->add($arr_Reply);
                        }
                        $replyData = $multiMessage;
                        
                        DB::table('students')->insert([
                            'line_code' => $userId,
                            'name' => $stdprofile['displayName'],
                            'local_pic' => $stdprofile['pictureUrl']
                        ]);
                        
                    }
                }
            }
            // ส่วนของคำสั่งตอบกลับข้อความ
            $response = $bot->replyMessage($replyToken,$replyData);

        }
    }


    public function randQuiz($chapter_id, $level_id, $group_id){
        echo "RAND";
        //check changing level
        $num_group = DB::table('groups')
            ->where('id', $group_id)
            ->orderBy('id','DESC')
            ->first();

        $count_quiz = DB::table('logChildrenQuizzes')
            ->where('group_id', $group_id)
            ->count();
        echo "จำนวนข้อ>>".$count_quiz;
        //dd($count_quiz);
        if ($count_quiz % 5 == 0) {
            echo "เปลี่ยนระดับ";
            $count_quiz_true = DB::table('logChildrenQuizzes')
                ->where('group_id', $group_id)
                ->offset($count_quiz-5)
                ->limit(5)
                ->get();
            // dd($count_quiz_true);
            $count_num_true=0;
            foreach ($count_quiz_true as $count_true) {
                if($count_true->is_correct == 1){
                    $count_num_true++;
                }
            }
            if ($count_num_true >= 3 && $level_id < 3) {
                $level_id = $level_id + 1;
            }
            else if ($count_num_true < 3 && $level_id > 1) {
                $level_id = $level_id - 1;
            }

            $group_r = DB::table('groupRandoms')
                ->where('group_id', $group_id)
                ->first();
            $group_rand = $group_r->listlevelid;
            $concat_level = $group_rand.$level_id.',';

            DB::table('groupRandoms')
                ->where('group_id', $num_group->id)
                ->update(['listlevelid' => $concat_level]);
        }
        echo "ออกจากเปลี่ยนระดับ";
        //declare the next quiz
        $arr_replyData = array();
        $textReplyMessage = "ข้อที่ ".($count_quiz+1);
        $arr_replyData[] = new TextMessageBuilder($textReplyMessage);

        //random the new quiz and update log, group random
        $insert_status = false;
        echo "ก่อนสุ่มข้อ";
        while( $insert_status == false ){ //วนไรเรื่อยจนกว่าจะใส่ข้อมูลได้
            $quizzesforsubj = DB::table('exams')
                ->where('chapter_id', $chapter_id)
                ->where('level_id', $level_id)
                ->inRandomOrder()
                ->first();

            $group_r = DB::table('groupRandoms')
                ->where('group_id', $group_id)
                ->where('listexamid', 'like', '%,' .$quizzesforsubj->id . ',%')
                ->count();

            if($group_r == 0){  //check ไม่ซ้ำ
                $group_r = DB::table('groupRandoms')
                    ->where('group_id', $group_id)
                    ->first();

                $group_rand = $group_r->listexamid;
                $concat_quiz = $group_rand.$quizzesforsubj->id.',';

                DB::table('groupRandoms')
                    ->where('group_id', $group_id)
                    ->update(['listexamid' => $concat_quiz]);
                DB::table('logChildrenQuizzes')->insert([
                    'group_id' => $group_id,
                    'exam_id' => $quizzesforsubj->id,
                    'time' => Carbon::now()
                ]);
                $insert_status = true;
            }
        }
        echo "ออกจากสุ่มข้อ";
        //show the new quiz
        $current_quiz = DB::table('exams')
            ->where('id', $quizzesforsubj->id)
            ->first();
        //$pathtoexam = 'https://pkwang.herokuapp.com/'.$current_quiz->local_pic;
        $pathtoexam = SERV_NAME.$current_quiz->local_pic;
        $arr_replyData[] = new ImageMessageBuilder($pathtoexam,$pathtoexam);

        return $arr_replyData;
    }

    //use this function after the student pick their own lesson
    public function start_exam($userId, $chapter_id) {
        $arr_replyData = array();
        $current_chapter = DB::table('chapters')
            ->where('id', $chapter_id)
            ->first();
        // dd($current_chapter);
        $old_group_count = DB::table('groups')
            ->where('line_code', $userId)
            ->where('chapter_id', $chapter_id)
            ->where('status',false)
            ->orderBy('id','DESC')
            ->count();
        // if student has finished the old group or fist time create group
        if ($old_group_count == 0) {
            $group_id = DB::table('groups')->insertGetId([ //create new group
                'line_code' => $userId,
                'chapter_id' => $chapter_id,
                'status' => false
            ]);
            
            $quizzesforsubj = DB::table('exams') //generate the first quiz
                ->where('chapter_id', $chapter_id)
                ->where('level_id', 2)
                ->inRandomOrder()
                ->first();
            $tests = DB::table('groupRandoms')->insert([
                'group_id' => $group_id,
                'listexamid' => ','.$quizzesforsubj->id.',',
                'listlevelid' => "2,"
            ]);
            // dd($tests);
            DB::table('logChildrenQuizzes')->insert([
                'group_id' => $group_id,
                'exam_id' => $quizzesforsubj->id,
                'time' => Carbon::now()
            ]);
            $textReplyMessage = "ยินดีต้อนรับน้องๆเข้าสู่บทเรียน\nเรื่อง ".$current_chapter->name."\nเรามาเริ่มกันที่ข้อแรกกันเลยจ้า";
            $arr_replyData[] = new TextMessageBuilder($textReplyMessage);
        }
        //if student has non-finish old group
        else { //in the future, don't forget to check the expire date
            $old_group = DB::table('groups')
                ->where('line_code', $userId)
                ->where('chapter_id', $chapter_id)
                ->orderBy('id','DESC')
                ->first();
            
            // dd($old_group);


            $group_id = $old_group->id;

            $count_quiz = DB::table('logChildrenQuizzes')
            ->where('group_id', $group_id)
            ->count();

            $textReplyMessage = "เรามาเริ่มบทเรียน\nเรื่อง ".$current_chapter->name."\n กันต่อ ในข้อที่ ".$count_quiz." กันเลยจ้า";
            $arr_replyData[] = new TextMessageBuilder($textReplyMessage);
        }
        //for now, there's a non-ans log for every case
        $current_log = DB::table('logChildrenQuizzes')
            ->where('group_id', $group_id)
            ->orderBy('id','DESC')
            ->first();
        $count_quiz = DB::table('logChildrenQuizzes')
            ->where('group_id', $group_id)
            ->orderBy('id','DESC')
            ->count();
        $current_quiz = DB::table('exams')
            ->where('id', $current_log->exam_id)
            ->first();
        
        //show current quiz
        $pathtoexam = SERV_NAME.$current_quiz->local_pic;
        echo $pathtoexam;
        $arr_replyData[] = new ImageMessageBuilder($pathtoexam,$pathtoexam);
        
        return $arr_replyData;
    }

    public function close_group($group_id) {
        echo "CLOSE_GROUP";
        $current_group = DB::table('groups')
            ->where('id', $group_id)
            ->first();

        $current_std = DB::table('students')
            ->where('line_code', $current_group->line_code)
            ->first();

        $all_lvl = DB::table('levels')
            ->get();

        $point_update = 0;
        foreach ($all_lvl as $lvl) {
            $point_update += ($this->results($group_id, $lvl->id)) * $lvl->id;
        }
        DB::table('students')
            ->where('line_code', $current_group->line_code)
            ->update(['point' => $current_std->point + $point_update]);
        DB::table('groups')
            ->where('id', $group_id)
            ->update(['status' => 1, 'score' => $point_update]);
        // DB::table('groupRandoms')
        //         ->where('group_id', '=', $group_id)
        //         ->delete();
        return $this->declare_point($current_group->line_code);
    }

    public function results($group_id, $level_id) {
        echo "RESULT";
        $current_group = DB::table('groups')
            ->where('id', $group_id)
            ->first();

        $stdanses = DB::table('logChildrenQuizzes')
            ->where('group_id', $group_id)
            ->get();
        
        // DB::table('groupRandoms')
        //     ->where('group_id', '=',$group_id)
        //     ->delete();

        $total_exam = 0;
        $total_true = 0;

        foreach($stdanses as $stdans) {
            $examforweight = DB::table('exams')
                ->where('id', $stdans->exam_id)
                ->first();
            if ($examforweight->level_id == $level_id) {
                $total_exam += 1;
                $total_true += ($stdans->is_correct ? 1 : 0);
                //echo $level_id.">>".$total_true."\n";
            }
        }

        if ($total_exam != 0) {
            echo "level_id >>".$level_id."\n total_level >>".$total_exam."\n total_true".$total_true;
            DB::table('results')->insert([
                'line_code' => $current_group->line_code,
                'group_id' => $group_id,
                'level_id' => $level_id,
                'total_level' => $total_exam,
                'total_level_true' => $total_true
            ]);
        }

        return $total_true;

    }

    public function declare_point($userId) {
        $group_true = DB::table('groups')
            ->where('line_code', $userId)
            ->where('status',1)
            ->orderBy('id','DESC')
            ->first();

        $concat_result = "มาดูผลคะแนนจากข้อสอบชุดล่าสุดกันเถอะ :)";

        $group_result = DB::table('results')
        ->where('group_id',$group_true->id)
        ->get();
        foreach ($group_result as $g_result) {
            $text_result = "\nระดับ ";
            for ($i=0; $i < $g_result->level_id; $i++) { 
                $text_result = $text_result."✩";
            }
            $text_result = $text_result.": ถูกต้อง ".$g_result->total_level_true."/".$g_result->total_level." ข้อ";

            $concat_result = $concat_result.$text_result;
        }

        $textReplyMessage = $concat_result;
        $replyData = new TextMessageBuilder($textReplyMessage);
        return $replyData;
    }

    public function replymessage7($replyToken,$fn_json)
    {   
        echo "function_json";
        echo $fn_json;
        $url = 'https://api.line.me/v2/bot/message/reply';
        $data = [
            'replyToken' => $replyToken,
            // 'messages' => [$textMessageBuilder],on
            //'messages' => [$this->flex_message_menu()],
            'messages' => [$this->$fn_json()],
        ];
        $access_token = LINE_MESSAGE_ACCESS_TOKEN;
        $post = json_encode($data);
        $headers = array('Content-Type: application/json', 'Authorization: Bearer ' . $access_token);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
    }
    public function flex_message_menu(){
        $query_sub = DB::table('subjects')
            ->get();
       
        $key=-1;
        
        foreach($query_sub as $value){
            $md_array[($value->id)-1] = 
                array (
                    ++$key => 
                    array (
                      'type' => 'box',
                      'layout' => 'baseline',
                      'contents' => 
                      array (
                        0 => 
                        array (
                          'type' => 'text',
                          'text' => $value->name,
                          'action' => 
                          array (
                            'type' => 'message',
                            'text' => $value->name,
                          ),
                          'size' => 'lg',
                        ),
                      ),
                    ),
                    ++$key => 
                    array (
                      'type' => 'separator',
                      'color' => '#59BDD3',
                      'margin' => 'md',
                    ),
                );
            
        }
        $suject_s =array();
        foreach($md_array as $md){
            foreach($md as $key){
                array_push($suject_s,$key);
            }
            
        }
   
        $textMessageBuilder = [ 
            "type" => "flex",
            "altText" => "this is a flex message",
            "contents" => 
                            array (
                                'type' => 'bubble',
                                'styles' => 
                                array (
                                  'header' => 
                                  array (
                                    'backgroundColor' => '#59BDD3',
                                  ),
                                ),
                                'header' => 
                                array (
                                  'type' => 'box',
                                  'layout' => 'baseline',
                                  'spacing' => 'none',
                                  'contents' => 
                                  array (
                                    0 => 
                                    array (
                                      'type' => 'icon',
                                      'url' => 'https://pimee.softbot.ai/img/books.png',
                                      'size' => 'xl',
                                    ),
                                    1 => 
                                    array (
                                      'type' => 'text',
                                      'text' => 'เลือกวิชา',
                                      'weight' => 'bold',
                                      'size' => 'xl',
                                      'margin' => 'md',
                                      'color' => '#ffffff',
                                    ),
                                  ),
                                ),
                                'body' => 
                                array (
                                    'type' => 'box',
                                    'layout' => 'vertical',
                                    'contents' => 
                                    $suject_s
                
                                )
                                
                            )
              
          
              ];
             
        return $textMessageBuilder;
          
    }
    // public function text_only(){
    //     $textMessageBuilder = [ 
    //         "type" => "flex",
    //         "altText" => "this is a flex message",
    //         "contents" => 
            
              
    //         ];   
    //     return $textMessageBuilder; 
    // }
    public function flex_choice_pic(){
        $exam_pic =  DB::table('Exam_New')
            ->where('id',1)
            ->first();
        dd($exam_pic);
        $textMessageBuilder = [ 
            "type" => "flex",
            "altText" => "this is a flex message",
            "contents" => 
            array (
                'type' => 'bubble',
                'hero' => 
                array (
                  'type' => 'image',
                  'url' => 'https://scdn.line-apps.com/n/channel_devcenter/img/fx/01_3_movie.png',
                  'size' => 'full',
                  'aspectRatio' => '20:13',
                  'aspectMode' => 'cover',
                  'action' => 
                  array (
                    'type' => 'uri',
                    'uri' => 'http://linecorp.com/',
                  ),
                ),
                'body' => 
                array (
                  'type' => 'box',
                  'layout' => 'vertical',
                  'contents' => 
                  array (
                    0 => 
                    array (
                      'type' => 'text',
                      'text' => 'ข้อที่ 1',
                      'weight' => 'bold',
                      'size' => 'lg',
                      'margin' => 'md',
                    ),
                    1 => 
                    array (
                      'type' => 'text',
                      'text' => 'ที่ดินรูปสี่เหลี่ยมผืนผ้ากว้าง  20  เมตร  ยาว  55  เมตร  ถ้าต้องการล้อมรั้วลวดหนามรอบที่ดิน 2  รอบ  จะต้องให้ลวดหนามยาวอย่างน้อยกี่เมตรและมีพื้นที่สำหรับปลูกหญ้าทั้งหมดเท่าไร',
                      'wrap' => true,
                      'size' => 'md',
                      'margin' => 'md',
                      'color' => '#5C5C5C',
                    ),
                    2 => 
                    array (
                      'type' => 'separator',
                      'color' => '#999999',
                      'margin' => 'xl',
                    ),
                    3 => 
                    array (
                      'type' => 'button',
                      'style' => 'link',
                      'height' => 'sm',
                      'action' => 
                      array (
                        'type' => 'message',
                        'text' => 1,
                        'label' => '1) 150  เมตร  1,100  ตารางเมตร',
                      ),
                    ),
                    4 => 
                    array (
                      'type' => 'button',
                      'style' => 'link',
                      'height' => 'sm',
                      'action' => 
                      array (
                        'type' => 'message',
                        'text' => 2,
                        'label' => '2) 150  เมตร  2,200  ตารางเมตร',
                      ),
                    ),
                    5 => 
                    array (
                      'type' => 'button',
                      'style' => 'link',
                      'height' => 'sm',
                      'action' => 
                      array (
                        'type' => 'message',
                        'text' => 3,
                        'label' => '3) 300  เมตร  1,100  ตารางเมตร',
                      ),
                    ),
                    6 => 
                    array (
                      'type' => 'button',
                      'style' => 'link',
                      'height' => 'sm',
                      'action' => 
                      array (
                        'type' => 'message',
                        'text' => 4,
                        'label' => '4) 300  เมตร  2,200  ตารางเมตร',
                      ),
                    ),
                  ),
                ),
              )
            ];   
        return $textMessageBuilder; 
    }
    public function flex_choice_nonpic(){
        $textMessageBuilder = [ 
            "type" => "flex",
            "altText" => "this is a flex message",
            "contents" => 
            array (
                'type' => 'bubble',
                'body' => 
                array (
                  'type' => 'box',
                  'layout' => 'vertical',
                  'contents' => 
                  array (
                    0 => 
                    array (
                      'type' => 'text',
                      'text' => 'ข้อที่ 1',
                      'weight' => 'bold',
                      'size' => 'lg',
                      'margin' => 'md',
                    ),
                    1 => 
                    array (
                      'type' => 'text',
                      'text' => 'ที่ดินรูปสี่เหลี่ยมผืนผ้ากว้าง  20  เมตร  ยาว  55  เมตร  ถ้าต้องการล้อมรั้วลวดหนามรอบที่ดิน 2  รอบ  จะต้องให้ลวดหนามยาวอย่างน้อยกี่เมตรและมีพื้นที่สำหรับปลูกหญ้าทั้งหมดเท่าไร',
                      'wrap' => true,
                      'size' => 'md',
                      'margin' => 'md',
                      'color' => '#5C5C5C',
                    ),
                    2 => 
                    array (
                      'type' => 'separator',
                      'color' => '#999999',
                      'margin' => 'xl',
                    ),
                    3 => 
                    array (
                      'type' => 'button',
                      'style' => 'link',
                      'height' => 'sm',
                      'action' => 
                      array (
                        'type' => 'message',
                        'text' => 1,
                        'label' => '1) 150  เมตร  1,100  ตารางเมตร',
                      ),
                    ),
                    4 => 
                    array (
                      'type' => 'button',
                      'style' => 'link',
                      'height' => 'sm',
                      'action' => 
                      array (
                        'type' => 'message',
                        'text' => 2,
                        'label' => '2) 150  เมตร  2,200  ตารางเมตร',
                      ),
                    ),
                    5 => 
                    array (
                      'type' => 'button',
                      'style' => 'link',
                      'height' => 'sm',
                      'action' => 
                      array (
                        'type' => 'message',
                        'text' => 3,
                        'label' => '3) 300  เมตร  1,100  ตารางเมตร',
                      ),
                    ),
                    6 => 
                    array (
                      'type' => 'button',
                      'style' => 'link',
                      'height' => 'sm',
                      'action' => 
                      array (
                        'type' => 'message',
                        'text' => 4,
                        'label' => '4) 300  เมตร  2,200  ตารางเมตร',
                      ),
                    ),
                  ),
                ),
              )  
            ];   
        return $textMessageBuilder; 
    }
    public function notification() {
        $httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
        $bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
    
        $user_select = DB::table('groups')
            ->where('status', false)
            ->pluck('line_code')
            ->all();

        $user_select = array_unique($user_select);

        foreach ($user_select as $line_u) {

            $join_log_group = DB::table('groups')
                ->join('logChildrenQuizzes', 'logChildrenQuizzes.group_id', '=', 'groups.id')
                ->join('chapters', 'chapters.id', '=', 'groups.chapter_id')
                ->select('logChildrenQuizzes.id as log_id','chapters.name as chap_name', 'groups.id as group_id', 'groups.line_code','logChildrenQuizzes.time')
                ->where('groups.line_code', $line_u)
                ->orderBy('groups.id','ASC')
                ->orderBy('logChildrenQuizzes.time', 'DESC')
                ->get();
            
            $unfin_log = array_unique($join_log_group->pluck('chap_name')->all());
            $chap_text7 = "";
            $chap_text3 = "";
            $del_group = false;

            foreach ($unfin_log as $rest_chap) {
                $del_subj = $join_log_group->where('chap_name', $rest_chap)->first();
                if ((new Carbon($del_subj->time))->diffInDays(Carbon::now()) >= 6) {
                    DB::table('groupRandoms')
                        ->where('group_id', $del_subj->group_id)
                        ->delete();
                    DB::table('logChildrenQuizzes')
                        ->where('group_id', $del_subj->group_id)
                        ->delete();
                    DB::table('groups')
                        ->where('id', $del_subj->group_id)
                        ->delete();
                    $del_group = true;
                    $chap_text7 = $chap_text7." ".$rest_chap.",";
                    echo "MORE6".$rest_chap;
                }
                else if ((new Carbon($del_subj->time))->diffInDays(Carbon::now()) >= 2) {
                    $chap_text3 = $chap_text3." ".$rest_chap.",";
                    echo "MORE2".$rest_chap;
                }
            }
            if ($del_group == true) {
                $chap_text7 = rtrim($chap_text7, ',');
                $textReplyMessage = "ข้อสอบเรื่อง".$chap_text7." ที่ทำค้างไว้ถูกลบแล้วนะครับบบบ";
                $replyData = new TextMessageBuilder($textReplyMessage);
                $response = $bot->pushMessage($line_u ,$replyData);
            }
            else if (strlen($chap_text3) > 0) {
                $chap_text3 = rtrim($chap_text3, ',');
                $textReplyMessage = "กลับมาทำโจทย์เรื่อง".$chap_text3." กับพี่หมีกันเถอะ !!!!!!";
                $replyData = new TextMessageBuilder($textReplyMessage);
                $response = $bot->pushMessage($line_u ,$replyData);
            }
        }
    }
}