<?php
use Models\usuarios;
$schedule = new App\Crontab\Crontab;  
        
//--------------------------------------------------------------------------|
//                           MCQUERY CRON JOBS                              |
//--------------------------------------------------------------------------|

// $schedule->cron('23:45',27,04,2022,function(){
//    echo "cron especifico";
// })->description('cron');

// $schedule->everyHour(1,function(){
//     echo "echo cada hora";
// })->description('a cada hora');

$schedule->everyMinute(1,function(){
    usuarios::insert([
        "nome" => 'mcquery',
        "sobrenome" => 'rodrigues'
    ]);
})->description('banco de dados');

$schedule->everyMinute(5,function(){
//    echo "cada 5 minutos";
})->description('a cada minuto');

// $schedule->dailyAt('23:45',function(){
//     echo "todo dia no horario x";
// })->description('dia');

// $schedule->everyMonth(27,'23:45',function(){
//     echo "dia x as x horas";
// })->description('por mes');

// $schedule->yearly(function(){
//   executa no inicio do ano dia 1 as 00:00 mes 1
// })

//---------------------------------------------------------------------------