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
use App\Exam;
use App\GroupRandom;
use App\Group;

define('LINE_MESSAGE_CHANNEL_ID', '1586241418');
define('LINE_MESSAGE_CHANNEL_SECRET', '40f2053df45b479807d8f2bba1b0dbe2');
define('LINE_MESSAGE_ACCESS_TOKEN', 'VjNScyiNVZFTg96I4c62mnCZdY6bqyllIaUZ4L3NHg5uObrERh7O5m/tO3bbgEPeF2D//vC4kHTLQuQGbgpZSqU3C+WUJ86nQNptlraZZtek2tdLYoqREXuN8xy3swo9RVO3EL0VrmnhSQfuOl89AQdB04t89/1O/w1cDnyilFU=');

class BotController extends Controller
{
    public function index()
    {
        $logger = new Logger('LineBot');
        $logger->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));

        // เชื่อมต่อกับ LINE Messaging API
        $httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
        $bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));

        if (!isset($_SERVER["HTTP_" . HTTPHeader::LINE_SIGNATURE])) {
            error_log("Signature header missing");
            responseBadRequest('Signature header missing');
        }
        $signature = $_SERVER["HTTP_" . HTTPHeader::LINE_SIGNATURE];

        // คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
        $content = file_get_contents('php://input');

        try {
            $events = $bot->parseEventRequest($content, $signature);
        } catch(\LINE\LINEBot\Exception\InvalidSignatureException $e) {
            error_log('parseEventRequest failed. InvalidSignatureException => '.var_export($e, true));
        } catch(\LINE\LINEBot\Exception\UnknownEventTypeException $e) {
            error_log('parseEventRequest failed. UnknownEventTypeException => '.var_export($e, true));
        } catch(\LINE\LINEBot\Exception\UnknownMessageTypeException $e) {
            error_log('parseEventRequest failed. UnknownMessageTypeException => '.var_export($e, true));
        } catch(\LINE\LINEBot\Exception\InvalidEventRequestException $e) {
            error_log('parseEventRequest failed. InvalidEventRequestException => '.var_export($e, true));
        }

        foreach ($events as $event) {
            if (($event instanceof \LINE\LINEBot\Event\PostbackEvent)) {
                $logger->info('Postback message has come');
                $outputText = new TextMessageBuilder($event->getPostbackData());
                $bot->replyMessage($event->getReplyToken(), $outputText);
                continue;
            }
            if (($event instanceof \LINE\LINEBot\Event\MessageEvent\TextMessage)) {
                // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
                $replyToken = $event->getReplyToken();
                //$replyInfo = $events['events']['type'];
                $userId = $event->getUserId();
                $typeMessage = $event->getMessageType();
                $userMessage = $event->getText();

                //------ SET VAR ---------
                $pos1= strrpos($userMessage, 'หรม');
                $pos2= strrpos($userMessage, 'ครน');

                //------ RICH MENU -------
                if($userMessage=="เปลี่ยนวิชา"){
                    $imageMapUrl = 'https://github.com/anan211139/NECTECinternship/blob/master/img/final_subject.png?raw=true';
                    $replyData = new ImagemapMessageBuilder(
                        $imageMapUrl,
                        "รายการวิชา",
                        new BaseSizeBuilder(546,1040),
                        array(
                        new ImagemapMessageActionBuilder(
                            "วิชาคณิตศาสตร์",
                            new AreaBuilder(91,199,873,155)
                        ),
                        new ImagemapMessageActionBuilder(
                            "วิชาภาษาอังกฤษ",
                            new AreaBuilder(87,350,873,155)
                        ),
                    ));
                }
                else if($userMessage=="เปลี่ยนหัวข้อ"||$userMessage=="วิชาคณิตศาสตร์"){

                    $imageMapUrl = 'https://github.com/anan211139/NECTECinternship/blob/master/img/final_lesson.png?raw=true';
                    $replyData = new ImagemapMessageBuilder(
                        $imageMapUrl,
                        'หัวข้อที่ต้องการเรียน',
                        new BaseSizeBuilder(546,1040),
                            array(
                                new ImagemapMessageActionBuilder(
                                    'สมการ',
                                    new AreaBuilder(91,199,873,155)
                                ),
                                new ImagemapMessageActionBuilder(
                                    'หรม./ครน.',
                                    new AreaBuilder(87,350,873,155)
                                ),
                    ));
                }
                else if($userMessage =="ดูคะแนน"){

                    
                    $textReplyMessage = "น้องๆมีคะแนนทั้งหมด 1 คะแนน";
                    $replyData = new TextMessageBuilder($textReplyMessage);

                }
                else if($userMessage =="สะสมแต้ม"){
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
                            'ตอนนี้น้องๆมีแต้มทั้งหมด >>'.$point_st.'แต้มจ้า', // กำหนดรายละเอียด
                            'https://github.com/anan211139/NECTECinternship/blob/master/img/score.png?raw=true/700', // กำหนด url รุปภาพ
                            $actionBuilder  // กำหนด action object
                        )                           

                    );
                }
                else if($userMessage =="แลกของรางวัล"){
                    
                    $re_prizes = Prize::all()->toArray();
                    $columnTemplateBuilders = array();
                    foreach ($re_prizes as $prize) {
                        $columnTemplateBuilder = new CarouselColumnTemplateBuilder(
                            $prize['name'], 
                            'ใช้ '.$prize['point'].' แต้มในการแลก',
                            'https://pkwang.herokuapp.com/'.$prize['local_pic'], 
                            [
                                new PostbackTemplateActionBuilder('แลก', $prize['id'])
                            ,]
                        );
                        array_push($columnTemplateBuilders, $columnTemplateBuilder);
                    }

                    $carouselTemplateBuilder = new CarouselTemplateBuilder($columnTemplateBuilders);
                    $replyData = new TemplateMessageBuilder('รายการ Sponser', $carouselTemplateBuilder);
            
                }
                else if($userMessage =="ดู Code"){
                    $arr_replyData = array();
                    
                    $connectChild ='https://pkwang.herokuapp.com/connectchild/'.$userId;
                    $dataQR = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$connectChild.'&choe=UTF-8';

                    $arr_replyData[] = new TextMessageBuilder($connectChild);

                    //------QR CODE-----------

                    $picFullSize = $dataQR;
                    $picThumbnail = $dataQR.'/240';

                    $arr_replyData[] = new ImageMessageBuilder($picFullSize,$picThumbnail);


                    //--------REPLY----------
                    $multiMessage = new MultiMessageBuilder;
                    foreach($arr_replyData as $arr_Reply){
                            $multiMessage->add($arr_Reply);
                    }
                    $replyData = $multiMessage;

                    //--------INSERT AND CHECK DB--------
                    $checkIMG = DB::table('students')
                        ->where('line_code', $userId)
                        ->count();

                    if($checkIMG==0){
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

                }
                else if($userMessage =="เกี่ยวกับพี่หมี"){
                    $arr_replyData = array();
                    $textReplyMessage = "\t  สวัสดีครับน้องๆ พี่มีชื่อว่า \" พี่หมีติวเตอร์ \" ซึ่งพี่หมีจะมาช่วยน้องๆทบทวนบทเรียน\n\t โดยจะมาเป็นติวเตอร์ส่วนตัวให้กับน้องๆ ซึ่งน้องๆสามารถเลือกบทเรียนได้เอง \n\t  จะทบทวนบทเรียนตอนไหนก็ได้ตามความสะดวก ในการทบทวนบทเรียนในเเต่ละครั้ง \n\t  พี่หมีจะมีการเก็บคะแนนน้องๆไว้ เพื่อมอบของรางวัลให้น้องๆอีกด้วย \n\t  เห็นข้อดีอย่างนี้เเล้ว น้องๆจะรออะไรอยู่เล่า มาเริ่มทบทวนบทเรียนกันเถอะ!!!";
                    $arr_replyData[] = new TextMessageBuilder($textReplyMessage);

                    $textReplyMessage = "https://www.youtube.com/embed/Yad6t_EgwVw";
                    $arr_replyData[] = new TextMessageBuilder($textReplyMessage);

                    $multiMessage =     new MultiMessageBuilder;
                    foreach($arr_replyData as $arr_Reply){
                            $multiMessage->add($arr_Reply);
                    }
                    $replyData = $multiMessage;

                }
                //------ หรม./ครน. -------
                else if($pos1 !== false||$pos2!== false){
                    $checkGroup_chap = DB::table('groups')
                        ->where('line_code', $userId)
                        ->where('subject_id',1)
                        ->where('chapter_id',2)
                        ->where('status','false')
                        ->orderBy('id','DESC')
                        ->count();

                    if($checkGroup_chap==0){
                        DB::table('groups')->insert([
                            'line_code' => $userId, 
                            'subject_id' => 1,
                            'chapter_id' => 2,
                            'status' => false
                        ]);
                        
                        $textReplyMessage = "ยินดีต้อนรับน้องๆเข้าสู่บทเรียน\nเรื่อง หรม.ครน.\nเรามาเริ่มกันที่ข้อแรกกันเลยจ้า";
                        $arr_replyData[] = new TextMessageBuilder($textReplyMessage); 
                    }                
                    else{
                        $textReplyMessage = "เรามาเริ่มบทเรียน\nเรื่อง หรม.ครน.\n กันต่อเลยจ้า";
                        $arr_replyData[] = new TextMessageBuilder($textReplyMessage); 
                    }

                    $num_group = Group::where('line_code', $userId)
                    ->orderBy('id','DESC')
                    ->first();
        
                    $num_quiz = $num_group['id'];// เลข Group

                    $count_quiz = DB::table('logChildrenQuizzes')
                        ->where('group_id', $num_group['id'])
                        ->count();

                    $num_quiz = $count_quiz;//เลขข้อทั้งหมด

                    $count_quiz_true = DB::table('logChildrenQuizzes')
                        ->where('group_id', $num_group['id'])
                        ->where('is_correct',true)
                        ->count();

                    $num_quiz = $count_quiz_true;


                    //$num_quiz = $this ->randQuiz();

                    $textReplyMessage = "ข้อที่ ".$num_quiz;
                    $arr_replyData[] = new TextMessageBuilder($textReplyMessage); 

                    $multiMessage =     new MultiMessageBuilder;
                    foreach($arr_replyData as $arr_Reply){
                            $multiMessage->add($arr_Reply);
                    }
                    $replyData = $multiMessage;
                }
                //------ สมการ -------
                else if($userMessage =="สมการ"){

                    $arr_replyData = array();


                    $checkGroup_chap = DB::table('groups')
                        ->where('line_code', $userId)
                        ->where('subject_id',1)
                        ->where('chapter_id',1)
                        ->where('status','false')
                        ->orderBy('id','DESC')
                        ->count();

                    if($checkGroup_chap==0){
                        DB::table('groups')->insert([
                            'line_code' => $userId, 
                            'subject_id' => 1,
                            'chapter_id' => 1,
                            'status' => false
                        ]);
                        
                        $textReplyMessage = "ยินดีต้อนรับน้องๆเข้าสู่บทเรียน\nเรื่องสมการ\nเรามาเริ่มกันที่ข้อแรกกันเลยจ้า";
                    }                
                    else{
                        $textReplyMessage = "เรามาเริ่มบทเรียน\nเรื่องสมการ\n กันต่อเลยจ้า";
                    }
                    
                    $replyData = new TextMessageBuilder($textReplyMessage);
                }

                else if($userMessage =="โจทย์"){
                    $quizzesforsubj = DB::table('exams')
                                ->where('chapter_id', 1)->inRandomOrder()
                                ->first();
                    $pathtoexam = 'https://pkwang.herokuapp.com/'.$quizzesforsubj->local_pic;
                    $urgroup = DB::table('groups')
                        ->where('line_code', $userId)
                        ->where('status',false)
                        ->orderBy('id','DESC')
                        ->first();
                    DB::table('logChildrenQuizzes')->insertGetId([
                        'group_id' => $urgroup->id,
                        'exam_id' => $quizzesforsubj->id,
                        'time' => Carbon::now()
                    ]);
                    $replyData = new ImageMessageBuilder($pathtoexam,$pathtoexam);
                }
                else if($userMessage == '1' || $userMessage == '2' || $userMessage == '3' || $userMessage == '4') {
                    $urgroup = DB::table('groups')
                                ->where('line_code', $userId)
                                ->orderBy('id','DESC')
                                ->first();

                    $currentlog = DB::table('logChildrenQuizzes')
                                    ->where('group_id', $urgroup->id)
                                    ->orderBy('id','DESC')
                                    ->first();

                    $ans = DB::table('exams')
                            ->where('id', $currentlog->exam_id)
                            ->orderBy('id','DESC')
                            ->first();

                    $princ = DB::table('printciples')
                            ->where('id', $ans->principle_id)
                            ->first();
                    $princ_pic = $princ->local_pic;
                    $ans_status = $currentlog->is_correct;
                    $sec_chance = $currentlog->second_chance;
                    
                    $arr_replyData = array();

                    if($ans_status===null){
                        if ((int)$userMessage == $ans->answer) {
                            $textReplyMessage = "Correct!";
                            $ansst = true;
        
                            $arr_replyData[] = new TextMessageBuilder($textReplyMessage);
                            
                            DB::table('logChildrenQuizzes')
                                ->where('id', $currentlog->id)
                                ->update(['answer' => $userMessage, 'is_correct' => $ansst]);
                                
                        } else {
                            $textReplyMessage = "Wrong!";
                            $ansst = false;
        
                            $arr_replyData[] = new TextMessageBuilder($textReplyMessage);
                            
                            DB::table('logChildrenQuizzes')
                                ->where('id', $currentlog->id)
                                ->update(['answer' => $userMessage, 'is_correct' => $ansst]);
                        
        
                            $pathtoprinc = 'https://pkwang.herokuapp.com/'.$princ_pic.'/';
                            $arr_replyData[] = new ImageMessageBuilder($pathtoprinc,$pathtoprinc);
        
                            $arr_replyData[] = new TextMessageBuilder("น้องๆลองตอบใหม่อีกครั้งสิจ๊ะ");
        
                        }
                    }
                    else if($ans_status ==false && $sec_chance ==false){                            

                        if ((int)$userMessage == $ans->answer) {
                            $textReplyMessage = "Correct!";
                            $ansst = true;
                            $arr_replyData[] = new TextMessageBuilder($textReplyMessage);
                            
                            
                        } else {
                            $textReplyMessage = "Wrong!";
                            $ansst = false;
                            $arr_replyData[] = new TextMessageBuilder($textReplyMessage); 
                            
                        }
                        DB::table('logChildrenQuizzes')
                                ->where('id', $currentlog->id)
                                ->update(['second_chance' => true,'is_correct_secound' => $ansst]);
                    }

                    $multiMessage =     new MultiMessageBuilder;
                    foreach($arr_replyData as $arr_Reply){
                            $multiMessage->add($arr_Reply);
                    }
                    $replyData = $multiMessage;

                    
                }
                
                else if($userMessage=="content"){
                    
                    $replyData = new TextMessageBuilder($content);
                }
                else if($userMessage=="สุ่ม"){
                    
                    $data = $this ->randQuiz(5);
                    $replyData = new TextMessageBuilder($data);
                    
                }

                else{
                    $replyData = new TextMessageBuilder("พี่หมีไม่ค่อยเข้าใจคำว่า \"".$userMessage."\" พี่หมีขอโทษนะ");
                }
                // ส่วนของคำสั่งตอบกลับข้อความ
                $response = $bot->replyMessage($replyToken,$replyData);
            }
        }
    }
    

    public function randQuiz(){
        $insert_status = false;
        while( $insert_status == false ){ //วนไรเรื่อยจนกว่าจะใส่ข้อมูลได้
            $quizzesforsubj = Exam::inRandomOrder()
                ->select('id')
                ->where('chapter_id', 1)
                ->where('level_id',1)
                ->first();

            $group_r = DB::table('groupRandoms')
                ->where('listexamid', 'like', '%' .$quizzesforsubj['id'] . ',%')
                ->count();

                        
            // dd($group_r);

            if($group_r == 0){  //check ไม่ซ้ำ 
            // echo 'true';

                $group_r = DB::table('groupRandoms')
                    ->where('group_id', 1)
                    ->first();
            
                $group_rand = $group_r->listexamid;
        
                $concat_quiz = $group_rand.$quizzesforsubj['id'].',';
        
                $new_quiz= DB::table('groupRandoms')
                    ->where('group_id', 1)
                    ->update(['listexamid' => $concat_quiz]);

                $insert_status = true;
            
            }
        }

        return $quizzesforsubj['id'];


        // $va += 2;

        // $replyData = new TextMessageBuilder("สุ่มไปแล้ว");

        // echo "perfect";
        // return $va;
    }


    
    //use this function after the student pick their own lesson
    public function start_exam($userId, $subject_id, $chapter_id) {
        $old_group = DB::table('groups')
                        ->where('line_code', $userId)
                        ->orderBy('id','DESC')
                        ->first();
        //if student has non-finish old group
        if ($old_group->status === false) { //in the future, don't forget to check the expire date
            $old_log = DB::table('logChildrenQuizzes')
                            ->where('group_id', $old_group->id)
                            ->orderBy('id','DESC')
                            ->first();
            //if student still not answer the old exam
            if ($old_log->answer !== null) {
                $old_exam = DB::table('exams')
                                ->where('id', $old_log->exam_id)
                                ->first();
                $pathtoexam = 'https://pkwang.herokuapp.com/'.$old_exam->local_pic;
                $replyData = new ImageMessageBuilder($pathtoexam,$pathtoexam);
            }
            //if student has already answered the old exam then generate new exam in old group
            else {
                //$this->generate_exam();
            }
        }
        //if student has finished the old group or fist time create group
        else {
            DB::table('groups')->insert([
                'line_code' => $userId, 
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'status' => false
            ]);
            $textReplyMessage = "ยินดีต้อนรับน้องๆเข้าสู่บทเรียน\nเรื่อง ".$chapter_id->name."\nเรามาเริ่มกันที่ข้อแรกกันเลยจ้า";
        }
        $replyData = new TextMessageBuilder($textReplyMessage);
     }

}
