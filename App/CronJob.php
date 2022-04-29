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

    // stress teste em producao
    // 10000 insert em 1 minuto
    // $max = 10000;
    // $limit = 1;
    // while ($limit <= $max) {
        usuarios::insert([
            "nome" => 'mcquery',
            "sobrenome" => 'rodrigues'
        ]);
    //     $limit ++;
    // }
    
})->description('banco de dados 1 minutos');

$schedule->everyMinute(5,function(){
//    echo "cada 5 minutos";
})->description('cada 5 minutos');

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