<?php

namespace App\BotCotacao;

use Illuminate\Http\Request;

use App\Http\Requests;
use Curl\Curl;

class CotacaoBitcoin
{
    public function pegaValor() {
        $json = json_decode(file_get_contents("https://blockchain.info/pt/ticker"));
        $valor_bitcoin = $json->USD->sell;


        return str_replace('.', ',', $valor_bitcoin);
    }
}
