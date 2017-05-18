<?php

namespace App\BotCotacao;

use Illuminate\Http\Request;

use App\Http\Requests;
use Curl\Curl;

class CotacaoYahoo
{
    public function pegaValor() {
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
            for($i = 0; $i < len($json->list->resources); $i++) {
                if ($json->list->resources[$i]->resource->fields->name == "USD/BRL"){
                    $moeda = $json->list->resources[$i]->resource->fields->price;

                    $moeda = str_replace('.', ',', $moeda);
                    $moeda = substr($moeda, 0, -3);
                    $moeda = "Dólar: R$".$moeda;

                    break;

                } else {
                    $moeda = "Moéda não encontrada!";
                }
            }
        } else {
            $moeda = "Json retornando NULL, tente novamente!";
        }

        return $moeda;
    }
}
