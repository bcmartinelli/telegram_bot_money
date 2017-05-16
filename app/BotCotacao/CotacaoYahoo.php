<?php

namespace App\BotCotacao;

use Illuminate\Http\Request;

use App\Http\Requests;
use Curl\Curl;

class CotacaoYahoo
{
    public function pegaValor() {
        $json = json_decode(file_get_contents("https://finance.yahoo.com/webservice/v1/symbols/allcurrencies/quote?format=json"));
        $i = -1;
        do {
            $i++;
            $moeda = $json->list->resources[$i]->resource->fields->price;

        } while ($json->list->resources[$i]->resource->fields->name != "USD/BRL");

        $moeda = str_replace('.', ',', $moeda);
        $moeda = substr($moeda, 0, -3);
        return $moeda;
    }
}
