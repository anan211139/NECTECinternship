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
echo "A";
echo $content;
 
$events = json_decode($content, true);

echo $events;
if(!is_null($events)){
    // ถ้ามีค่า สร้างตัวแปรเก็บ replyToken ไว้ใช้งาน
    $replyToken = $events['events'][0]['replyToken'];
    $userId = $events['events'][0]['userId'];
    $typeMessage = $events['events'][0]['message']['type'];
    $userMessage = $events['events'][0]['message']['text'];
    //$userMessage = strtolower($userMessage);
    // ------ RICH MENU -------
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
    else if($userMessage=="ดูคะแนน"){
        $textReplyMessage = "คะแนนของน้องๆคือ >> 1 คะแนนจ้า";
        $replyData = new TextMessageBuilder($userMessage);
    }
    else if($userMessage=="สะสมแต้ม"){
        $textReplyMessage = "ตอนนี้แต้มของน้องๆคือ >> 1 แต้มจ้า";
        $replyData = new TextMessageBuilder($userMessage);
    }
    else if($userMessage=="ดู Code"){
        $textReplyMessage = $userId;
        $replyData = new TextMessageBuilder($userMessage);
    }
    // else if($userMessage=="a"){
    //     $imageMapUrl = 'https://github.com/anan211139/NECTECinternship/blob/master/img/edit_subject.png?raw=true';
    //     $replyData = new ImagemapMessageBuilder(
    //         $imageMapUrl,
    //         'แนะนำอาหาร',
    //         new BaseSizeBuilder(546,1024),
    //         array(
    //             new ImagemapMessageActionBuilder(
    //                 'ไม่กิน [อาหารบางชนิด] กินอะไรแทนดี?',
    //                 new AreaBuilder(0,40,346,333)
    //             ),
    //             new ImagemapMessageActionBuilder(
    //                 'ผลไม้ 1 ส่วนคือเท่าไร?',
    //                 new AreaBuilder(346,40,346,333)
    //             ),
    //         ));
    // }
    else{
        //$textReplyMessage = "Bot ตอบกลับคุณเป็นข้อความ";
        $replyData = new TextMessageBuilder($userMessage);
    }
}
//l ส่วนของคำสั่งตอบกลับข้อความ
$response = $bot->replyMessage($replyToken,$replyData);
