<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\BotCotacao\TelegramBot;



use Curl\Curl;

class CotacaoController extends Controller
{
    public function index() {

      $content = file_get_contents("php://input");
      $tb = new TelegramBot();
      $tb->webhook($content);
    }
}
