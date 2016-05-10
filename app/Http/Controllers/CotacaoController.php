<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\BotCotacao\CotacaoUol;
use App\BotCotacao\TelegramBot;

class CotacaoController extends Controller
{
    public function index() {
      $uol = new CotacaoUol(); // criar uma instancia da classe

      //receber os valores
      list($dolarComercialCompra, $dolarComercialVenda, $dolarTurismoCompra, $dolarTurismoVenda, $euroCompra, $euroVenda, $libraCompra, $libraVenda, $pesosCompra, $pesosVenda) = $uol->pegaValores();

      $tb = new TelegramBot();
      $tb->sendMessage($dolarComercialVenda);
      
      echo $dolarComercialVenda;
    }
}
