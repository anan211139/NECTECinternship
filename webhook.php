<?php // callback.php
require "vendor/autoload.php";
require_once('vendor/linecorp/line-bot-sdk/line-bot-sdk-tiny/LINEBotTiny.php');
$access_token = 'VjNScyiNVZFTg96I4c62mnCZdY6bqyllIaUZ4L3NHg5uObrERh7O5m/tO3bbgEPeF2D//vC4kHTLQuQGbgpZSqU3C+WUJ86nQNptlraZZtek2tdLYoqREXuN8xy3swo9RVO3EL0VrmnhSQfuOl89AQdB04t89/1O/w1cDnyilFU=';
// Get POST body content
$content = file_get_contents('php://input');
// Parse JSON
$events = json_decode($content, true);
// Validate parsed JSON data
if (!is_null($events['events'])) {
	// Loop through each event
	foreach ($events['events'] as $event) {
		// Reply only when message sent is in 'text' format
		if ($event['type'] == 'message' && $event['message']['type'] == 'text') {
			// Get text sent
			$text = $event['message']['text'];
			
			// Get replyToken
			$replyToken = $event['replyToken'];
			// Build message to reply back
			
// 			if($text == 'เปลี่ยนวิชา'){
// 				$text = 'กรุณาระบุวิชา';
// 			}
			
// 			$messages = [
// 					'type' => 'text',
// 					'text' => $text
// 				];
			if($text == 'เปลี่ยนวิชา'){
				
				$messages = [
					'type' => 'imagemap',
					'baseUrl' => 'https://github.com/anan211139/NECTECinternship/blob/master/img/sybject.jpg?raw=true',
					'altText' => 'เปลี่ยนวิชา',
					'baseSize' => 
					array (
						'width' => 1040,
						'height' => 513,
					),
					'actions' => 
					array (
    						0 => 
    						array (
      						'type' => 'message',
      						'area' => 
      							array (
        							'x' => 43,
        							'y' => 190,
        							'width' => 954,
        							'height' => 107,
      							),
      						'text' => 'วิชาคณิตศาตร์',
    						),
    						1 => 
    						array (
      							'type' => 'message',
      							'area' => 
      							array (
        							'x' => 39,
        							'y' => 311,
        							'width' => 960,
        							'height' => 105,
      							),
      						'text' => 'วิชาภาษาอังกฤษ',
    						),
  					),'text' => $text
				];
			}
			else{
				$messages = [
					'type' => 'text',
					'text' => $text
				];
			}
			
			// Make a POST Request to Messaging API to reply to sender
			$url = 'https://api.line.me/v2/bot/message/reply';
			$data = [
				'replyToken' => $replyToken,
				'messages' => [$messages],
			];
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
			echo $result. "\r\n";
		}
	}
}
echo "OK";