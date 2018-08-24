<?php
namespace App\Http\Services;
use LINE\LINEBot;
use LINE\LINEBot\HTTPClient\CurlHTTPClient;
class BotService
{
    /**
     * @var LINEBot
     */
    private $bot;
    /**
     * @var HTTPClient
     */
    private $client;
    
    
    public function replySend($formData)
    {
        $replyToken = $formData['events']['0']['replyToken'];

        define('LINE_MESSAGE_CHANNEL_ID', '1602719598');
        define('LINE_MESSAGE_CHANNEL_SECRET', 'adc5d09e0446060bdba4cbf68a877ee9');
        define('LINE_MESSAGE_ACCESS_TOKEN', 'iU3Z5u+f3Aj+nbHhqkb1NCuoXaI71Z1MUFyUfg2u8Nqb6hxMpsQw0eKEL0W2j6tFEX7XqG5tKq8RmNgkbBwcYlaBeq0l1V29lklaLNXOU6g+lDhRC2SNAhzc1b9C4SgRxUCLuIXFxH5iCyrFr5yTEQdB04t89/1O/w1cDnyilFU=');
        
        $this->client = new CurlHTTPClient(env(LINE_MESSAGE_ACCESS_TOKEN));
        $this->bot = new LINEBot($this->client, ['channelSecret' => env(LINE_MESSAGE_CHANNEL_SECRET)]);
        
        $response = $this->bot->replyText($replyToken, 'hello!');
        
        if ($response->isSucceeded()) {
            logger("reply success!!");
            return;
        }
    }
}