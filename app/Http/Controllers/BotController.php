<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BotController extends Controller
{
    public function getmessage()
    {
        $httpClient = new CurlHTTPClient('VjNScyiNVZFTg96I4c62mnCZdY6bqyllIaUZ4L3NHg5uObrERh7O5m/tO3bbgEPeF2D//vC4kHTLQuQGbgpZSqU3C+WUJ86nQNptlraZZtek2tdLYoqREXuN8xy3swo9RVO3EL0VrmnhSQfuOl89AQdB04t89/1O/w1cDnyilFU=');
        $bot = new LINEBot($httpClient, array('channelSecret' => '40f2053df45b479807d8f2bba1b0dbe2'));
        //คำสั่งรอรับการส่งข้อควาามของ LINE MESSAGING API
        $content = file_get_contents('php://input');
        //แปลงข้อความรูปแปป JSON ให้อยู่ในรูปแบบ array
        $events =json_decode($content, true);
        if(!is_null($events)){
          //ถ้ามีคำ สร้างตัวแปรเก็บ replytoken ไว้ใช้งาน
          $replyToken = $events['events'][0]['replyToken'];
          $user = $events['events'][0]['source']['userId'];
          //$userMessage = $events['events'][0]['message']['text'];
          $type_message = $events['events'][0]['message']['type'];
        }
        $sequentsteps = (new SqlController)->$sequentsteps_seqcode($user);

        if ($type_message == 'text'){
            if(!is_null($events)){
              //ถ้ามีคำ สร้างตัวแปรเก็บ replytoken ไว้ใช้งาน
              $replyToken = $events['events'][0]['replyToken'];
              $user = $events['events'][0]['source']['userId'];
              $userMessage = $events['events'][0]['message']['text'];
              $type_message = $events['events'][0]['message']['type'];
            }
                return $this->checkmessage($replyToken,$userMessage,$user,$bot );
        }elseif($type_message == 'sticker' && $sequentsteps->seqcode == '0000'){
              $case = 29;
              $userMessage = '0';
                return (new ReplymessageController)->replymessage($replyToken,$userMessage,$case);
        }
    }


}
