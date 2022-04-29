<?php
namespace App\Crontab;
use Exception;

class Crontab
{
    private $minute;
    private $hours;
    private $day;
    private $month;
    private $year;

    private $actions = array();
    private $descriptions = array();
    private $count = 1;

    public function __construct()
    {
        $this->minute = date('i');
        $this->hours = date('H');
        $this->day = date('d');
        $this->month = date('m');
        $this->year = date('Y');
    }   

    // especifico
    public function cron(string $at = '00:00', int $day = 01, int $month = 01, int $year = 0000, callable $action)
    {
        if($year == 0000){
            $year = $this->year;
        }

        if($at == $this->hours.":".$this->minute and $day == $this->day and $month == $this->month and $year == $this->year){
            $this->actions[$this->count] = $action; 
        }

        $this->count ++;
        return $this;
    }

    // a cada minuto
    public function everyMinute(int $minute = 1, callable $action)
    {
        if($this->clock($minute, 'm')){ 
            $this->actions[$this->count] = $action;
        }

        $this->count ++;
        return $this;
    }

    // a cada hora
    public function everyHour(int $hour = 1, callable $action)
    {
        if($this->clock($hour, 'h')){
            $this->actions[$this->count] = $action;
        }

        $this->count ++;
        return $this;
    }

    // todo dia do mes
    public function everyMonth(int $day, string $at = '00:00', callable $action)
    {
        if($this->day == $day){
            if($at == $this->hours.":".$this->minute){
                $this->actions[$this->count] = $action;  
            }
        }

        $this->count ++;
        return $this;
    }

    // uma vez ao dia
    public function dailyAt(string $at = '00:00', callable $action)
    {
        $date = explode(':',$at,2);
        if($date[0] == $this->hours and $date[1] == $this->minute){
            $this->actions[$this->count] = $action;  
        }

        $this->count ++;
        return $this;
    }

    // primeiro dia do ano
    public function yearly(callable $action)
    {       
        if($this->hours == 00 and $this->minute == 00 and $this->day == 01 and $this->month == 01){
            $this->actions[$this->count] = $action; 
        }

        $this->count ++;
        return $this;
    }

    private function clock(int $value, string $type)
    {
        $return = false;

        if ($type == 'm') {
            $a = 60;
            $keys = "";

            while ($a >= $value) {
                $keys .= "$a,";
                $a = $a - $value;
            }

            $clock = str_replace("60", "00", rtrim($keys, ","));

            foreach (explode(',', $clock) as $t) {
                if ($t == date('i')) {
                    $return = true;
                }
            }            
        }

        if ($type == 'h') {  
            if($this->minute == '00'){
                $a = 24;
                $keys = "";
                while ($a >= $value) {
                    $keys .= "$a,";
                    $a = $a - $value;
                }
             
                $clock = str_replace("24", "00", rtrim($keys, ",")); 

                foreach (explode(',', $clock) as $t) {
                    if ($t == date('G')) {
                        $return = true;
                    }
                }  
            }
        }

        return $return;
    }

    public function description(string $description)
    {
        $this->descriptions[$this->count - 1] = $description;
    }

    public function execute()
    {  
        foreach($this->actions as $key => $value){  
           
            if(isset($this->descriptions[$key])){
                echo "$this->hours:$this->minute $this->day/$this->month/$this->year ( ".$this->descriptions[$key]." ) executado". PHP_EOL;
            }else{
                echo "$this->hours:$this->minute $this->day/$this->month/$this->year ( ??? ) executado". PHP_EOL;
            }
           
            if(is_callable($value)){
                try {
                    call_user_func($value);
                } catch (Exception $e) {
                    echo 'falha ao executar verifique o codigo: ',  $e->getMessage(), "\n";
                }

                echo PHP_EOL; 
            }
        }        
    }
}