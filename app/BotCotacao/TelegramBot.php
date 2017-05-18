<?php

namespace App\BotCotacao;

use Illuminate\Http\Request;

use App\BotCotacao\CotacaoYahoo;
use App\BotCotacao\CotacaoBitcoin;
use App\Http\Requests;
use Curl\Curl;
use Log;

class TelegramBot
{
    //private $bot_token = '115524025:AAEGJD4EiE31ODPXlT1u-I0gAgKKKDQOpEg';  BOT-KADMUS
    private $bot_token = '395654213:AAE5oToM4THtbEIoMz0ExKbIqrtb6Otj_Kc'; //BOT-COTACAO
    private $url;

    public function webhook($content)
    {

        // read incoming info and grab the chatID
        $update = json_decode($content, true);

        if(isset($update) && $update != null) {
          Log::info('----------------------');
          Log::info('Data received: ', $update);
          Log::info('----------------------');
        }

        if(isset($update['message']['text'])) {
          $text = $update['message']['text'];
          $chat_id = $update["message"]["chat"]["id"];

          // compose reply
          if($text === '/dolar' || $text === '/dolar@KadmusMoney_bot') {
              $yahoo = new CotacaoYahoo(); // criar uma instancia da classe
              $dolar_atual = $yahoo->pegaValor(); // pega valor do dolar comercial venda

              $reply =  $this->sendMessage($dolar_atual, $chat_id, 1);

          } else if ($text === '/bitcoin' || $text === '/bitcoin@KadmusMoney_bot') {

              $bitcoin = new CotacaoBitcoin(); // cria uma instancia da classe
              $bitcoin_atual = $bitcoin->pegaValor(); // pega valor do bitcoin em dolar_comercial_venda

              $reply =  $this->sendMessage($bitcoin_atual, $chat_id, 2);
          }
        }
    }

    public function sendMessage($valor_atual, $chat_id, $type)
    {
        $this->url = 'https://api.telegram.org/bot' . $this->bot_token . '/sendMessage';
        if($type == 1) {
            $data = [
                'chat_id'    => $chat_id,
                'text'       => $valor_atual,
                'parse_mode' => 'Markdown',
                'disable_notification' => true,
            ];
        } else if($type == 2) {
            $data = [
                'chat_id'    => $chat_id,
                'text'       => 'Bitcoin: US$'. $valor_atual,
                'parse_mode' => 'Markdown',
                'disable_notification' => true,
            ];
        }

        return $this->execute($data);
    }

    public function sendMessageCron($dolar_atual)
    {
        $chat_id = '-33903501';
        $this->url = 'https://api.telegram.org/bot' . $this->bot_token . '/sendMessage';

        $date = date ('d/m/Y');
        $hour = date('H');

        if ($hour < 10) {
            $text_mensage = '[Abertura] ' . $date . PHP_EOL . $dolar_atual;
        } else {
            $text_mensage = '[Fechamento] ' . $date . PHP_EOL . $dolar_atual;
        }

        $data = [
            'chat_id'    => $chat_id,
            'text'       => $text_mensage,
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
