<?php

namespace App\BotCotacao;

use Illuminate\Http\Request;

use App\Http\Requests;
use Curl\Curl;

class TelegramBot
{
    private $bot_token = '115524025:AAEGJD4EiE31ODPXlT1u-I0gAgKKKDQOpEg';

    public function webhook($dolarAtual)
    {
        // read incoming info and grab the chatID
        $content = file_get_contents("php://input");
        $update = json_decode($content, true);
        $chatID = $update["message"]["chat"]["id"];

        // compose reply
        $reply =  $this->sendMessage($dolarAtual);
        print_r($reply);
    }

    public function sendMessage($dolarAtual)
    {
        $this->url = 'https://api.telegram.org/bot' . $this->token_bot . '/sendMessage';
        $data = [
            'chat_id'    => '-33903501',
            'text'       => 'Dolar: R$'. $dolarAtual,
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
