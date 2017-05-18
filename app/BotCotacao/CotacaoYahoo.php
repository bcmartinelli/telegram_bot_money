<?php

namespace App\BotCotacao;

use Illuminate\Http\Request;

use App\Http\Requests;
use Curl\Curl;

class CotacaoYahoo
{
    public function pegaValor() {
        $i = -1;
        $count = 50;

        do {
            $json = json_decode(file_get_contents("https://finance.yahoo.com/webservice/v1/symbols/allcurrencies/quote?format=json"));

            if ($json == NULL) {
                $count = $count--;
                $value = false;
            } else {
                $count = 0;
                $value = true;
            }
        } while ($count != 0);


        if($value == true) {
            do {
                $i++;
                $moeda = $json->list->resources[$i]->resource->fields->price;

            } while ($json->list->resources[$i]->resource->fields->name != "USD/BRL");

            $moeda = str_replace('.', ',', $moeda);
            $moeda = substr($moeda, 0, -3);
            $moeda = "Dólar: R$".$moeda;
        } else {
            $moeda = echo "Json retornando NULL, tente novamente!";
        }

        return $moeda;
    }
}
