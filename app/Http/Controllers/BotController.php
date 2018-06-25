<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
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
use Carbon\Carbon;

define('LINE_MESSAGE_CHANNEL_ID', '1586241418');
define('LINE_MESSAGE_CHANNEL_SECRET', '40f2053df45b479807d8f2bba1b0dbe2');
define('LINE_MESSAGE_ACCESS_TOKEN', 'VjNScyiNVZFTg96I4c62mnCZdY6bqyllIaUZ4L3NHg5uObrERh7O5m/tO3bbgEPeF2D//vC4kHTLQuQGbgpZSqU3C+WUJ86nQNptlraZZtek2tdLYoqREXuN8xy3swo9RVO3EL0VrmnhSQfuOl89AQdB04t89/1O/w1cDnyilFU=');

class BotController extends Controller
{

    //public count = 0;

    public function index() {
        // เชื่อมต่อกับ LINE Messaging API
        $httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
        $bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));

        // คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
        $content = file_get_contents('php://input');

        // แปลงข้อความรูปแบบ JSON  ให้อยู่ในโครงสร้างตัวแปร array
        $events = json_decode($content, true);
        if(!is_null($events)){
            // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
            $replyToken = $events['events'][0]['replyToken'];
        }
        // ส่วนของคำสั่งจัดเตียมรูปแบบข้อความสำหรับส่ง
        $textMessageBuilder = new TextMessageBuilder(json_encode($events));
        //l ส่วนของคำสั่งตอบกลับข้อความ
        $response = $bot->replyMessage($replyToken,$textMessageBuilder);
        if ($response->isSucceeded()) {
            echo 'Succeeded!';
            return;
        }

        // Failed
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }

    public function anan()
    {
        // เชื่อมต่อกับ LINE Messaging API
        $httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
        $bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));

        // คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
        $content = file_get_contents('php://input');
        echo "A";
        echo $content;

        //$count = 0;

        // $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('<channel access token>');
        // $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '<channel secret>']);


        // $response = $bot->getProfile('U038940166356c6b9fb0dcf051aded27f');
        // if ($response->isSucceeded()) {
        //     $profile = $response->getJSONDecodedBody();
        //     echo $profile['displayName'];
        //     echo $profile['pictureUrl'];
        //     echo $profile['statusMessage'];
        // }


        $events = json_decode($content, true);
        if(!is_null($events)){
            //echo $events;
            // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
            $replyToken = $events['events'][0]['replyToken'];
            //$replyInfo = $events['events']['type'];
            $userId = $events['events'][0]['source']['userId'];
            $typeMessage = $events['events'][0]['message']['type'];
            $userMessage = $events['events'][0]['message']['text'];


            //------ SET VAR ---------
            $pos1= strrpos($userMessage, 'หรม');
            $pos2= strrpos($userMessage, 'ครน');
            //$userMessage = strtolower($userMessage);


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

                // $urgroup = DB::table('groups')
                //     ->where('line_code', $userId)
                //     ->orderBy('id','DESC')
                //     ->first();
                // $group_id = $urgroup->id;

                $score=DB::table('students')
                               //->select('point')
                               ->where('line_code', $userId)
                               ->first();
                $point_st = $score->point;
                //echo $point;
                $textReplyMessage = $point_st;
                $replyData = new TextMessageBuilder($textReplyMessage);
            }
            else if($userMessage =="สะสมแต้ม"){
                //$textReplyMessage = "ตอนนี้แต้มของน้องๆคือ >> 1 แต้มจ้า";
                $actionBuilder = array(
                    new MessageTemplateActionBuilder(
                        'แลกของรางวัล', // ข้อความแสดงในปุ่ม
                        'แลกของรางวัล'
                    )
                );

                $replyData = new TemplateMessageBuilder('Button Template',
                    new ButtonTemplateBuilder(
                        'ดูแต้มกันดีกว่า', // กำหนดหัวเรื่อง
                        'ตอนนี้แต้มของน้องๆคือ >> 1 แต้มจ้า', // กำหนดรายละเอียด
                        'https://github.com/anan211139/NECTECinternship/blob/master/img/score.png?raw=true/700', // กำหนด url รุปภาพ
                        $actionBuilder  // กำหนด action object
                    )                           

                );
            }
            else if($userMessage =="แลกของรางวัล"){
                $actionBuilder = array(
                    new MessageTemplateActionBuilder(
                        'แลก',// ข้อความแสดงในปุ่ม
                        'แลก' // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                    ),
                    // new UriTemplateActionBuilder(
                    //     'Uri Template', // ข้อความแสดงในปุ่ม
                    //     'https://www.ninenik.com'
                    // ),
                    // new PostbackTemplateActionBuilder(
                    //     'Postback', // ข้อความแสดงในปุ่ม
                    //     http_build_query(array(
                    //         'action'=>'buy',
             
                    //         'item'=>100
                    //     )), // ข้อมูลที่จะส่งไปใน webhook ผ่าน postback event
                    //     'Postback Text'  // ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                    // ),      
                );
                $replyData = new TemplateMessageBuilder('Carousel',
                    new CarouselTemplateBuilder(
                        array(
                            new CarouselColumnTemplateBuilder(
                                'Sponsor',
                                'ใช้ 100 แต้ม เพื่อแลกของรางวัล',
                                'https://github.com/anan211139/NECTECinternship/blob/master/img/Untitled-1.png?raw=true/700',
                                $actionBuilder
                            ),
                            new CarouselColumnTemplateBuilder(
                                'Sponsor',
                                'ใช้ 400 แต้ม เพื่อแลกของรางวัล',
                                'https://github.com/anan211139/NECTECinternship/blob/master/img/Untitled-1.png?raw=true/700',
                                $actionBuilder
                            ),
                            new CarouselColumnTemplateBuilder(
                                'Sponsor',
                                'ใช้ 1000 แต้ม เพื่อแลกของรางวัล',
                                'https://github.com/anan211139/NECTECinternship/blob/master/img/Untitled-1.png?raw=true/700',
                                $actionBuilder
                            ),                                          
                        )
                    )
                );
            }
            else if($userMessage =="ดู Code"){
                //$textReplyMessage = $userId;
                $arr_replyData = array();
                
                $connectChild ='https://pkwang.herokuapp.com/connectchild/'.$userId;
                $dataQR = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$connectChild.'&choe=UTF-8';

                $arr_replyData[] = new TextMessageBuilder($connectChild);

                //------QR CODE-----------

                $picFullSize = $dataQR;
                $picThumbnail = $dataQR.'/240';

                $arr_replyData[] = new ImageMessageBuilder($picFullSize,$picThumbnail);


                //--------REPLY----------
                $multiMessage =     new MultiMessageBuilder;
                foreach($arr_replyData as $arr_Reply){
                        $multiMessage->add($arr_Reply);
                }
                $replyData = $multiMessage;


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
            //------ สมการ -------
            else if($userMessage =="สมการ"){
                $textReplyMessage = "ยินดีต้อนรับน้องๆเข้าสู่บทเรียน\nเรื่องสมการ\nเรามาเริ่มกันที่ข้อแรกกันเลยจ้า";
                $replyData = new TextMessageBuilder($textReplyMessage);
            }
            else if($userMessage =="สร้างข้อสอบ"){
                DB::table('groups')->insert([
                    'line_code' => $userId, 
                    'subject_id' => 1,
                    'chapter_id' => 1,
                    'status' => false
                ]);
                $textReplyMessage = "พี่หมีสร้างชุดข้อสอบให้แล้วนะจ้ะ";
                $replyData = new TextMessageBuilder($textReplyMessage);
            }
            else if($userMessage =="โจทย์"){
                $quizzesforsubj = DB::table('exams')
                               ->where('chapter_id', 1)->inRandomOrder()
                               ->first();
                $pathtoexam = 'https://pkwang.herokuapp.com/'.$quizzesforsubj->local_pic;
                $urgroup = DB::table('groups')->where('line_code', $userId)->first();
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
                //dd( $urgroup);
                $currentlog = DB::table('logChildrenQuizzes')
                                ->where('group_id', $urgroup->id)
                                // ->whereNull('is_correct')
                                ->orderBy('id','DESC')
                                ->first();
                //dd($currentlog);
                $ans = DB::table('exams')
                        ->where('id', $currentlog->exam_id)
                        ->orderBy('id','DESC')
                        ->first();
                //echo $ans;
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

                    // DB::table('logChildrenQuizzes')
                    //     ->where('id', $currentlog->id)
                    //     ->update(['second_chance' => true]);
                            

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
            //------ หรม./ครน. -------
            else if($pos1 !== false||$pos2!== false){
                $textReplyMessage = "ยินดีต้อนรับน้องๆเข้าสู่บทเรียน\nเรื่องหรม/ครน.\nเรามาเริ่มกันที่ข้อแรกกันเลยจ้า";
                $replyData = new TextMessageBuilder($textReplyMessage);
            }
            else if($userMessage=="events"){
                
                $replyData = new TextMessageBuilder($content);
            }
             else{
                $replyData = new TextMessageBuilder("พี่หมีไม่ค่อยเข้าใจคำว่า \"".$userMessage."\" พี่หมีขอโทษนะ");
            }
        }
        // ส่วนของคำสั่งตอบกลับข้อความ
        $response = $bot->replyMessage($replyToken,$replyData);
    }

    public function generate_exam(){
        $urgroup = DB::table('groups')
            ->where('line_code', $userId)
            ->orderBy('id','DESC')
            ->first();
        $group_id = $urgroup->id;

        $quiz_easy = DB::table('exams')
            ->where('level_id', '1')
            ->count();
        $quiz_med = DB::table('exams')
            ->where('level_id', '2')
            ->count();
        $quiz_hard = DB::table('exams')
            ->where('level_id', '3')
            ->count();
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
