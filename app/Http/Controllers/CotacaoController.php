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
      list($dolarComercialCompra, $dolar_comercial_venda, $dolarTurismoCompra, $dolarTurismoVenda, $euroCompra, $euroVenda, $libraCompra, $libraVenda, $pesosCompra, $pesosVenda) = $uol->pegaValores();

      $content = file_get_contents("php://input");
      $tb = new TelegramBot();
      $tb->webhook($dolar_comercial_venda, $content);
    }
}
