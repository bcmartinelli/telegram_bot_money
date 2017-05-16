<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\BotCotacao\CotacaoYahoo;
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
            $yahoo = new CotacaoYahoo(); // criar uma instancia da classe
            $dolar_atual = $yahoo->pegaValor(); // pega valor do dolar comercial venda

            $tb = new TelegramBot();
            $tb->sendMessageCron($dolar_atual);
        })->twiceDaily(9, 17)->weekdays();
    }
}
