<?php

namespace App\BotCotacao;

use Illuminate\Http\Request;

use App\Http\Requests;
use Curl\Curl;
use Log;

class TelegramBot
{
    //private $bot_token = '115524025:AAEGJD4EiE31ODPXlT1u-I0gAgKKKDQOpEg';  BOT-KADMUS
    private $bot_token = '231732279:AAGs0WbW46L1s5X7c-FFn00kpL7Yns9vhQ4'; //BOT-COTACAO
    private $url;

    public function webhook($dolar_atual, $content)
    {
        // read incoming info and grab the chatID
        $update = json_decode($content, true);
        $text = $update['message']['text'];

        $chat_id = $update["message"]["chat"]["id"];

        if(isset($update) && $update != null) {
          Log::info('----------------------');
          Log::info('Data received: ', $update);
          Log::info('----------------------');
        }

        // compose reply
        if($text === '/dolar') {
            $reply =  $this->sendMessage($dolar_atual, $chat_id);
        }
    }

    public function sendMessage($dolar_atual, $chat_id)
    {
        $this->url = 'https://api.telegram.org/bot' . $this->bot_token . '/sendMessage';
        $data = [
            'chat_id'    => $chat_id,
            'text'       => 'Dólar: R$'. $dolar_atual,
            'parse_mode' => 'Markdown',
            'disable_notification' => true,
        ];
        return $this->execute($data);
    }

    private function execute($data = null)
    {
        $curl = new Curl();
        if($data !== null) {
            $result = $curl->post($this->url, $data);
        } else {
            $result = $curl->get($this->url);
        }
        $curl->close();

        return $result;
    }


    /*
    private $url;
    private $token_bot = '115524025:AAEGJD4EiE31ODPXlT1u-I0gAgKKKDQOpEg';

    public function getMe()
    {
        $this->url = 'https://api.telegram.org/bot' . $this->token_bot . '/getUpdates';

        return $this->execute();
    }
    */
}
