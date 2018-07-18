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

define('LINE_MESSAGE_CHANNEL_ID', '1586241418');
define('LINE_MESSAGE_CHANNEL_SECRET', '40f2053df45b479807d8f2bba1b0dbe2');
define('LINE_MESSAGE_ACCESS_TOKEN', 'VjNScyiNVZFTg96I4c62mnCZdY6bqyllIaUZ4L3NHg5uObrERh7O5m/tO3bbgEPeF2D//vC4kHTLQuQGbgpZSqU3C+WUJ86nQNptlraZZtek2tdLYoqREXuN8xy3swo9RVO3EL0VrmnhSQfuOl89AQdB04t89/1O/w1cDnyilFU=');

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
                        $replyData = $this->declare_point($userId);
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
                                'ตอนนี้น้องๆมีแต้มทั้งหมด >>' . $point_st . 'แต้มจ้า', // กำหนดรายละเอียด
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
                                'https://pkwang.herokuapp.com/' . $prize['local_pic'],
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

                        $connectChild = 'https://pkwang.herokuapp.com/connectchild/' . $userId;
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

                        //--------INSERT AND CHECK DB--------
                        $checkIMG = DB::table('students')
                            ->where('line_code', $userId)
                            ->count();

                        if ($checkIMG == 0) {
                            $response = $bot->getProfile($userId);
                            if ($response->isSucceeded()) {
                                $profile = $response->getJSONDecodedBody();
                                DB::table('students')->insert([
                                    'line_code' => $userId,
                                    'name' => $profile['displayName'],
                                    'local_pic' => $profile['pictureUrl']

                                ]);
                            }
                        }

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
                        $arr_replyData = $this->start_exam($userId, 2);
                        $multiMessage = new MultiMessageBuilder;
                        foreach ($arr_replyData as $arr_Reply) {
                            $multiMessage->add($arr_Reply);
                        }
                        $replyData = $multiMessage;
                    } //------ สมการ -------
                    else if ($userMessage == "สมการ") {
                        $arr_replyData = $this->start_exam($userId, 1);
                        $multiMessage = new MultiMessageBuilder;
                        foreach ($arr_replyData as $arr_Reply) {
                            $multiMessage->add($arr_Reply);
                        }
                        $replyData = $multiMessage;
                    } else if ($userMessage == '1' || $userMessage == '2' || $userMessage == '3' || $userMessage == '4') {
                        $multiMessage = new MultiMessageBuilder;
                        $urgroup = DB::table('groups')
                            ->where('line_code', $userId)
                            ->orderBy('id', 'DESC')
                            ->first();
                        $currentlog = DB::table('logChildrenQuizzes')
                            ->where('group_id', $urgroup->id)
                            ->orderBy('id', 'DESC')
                            ->first();

                        $ans = DB::table('exams')
                            ->where('id', $currentlog->exam_id)
                            ->orderBy('id', 'DESC')
                            ->first();

                        $princ = DB::table('printciples')
                            ->where('id', $ans->principle_id)
                            ->first();
                        $count_quiz = DB::table('logChildrenQuizzes')
                            ->where('group_id', $urgroup->id)
                            ->count();

                        $princ_pic = $princ->local_pic;
                        $ans_status = $currentlog->is_correct;
                        $sec_chance = $currentlog->second_chance;

                        $arr_replyData = array();

                        if ($ans_status === null) {
                            if ((int)$userMessage == $ans->answer) {
                                $arr_replyData[] = new TextMessageBuilder("ถูกต้อง! เก่งจังเลย");
                                $ansst = true;

                                if ($count_quiz < 20) {
                                    foreach ($arr_replyData as $arr_Reply) {
                                        $multiMessage->add($arr_Reply);
                                    }
                                    $arr_replyData = $this->randQuiz($ans->chapter_id, $ans->level_id, $urgroup->id);
                                    foreach ($arr_replyData as $arr_Reply) {
                                        $multiMessage->add($arr_Reply);
                                    }
                                    $arr_replyData = array();
                                } else {
                                    $arr_replyData[] = $this->close_group($urgroup->id);
                                }

                            } else {
                                $arr_replyData[] = new TextMessageBuilder("ผิดแล้ว พี่หมีจะสอนให้");
                                $ansst = false;

                                $pathtoprinc = 'https://pkwang.herokuapp.com/' . $princ_pic . '/';
                                $arr_replyData[] = new ImageMessageBuilder($pathtoprinc, $pathtoprinc);
                                $arr_replyData[] = new TextMessageBuilder("น้องลองตอบใหม่อีกครั้งสิจ๊ะ");

                            }

                            DB::table('logChildrenQuizzes')
                                ->where('id', $currentlog->id)
                                ->update(['answer' => $userMessage, 'is_correct' => $ansst, 'time' => Carbon::now()]);

                        } else if ($ans_status === false && $sec_chance === false) {

                            if ((int)$userMessage == $ans->answer) {
                                $textReplyMessage = "ถูกต้อง! เก่งจังเลย";
                                $ansst = true;
                            } else {
                                $textReplyMessage = "ยังผิดอยู่เลย ไปแก้ตัวที่ข้อต่อไปกันดีกว่า";
                                $ansst = false;
                            }
                            $arr_replyData[] = new TextMessageBuilder($textReplyMessage);
                            DB::table('logChildrenQuizzes')
                                ->where('id', $currentlog->id)
                                ->update(['second_chance' => true, 'is_correct_second' => $ansst]);

                            if ($count_quiz < 20) {
                                foreach ($arr_replyData as $arr_Reply) {
                                    $multiMessage->add($arr_Reply);
                                }
                                $arr_replyData = $this->randQuiz($ans->chapter_id, $ans->level_id, $urgroup->id);
                                foreach ($arr_replyData as $arr_Reply) {
                                    $multiMessage->add($arr_Reply);
                                }
                                $arr_replyData = array();
                            } else {
                                $arr_replyData[] = $this->close_group($urgroup->id);
                            }

                        }

                        // $multiMessage = new MultiMessageBuilder;
                        foreach ($arr_replyData as $arr_Reply) {
                            $multiMessage->add($arr_Reply);
                        }
                        $replyData = $multiMessage;
                    } else if ($userMessage == "content") {
                        $replyData = new TextMessageBuilder($content);
                    } else if($userMessage == "ลองNOTI"){

                        $join_log_group = DB::table('logChildrenQuizzes')
                            ->join('groups', 'logChildrenQuizzes.group_id', '=', 'groups.id')
                            ->select('logChildrenQuizzes.id', 'groups.id', 'groups.Line_code','logChildrenQuizzes.date')
                            ->get();
                        dd( $join_log_group);


                    }else {
                        $replyData = new TextMessageBuilder("พี่หมีไม่ค่อยเข้าใจคำว่า \"" . $userMessage . "\" พี่หมีขอโทษนะ");
                    }
                } else if ($replyInfo == "follow") {
                    $multiMessage = new MultiMessageBuilder;
                    $response = $bot->getProfile($userId);
                    $stdprofile = $response->getJSONDecodedBody();
                    $arr_replyData[] = new TextMessageBuilder("สวัสดีจ้านี่พี่หมีเอง\nยินดีที่เราได้เป็นเพื่อนกันนะน้อง ".$stdprofile['displayName']);
                    $arr_replyData[] = new TextMessageBuilder("ก่อนเริ่มบทเรียน ควรดูคลิปวิธีการใช้งานด้านล่างนี้ก่อนนะ");
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
                }
            }
            // ส่วนของคำสั่งตอบกลับข้อความ
            $response = $bot->replyMessage($replyToken,$replyData);

        }
    }


    public function randQuiz($chapter_id, $level_id, $group_id){
        //check changing level
        $num_group = DB::table('groups')
            ->where('id', $group_id)
            ->orderBy('id','DESC')
            ->first();

        $count_quiz = DB::table('logChildrenQuizzes')
            ->where('group_id', $group_id)
            ->count();
        if ($count_quiz % 5 == 0) {
            $count_quiz_true = DB::table('logChildrenQuizzes')
                ->where('group_id', $group_id)
                ->offset($count_quiz-5)
                ->limit(5)
                ->get();
            $count_num_true=0;
            foreach ($count_quiz_true as $count_true) {
                if($count_true->is_correct === true){
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

        //declare the next quiz
        $arr_replyData = array();
        $textReplyMessage = "ข้อที่ ".($count_quiz+1);
        $arr_replyData[] = new TextMessageBuilder($textReplyMessage);

        //random the new quiz and update log, group random
        $insert_status = false;
        while( $insert_status == false ){ //วนไรเรื่อยจนกว่าจะใส่ข้อมูลได้
            $quizzesforsubj = DB::table('exams')
                ->where('chapter_id', $chapter_id)
                ->where('level_id', $level_id)
                ->inRandomOrder()
                ->first();

            $group_r = DB::table('groupRandoms')
                ->where('group_id', $group_id)
                ->where('listexamid', 'like', '%' .$quizzesforsubj->id . ',%')
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

        //show the new quiz
        $current_quiz = DB::table('exams')
            ->where('id', $quizzesforsubj->id)
            ->first();
        $pathtoexam = 'https://pkwang.herokuapp.com/'.$current_quiz->local_pic;
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
            ->orderBy('id','DESC')
            ->count();
        $check_old_g = false;
        if($old_group_count != 0){
            $old_group = DB::table('groups')
            ->where('line_code', $userId)
            ->where('chapter_id', $chapter_id)
            ->orderBy('id','DESC')
            ->first();
            $check_old_g = true;
        }
        // if student has finished the old group or fist time create group
        if ($old_group_count == 0 || $check_old_g === true) {
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
                'listexamid' => $quizzesforsubj->id.',',
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
            $group_id = $old_group->id;
            $textReplyMessage = "เรามาเริ่มบทเรียน\nเรื่อง ".$current_chapter->name."\n กันต่อเลยจ้า";
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
        $pathtoexam = 'https://pkwang.herokuapp.com/'.$current_quiz->local_pic;
        $arr_replyData[] = new ImageMessageBuilder($pathtoexam,$pathtoexam);


        return $arr_replyData;
    }

    public function close_group($group_id) {
        echo 'test';
        DB::table('groups')
            ->where('id', $group_id)
            ->update(['status' => true]);

        $current_group = DB::table('groups')
            ->where('id', $group_id)
            ->first();

        $current_std = DB::table('students')
            ->where('line_code', $current_group->line_code)
            ->first();

        $all_lvl = DB::table('levels')
            ->get();

        $point_update = $current_std->point;
        foreach ($all_lvl as $lvl) {
            $point_update += ($this->results($group_id, $lvl->id)) * $lvl->id;
            DB::table('students')
                ->where('line_code', $current_group->line_code)
                ->update(['point' => $point_update]);
        }
        return $this->declare_point($current_group->line_code);
    }

    public function results($group_id, $level_id) {
        $current_group = DB::table('groups')
            ->where('id', $group_id)
            ->first();

        $stdanses = DB::table('logChildrenQuizzes')
            ->where('group_id', $group_id)
            ->get();

        $total_exam = 0;
        $total_true = 0;

        foreach($stdanses as $stdans) {
            $examforweight = DB::table('exams')
                ->where('id', $stdans->exam_id)
                ->first();
            if ($examforweight->level_id == $level_id) {
                $total_exam += 1;
                $total_true += ($stdans->is_correct ? 1 : 0);
            }
        }

        if ($total_exam != 0) {
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
            ->where('status',true)
            ->orderBy('id','DESC')
            ->first();
        $group_result = DB::table('results')
            ->where('group_id',$group_true->id)
            ->get();

        // $group_count = DB::table('results')
        //     ->where('group_id',$group_true->id)
        //     ->count();
        if($group_true == null){
            $concat_result = "ยังไม่มีคะแนนสอบชุดล่าสุด";
        }
        else{
            $concat_result = "มาดูผลคะแนนจากข้อสอบชุดล่าสุดกัน \n";

            foreach ($group_result as $g_result) {
                $text_result = "ข้อสอบระดับ ";
                for ($i=0; $i < $g_result->level_id; $i++) { 
                    $text_result = $text_result."✩";
                }
                $text_result = $text_result." ถูกต้อง ".$g_result->total_level_true." ข้อ จากทั้งหมด ".$g_result->total_level." ข้อ";

                $concat_result = $concat_result.$text_result;
            }
        }

        $textReplyMessage = $concat_result;
        $replyData = new TextMessageBuilder($textReplyMessage);
        return $replyData;
    }


    //  public function notification() {
    //      $httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
    //      $bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));

    // //     $user_select = DB::table('groups')
    // //         ->pluck('line_code')
    // //         ->all();
        
    // //     $join_log_group = DB::table('logChildrenQuizzes')
    // //         ->join('groups', 'logChildrenQuizzes.group_id', '=', 'groups.id')
    // //         ->select('logChildrenQuizzes.id', 'groups.id', 'groups.Line_code','logChildrenQuizzes.date')
    // //         ->get();

    //      foreach ($user_select as $line_u) {


    //          $Message1 =  $line_u;

    //          $textMessageBuilder = new TextMessageBuilder($Message1);

    //          $response = $bot->pushMessage( 'U64f1e2fafcec762ce15e48cc567d696b' ,$textMessageBuilder);

    //          // $response = $bot->pushMessage( $user_id ,$textMessageBuilder);
    //      }
    //  }
}
