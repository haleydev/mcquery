<?php
require dirname(__DIR__).'/../core/Resources/Requires.php';
$schedule = new Core\Cron; 

// execute classes ou funcoes na hora programada
// CUIDADO: se o escript for muito demorado e recomendado que se crie outro documento cronjob para que seja executado de forma assíncrona
// Voce pode verificar se o comando foi executado em App/Logs/cronjob.log

//--------------------------------------------------------------------------
// Tarefa: Example
//--------------------------------------------------------------------------

$schedule->everyMinute(1,function(){
    // ...
})->description('A cada 1 minuto');

// $schedule->cron('23:45',27,04,2022,[classExample::class, 'example'])->description('data especifica');

// $schedule->everyHour(1,[classExample::class, 'example'])->description('a cada 1 hora');

// $schedule->dailyAt('04:30',[classExample::class, 'example'])->description('na hora 04:30 todos os dias');

// $schedule->everyMonth(5,'23:45',[classExample::class, 'example'])->description('as 23:45 do dia 5 de cada mes');

// $schedule->yearly([classExample::class, 'example'])->description('no inicio de cada ano 01/01/xxxx na hora 00:00');

$schedule->execute();

//---------------------------------------------------------------------------