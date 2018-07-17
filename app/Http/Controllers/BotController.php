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
            $replyToken = $events['events'][0]['replyToken'];
            //$replyInfo = $events['events']['type'];
            $userId = $events['events'][0]['source']['userId'];
            $typeMessage = $events['events'][0]['message']['type'];
            $userMessage = $events['events'][0]['message']['text'];
        
        
            // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
            // $replyToken = $event->getReplyToken();
            // //$replyInfo = $events['events']['type'];
            // $userId = $event->getUserId();
            // $typeMessage = $event->getMessageType();
            // $userMessage = $event->getText();

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

                $group_true = DB::table('groups')
                    ->where('line_code', $userId)
                    ->where('status',true)
                    ->orderBy('id','DESC')
                    ->first();
                // dd($group_true);
                $group_result = DB::table('results')
                    ->where('group_id',$group_true->id)
                    ->get();

                $concat_result = "";

                
                foreach ($group_result as $g_result) {
                    $concat_result = $concat_result.$text_result;
                    if($g_result->level_id == 1){
                        $text_result = "ระดับง่าย >".$g_result->total_level_true."จากทั้งหมด".$g_result->total_level."\n";
                    }
                    else if($g_result->level_id == 2){
                        $text_result = "ระดับกลาง >".$g_result->total_level_true."จากทั้งหมด".$g_result->total_level."\n";
                    }
                    else if($g_result->level_id == 3){
                        $text_result = "ระดับยาก >".$g_result->total_level_true."จากทั้งหมด".$g_result->total_level."\n";
                    }
                    else{
                        $text_result = "ยังไม่มีคะแนนสอบชุดล่าสุด";
                    }
                }
                

                $textReplyMessage = $concat_result;
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
                            new PostbackTemplateActionBuilder('แลก', http_build_query(array('action'=>'exchange', 'id'=>$prize['id'])))
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
                $arr_replyData = $this->start_exam($userId, 1, 2);
                $multiMessage = new MultiMessageBuilder;
                foreach($arr_replyData as $arr_Reply){
                        $multiMessage->add($arr_Reply);
                }
                $replyData = $multiMessage;
            }
            //------ สมการ -------
            else if($userMessage =="สมการ") {
                $arr_replyData = $this->start_exam($userId, 1, 1);
                $multiMessage = new MultiMessageBuilder;
                foreach($arr_replyData as $arr_Reply){
                    $multiMessage->add($arr_Reply);
                }
                $replyData = $multiMessage;
            }
            else if($userMessage == '1' || $userMessage == '2' || $userMessage == '3' || $userMessage == '4') {
                $multiMessage = new MultiMessageBuilder;
                $urgroup = DB::table('groups')
                            ->where('line_code', $userId)
                            ->orderBy('id','DESC')
                            ->first();
                $currentlog = DB::table('logChildrenQuizzes')
                    ->where('group_id', $urgroup->id)
                    ->orderBy('id','DESC')
                    ->first();
                // dd($currentlog);
                DB::table('groups')
                    ->where('id', $currentlog->id)
                    ->update(['3day' => Carbon::now()->addDays(3)]);

                $ans = DB::table('exams')
                        ->where('id', $currentlog->exam_id)
                        ->orderBy('id','DESC')
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

                if($ans_status === null){
                    echo "Yeah";
                    if ((int)$userMessage == $ans->answer) {
                        $arr_replyData[] = new TextMessageBuilder("Correct!");
                        $ansst = true;

                        if ($count_quiz < 20) {
                            foreach($arr_replyData as $arr_Reply){
                                $multiMessage->add($arr_Reply);
                            }
                            $arr_replyData = $this->randQuiz($ans->chapter_id, $ans->level_id, $urgroup->id);
                            foreach($arr_replyData as $arr_Reply){
                                $multiMessage->add($arr_Reply);
                            }
                            $arr_replyData = array();
                        }
                        else {
                        DB::table('groups')
                            ->where('id', $urgroup->id)
                            ->update(['status' => true]);
                            //call result function
                            $arr_replyData[] = new TextMessageBuilder("Close group");
                        }

                    } else {
                        $arr_replyData[] = new TextMessageBuilder("Wrong!");
                        $ansst = false;

                        $pathtoprinc = 'https://pkwang.herokuapp.com/'.$princ_pic.'/';
                        $arr_replyData[] = new ImageMessageBuilder($pathtoprinc,$pathtoprinc);
                        $arr_replyData[] = new TextMessageBuilder("น้องลองตอบใหม่อีกครั้งสิจ๊ะ");

                    }

                    DB::table('logChildrenQuizzes')
                        ->where('id', $currentlog->id)
                        ->update(['answer' => $userMessage, 'is_correct' => $ansst, 'time' => Carbon::now()]);

                }
                else if($ans_status ==false && $sec_chance ==false){
                    echo "Round2";
                    if ((int)$userMessage == $ans->answer) {
                        $textReplyMessage = "Correct!";
                        $ansst = true;
                        echo "T";
                    } else {
                        $textReplyMessage = "Wrong!";
                        $ansst = false;
                        echo "F";
                    }
                    $arr_replyData[] = new TextMessageBuilder($textReplyMessage);
                    DB::table('logChildrenQuizzes')
                            ->where('id', $currentlog->id)
                            ->update(['second_chance' => true,'is_correct_secound' => $ansst]);
                    echo "before check <20";
                    if ($count_quiz < 20) {
                        foreach($arr_replyData as $arr_Reply){
                            $multiMessage->add($arr_Reply);
                        }
                        $arr_replyData = $this->randQuiz($ans->chapter_id, $ans->level_id, $urgroup->id);
                    }
                    else {
                    DB::table('groups')
                        ->where('id', $urgroup->id)
                        ->update(['status' => true]);
                        //call result function
                        $arr_replyData[] = new TextMessageBuilder("Close group");
                    }

                }

                // $multiMessage = new MultiMessageBuilder;
                foreach($arr_replyData as $arr_Reply){
                        $multiMessage->add($arr_Reply);
                }
                $replyData = $multiMessage;
            }

            else if($userMessage=="content"){

                $replyData = new TextMessageBuilder($content);
            }

            else{
                $replyData = new TextMessageBuilder("พี่หมีไม่ค่อยเข้าใจคำว่า \"".$userMessage."\" พี่หมีขอโทษนะ");
            }
            // ส่วนของคำสั่งตอบกลับข้อความ
            $response = $bot->replyMessage($replyToken,$replyData);
            
        }
    }


    public function randQuiz($chapter_id, $level_id, $group_id){
        echo "into Rand";
        //check changing level
        $num_group = DB::table('groups')
            ->where('id', $group_id)
            ->orderBy('id','DESC')
            ->first();
        
        $count_quiz = DB::table('logChildrenQuizzes')
            ->where('group_id', $group_id)
            ->count();
        // dd($count_quiz) ;
        if ($count_quiz % 5 == 0) {
            

            $count_quiz_true = DB::table('logChildrenQuizzes')
                ->where('group_id', $group_id)
                ->offset($count_quiz-5)
                ->limit(5)
                ->get();
            echo "CQ";
                //dd($count_quiz_true);
            $count_num_true=0;
            foreach ($count_quiz_true as $count_true) {
                if($count_true->is_correct === true){
                    $count_num_true++;
                    echo "*";
                    //dd($count_true);
                }
                else{
                    echo "+";
                }
            }
            echo "CT>>";
            echo $count_num_true;

            echo "LEVEL_BF>>";
            echo $level_id;
            if ($count_num_true >= 3 && $level_id < 3) {
                $level_id = $level_id + 1;
                echo "VU";
            }
            else if ($count_num_true < 3 && $level_id > 1) {
                $level_id = $level_id - 1;
                echo "VD";
            }
            echo "\nLEVEL_ID IS".$level_id;


            //dd($count_quiz_true);

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
    public function start_exam($userId, $subject_id, $chapter_id) {
        $arr_replyData = array();
        $current_chapter = DB::table('chapters')
            ->where('id', $chapter_id)
            ->first();
        // dd($current_chapter);
        $old_group_count = DB::table('groups')
            ->where('line_code', $userId)
            ->where('subject_id', $subject_id)
            ->where('chapter_id', $chapter_id)
            ->orderBy('id','DESC')
            ->count();
        $old_group = DB::table('groups')
            ->where('line_code', $userId)
            ->where('subject_id', $subject_id)
            ->where('chapter_id', $chapter_id)
            ->orderBy('id','DESC')
            ->first();

        // if student has finished the old group or fist time create group
        if ($old_group_count == 0 || $old_group->status === true) {
            $group_id = DB::table('groups')->insertGetId([ //create new group
                'line_code' => $userId,
                'subject_id' => $subject_id,
                'chapter_id' => $chapter_id,
                'status' => false,
                '3day' => Carbon::now()->addDays(3),
                '7day' => Carbon::now()->addDays(7)
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
        // echo $group_id;
        // dd($current_log);
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

            DB::table('results')->insert([
                'line_code' => $current_group->line_code,
                'group_id' => $group_id,
                'level_id' => $level_id,
                'total_level' => $total_exam,
                'total_level_true' => $total_true
            ]);

            return "group: ". $group_id .", lvl: ". $level_id . ", total_exam: " . $total_exam . ", total_true: ". $total_true;

     }


public function notification(){

  $httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
  $bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));}
}
