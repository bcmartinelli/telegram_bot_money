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
            $tb = new TelegramBot();
            $tb->sendMessageCron($dolar_comercial_venda);
        })->dailyAt('20:04');
    }
}
