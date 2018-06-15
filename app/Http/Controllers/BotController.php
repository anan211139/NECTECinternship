<?php

namespace App\Http\Controllers;

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
            else if($userMessage =="สะสมแต้ม"){
                $textReplyMessage = "ตอนนี้แต้มของน้องๆคือ >> 1 แต้มจ้า";
                $replyData = new TextMessageBuilder($textReplyMessage);
            }
            else if($userMessage =="ดู Code"){
                //$textReplyMessage = $userId;
                $replyData = new TextMessageBuilder($userId);
            }
            else if($userMessage =="เกี่ยวกับพี่หมี"){
                $textReplyMessage = "        ท่ามกลางป่าอันเงียบสงบแห่งหนึ่ง มีหมีอยู่สองตัว ซึ่งกำลังจะต่อสู้กันเพื่อแย่งชิงความเป็นใหญ่ โดยพวกมันตกลงกันไว้ว่าหากใครเป็นผู้ชนะจะได้เป็นพี่หมีติวเตอร์ แต่ผู้แพ้นั้นจะต้องถูกขับไล่ออกไปเรียนใหม่
                เมื่อวันต่อสู้มาถึงหมีทั้งสองต่างก็ใช้ความรู้ตัวเองกันอย่างเอาเป็นเอาตายแบบไม่คิดชีวิตกันเลยทีเดียว และผลของการต่อสู้ก็จบลงโดยมีฝ่ายหนึ่งชนะและอีกฝ่ายหนึ่งแพ้ ซึ่งหมีตัวที่ชนะก็ดีใจและฮึกเหิมเป็นอย่างยิ่งที่ตัวมันแข็งแรงและเก่งกล้าจนสามารถเอาชนะอีกฝ่ายหนึ่งได้
                
                เมื่อได้รับชัยชนะแล้วมันก็พยายามที่จะปีนขึ้นไปบนเนินเขาเล็กๆ พร้อมกับสงเสียงดังง เพื่อเป็นการประกาศว่าบัดนี้มันได้กลายเป็นผู้นำของฝูงหมีแล้ว และทันใดนั้นเองก็มีนกอินทรีตัวหนึ่งบินผ่านมาเห็นเข้า มันจึงบินโฉบลงมาด้วยความรวดเร็วและคว้าหมีผู้ชนะไปกินเป็นอาหารในทันที";
                $replyData = new TextMessageBuilder($textReplyMessage);
            }
            else{
                //$textReplyMessage = "Bot ตอบกลับคุณเป็นข้อความ";
                $replyData = new TextMessageBuilder($userMessage);
                //$replyData = new TextMessageBuilder($count);
            }
        }
        //l ส่วนของคำสั่งตอบกลับข้อความ
        $response = $bot->replyMessage($replyToken,$replyData);
    }
}
