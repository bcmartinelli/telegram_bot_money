<?php

namespace App\BotCotacao;

use Illuminate\Http\Request;

use App\Http\Requests;
use Curl\Curl;

class TelegramBot
{
    private $url;
    private $token_bot = '115524025:AAEGJD4EiE31ODPXlT1u-I0gAgKKKDQOpEg';

    public function getMe()
    {
        $this->url = 'https://api.telegram.org/bot' . $this->$token_bot . '/getUpdates';

        return $this->execute();
    }

    public function sendMessage($dolarAtual)
    {
        $this->url = 'https://api.telegram.org/bot' . $this->token_bot . '/sendMessage';
        $data = [
            'chat_id'    => '-33903501',
            'text'       => 'Dolar: '. $dolarAtual,
            'parse_mode' => 'Markdown',
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
}
