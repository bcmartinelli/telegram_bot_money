<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\BotCotacao\CotacaoUol;
use App\BotCotacao\TelegramBot;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
        \App\Console\Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function() {
            $uol = new CotacaoUol(); // criar uma instancia da classe

            //receber os valores
            list($dolarComercialCompra, $dolar_comercial_venda, $dolarTurismoCompra, $dolarTurismoVenda, $euroCompra, $euroVenda, $libraCompra, $libraVenda, $pesosCompra, $pesosVenda) = $uol->pegaValores();

            $id_chat = '-33903501';
            $content = file_get_contents("php://input");
            $tb = new TelegramBot();
            $tb->sendMessage($dolar_comercial_venda, $id_chat);
        })->everyMinute();
    }
}
