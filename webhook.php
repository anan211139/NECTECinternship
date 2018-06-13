<?php // callback.php

require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');

use LINE\LINEBot;
use LINE\LINEBot\HTTPClient;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
//use LINE\LINEBot\Event;
//use LINE\LINEBot\Event\BaseEvent;
//use LINE\LINEBot\Event\MessageEvent;
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


define('LINE_MESSAGE_CHANNEL_ID','1586241418');
define('LINE_MESSAGE_CHANNEL_SECRET','40f2053df45b479807d8f2bba1b0dbe2');
define('LINE_MESSAGE_ACCESS_TOKEN','VjNScyiNVZFTg96I4c62mnCZdY6bqyllIaUZ4L3NHg5uObrERh7O5m/tO3bbgEPeF2D//vC4kHTLQuQGbgpZSqU3C+WUJ86nQNptlraZZtek2tdLYoqREXuN8xy3swo9RVO3EL0VrmnhSQfuOl89AQdB04t89/1O/w1cDnyilFU=');
 
// เชื่อมต่อกับ LINE Messaging API
$httpClient = new CurlHTTPClient(LINE_MESSAGE_ACCESS_TOKEN);
$bot = new LINEBot($httpClient, array('channelSecret' => LINE_MESSAGE_CHANNEL_SECRET));
 
// คำสั่งรอรับการส่งค่ามาของ LINE Messaging API
$content = file_get_contents('php://input');
 
$events = json_decode($content, true);
if(!is_null($events)){
    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $typeMessage = $events['events'][0]['message']['type'];
    $userMessage = $events['events'][0]['message']['text'];
    //$userMessage = strtolower($userMessage);
    // ------ RICH MENU -------
    if($userMessage=="เปลี่ยนวิชา"){
        $imageMapUrl = 'https://github.com/anan211139/NECTECinternship/blob/master/img/Sub.jpg?raw=true';
                    $replyData = new ImagemapMessageBuilder(
                        $imageMapUrl,
                        'รายการวิชา',
                        new BaseSizeBuilder(513,1040),
                        array(
                            new ImagemapMessageActionBuilder(
                                'วิชาคณิตศาสตร์',
                                new AreaBuilder(957,320,92,192)
                                ),
                            new ImagemapUriActionBuilder(
                                'วิชาภาษาอังกฤษ',
                                new AreaBuilder(953,453,88,325)
                                )
                        )); 
    }
//     switch ($typeMessage){
//         case 'text':
//             switch ($userMessage) {
//                 case "t":
//                     $textReplyMessage = "Bot ตอบกลับคุณเป็นข้อความ";
//                     $replyData = new TextMessageBuilder($textReplyMessage);
//                     break;
                
//                 case "เปลี่ยนวิชา":
//                     $imageMapUrl = 'https://github.com/anan211139/NECTECinternship/blob/master/img/Sub.jpg?raw=true';
//                     $replyData = new ImagemapMessageBuilder(
//                         $imageMapUrl,
//                         'รายการวิชา',
//                         new BaseSizeBuilder(513,1040),
//                         array(
//                             new ImagemapMessageActionBuilder(
//                                 'วิชาคณิตศาสตร์',
//                                 new AreaBuilder(957,320,92,192)
//                                 ),
//                             new ImagemapUriActionBuilder(
//                                 'วิชาภาษาอังกฤษ',
//                                 new AreaBuilder(953,453,88,325)
//                                 )
//                         )); 
//                     break;
//                 case "วิชาคณิตศาสตร์" || "เปลี่ยนหัวข้อ":
//                     $imageMapUrl = 'https://github.com/anan211139/NECTECinternship/blob/master/img/c_lesson_1.jpg?raw=true';
//                     $replyData = new ImagemapMessageBuilder(
//                         $imageMapUrl,
//                         'หัวข้อที่ต้องการเรียน',
//                         new BaseSizeBuilder(513,1040),
//                         array(
//                             new ImagemapMessageActionBuilder(
//                                 'สมการ',
//                                 new AreaBuilder(957,320,92,192)
//                                 ),
//                             new ImagemapUriActionBuilder(
//                                 'หรม./ครน.',
//                                 new AreaBuilder(953,453,88,325)
//                                 )
//                         )); 
//                     break;                                                                                                                                 
//                 default:
//                     $textReplyMessage = "ลองใหม่";
//                     $replyData = new TextMessageBuilder($textReplyMessage);
//                     break;                                     
//             }
//             break;
//         default:
//             $textReplyMessage = json_encode($events);
//             $replyData = new TextMessageBuilder($textReplyMessage);         
//             break;  
//     }
}
//l ส่วนของคำสั่งตอบกลับข้อความ
$response = $bot->replyMessage($replyToken,$replyData);
