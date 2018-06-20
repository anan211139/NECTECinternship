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
use App\Quizzes;
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

            // $replyData = new TextMessageBuilder($replyInfo);
            //------ GREETING --------
            // if($count==0){
            //     $replyData = new TextMessageBuilder($count);
            //     $count = 1;
            // }
            //$count++;
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
                $textReplyMessage = "คะแนนของน้องๆคือ >> 1 คะแนนจ้า";
                $replyData = new TextMessageBuilder($textReplyMessage);

            }

            // else if($userMessage =="สะสมแต้ม"){
            //     $textReplyMessage = "ตอนนี้แต้มของน้องๆคือ >> 1 แต้มจ้า";
            //     $replyData = new TextMessageBuilder($textReplyMessage);

// --------------------------------------------------------------------------------
            else if($userMessage =="สะสมแต้ม"){
                //$textReplyMessage = "ตอนนี้แต้มของน้องๆคือ >> 1 แต้มจ้า";
                    $actionBuilder = array(
                        new MessageTemplateActionBuilder(
                            'แต้มสะสมของฉัน',// ข้อความแสดงในปุ่ม
                            'แต้มสะสมของฉัน'// ข้อความที่จะแสดงฝั่งผู้ใช้ เมื่อคลิกเลือก
                        ),
                        new MessageTemplateActionBuilder(
                            'แลกของรางวัล', // ข้อความแสดงในปุ่ม
                            'แลกของรางวัล'
                        ),
                    );

                $replyData = new TemplateMessageBuilder('Button Template',
                      new ButtonTemplateBuilder(
                'ดูแต้มกันดีกว่า', // กำหนดหัวเรื่อง
                'แต้ม', // กำหนดรายละเอียด
                NULL, // กำหนด url รุปภาพ
                $actionBuilder  // กำหนด action object
                                )                           

                    );

            }

            else if($userMessage =="ดู Code"){
                //$textReplyMessage = $userId;
                $arr_replyData = array();

                $dataQR = 'https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl='.$userId.'&choe=UTF-8';
                $connectChild ='https://pkwang.herokuapp.com/connectchild/'.$userId;
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
            else if($userMessage =="โจทย์"){
//                 $quizzesforsubj = DB::table('quizzes')
//                     ->where('subject', 'english')->first();
//                 $modelQuizzes = Quizzes::find()
//                                 ->where(['subject' => 'english'])
//                                 ->orderBy('sort')
//                                 ->first();
//                 $q1 = Quizzes::findOrFail(1);
                 $quizzesforsubj = DB::table('quizzes')
                               ->where('subject', 'english')->first();

               $textReplyMessage = $quizzesforsubj->question;
               // $textReplyMessage = $modelQuizzes->question;


                // $picFullSize = $dataQR;
                // $picThumbnail = $dataQR;

                // $arr_replyData[] = new ImageMessageBuilder($picFullSize,$picThumbnail);
                $pathtoq = asset($textReplyMessage);
                $replyData = new TextMessageBuilder($pathtoq);
            }
            //------ หรม./ครน. -------
            else if($pos1 !== false||$pos2!== false){
                $textReplyMessage = "ยินดีต้อนรับน้องๆเข้าสู่บทเรียน\nเรื่องหรม/ครน.\nเรามาเริ่มกันที่ข้อแรกกันเลยจ้า";
                $replyData = new TextMessageBuilder($textReplyMessage);
            }
             else{
                $replyData = new TextMessageBuilder("พี่หมีไม่ค่อยเข้าใจคำว่า \"".$userMessage."\" พี่หมีขอโทษนะ");
            }
        }
        // ส่วนของคำสั่งตอบกลับข้อความ
        $response = $bot->replyMessage($replyToken,$replyData);

    }
}
