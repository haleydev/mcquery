<?php
use Models\usuarios;
$schedule = new App\Crontab\Crontab;  
        
//--------------------------------------------------------------------------|
//                           MCQUERY CRON JOBS                              |
//--------------------------------------------------------------------------|

// $schedule->cron('23:45',27,04,2022,function(){
//    echo "echo cron";
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

$schedule->everyMinute(1,function(){
//    echo "executei";
})->description('a cada minuto');

// $schedule->dailyAt('23:45',function(){
//     echo "echo cada dia";
// })->description('dia');

// $schedule->everyMonth(27,'23:45',function(){
//     echo "echo cada dia do mes";
// })->description('por mes');

//---------------------------------------------------------------------------