<?php
namespace Core;
use Throwable;

class Cron
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
        $this->seconds = date('s');
        $this->minute = date('i');
        $this->hours = date('H');
        $this->day = date('d');
        $this->month = date('m');
        $this->year = date('Y');
    }   

    // especifico
    public function cron(string $at = '00:00', int $day = 01, int $month = 01, int $year = 0000, callable|array $action)
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
    public function everyMinute(int $minute = 1, callable|array $action)
    {
        if($this->clock($minute, 'm')){ 
            $this->actions[$this->count] = $action;
        }

        $this->count ++;
        return $this;
    }

    // a cada hora
    public function everyHour(int $hour = 1, callable|array $action)
    {
        if($this->clock($hour, 'h')){
            $this->actions[$this->count] = $action;
        }

        $this->count ++;
        return $this;
    }

    // todo dia do mes
    public function everyMonth(int $day, string $at = '00:00', callable|array $action)
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
    public function dailyAt(string $at = '00:00', callable|array $action)
    {
        $date = explode(':',$at,2);
        if($date[0] == $this->hours and $date[1] == $this->minute){
            $this->actions[$this->count] = $action;  
        }

        $this->count ++;
        return $this;
    }

    // primeiro dia do ano
    public function yearly(callable|array $action)
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
            try {
                if (is_array($value)) {
                    $value[0] = new $value[0]();
                }

                if(isset($this->descriptions[$key])){               
                    $text = "[" . date('d/m/Y h:i:s') . "] ".$this->descriptions[$key]." - status: executando". PHP_EOL;
                    file_put_contents(dirname(__DIR__).'/App/Logs/cronjob.log', $text, FILE_APPEND);
                }else{
                    $text = "[" . date('d/m/Y h:i:s') . "] ??? - status: executando". PHP_EOL;
                    file_put_contents(dirname(__DIR__).'/App/Logs/cronjob.log', $text, FILE_APPEND);
                }

                // executa
                if(is_callable($value)){
                    call_user_func($value);
                }                
                
                if(isset($this->descriptions[$key])){               
                    $text = "[" . date('d/m/Y h:i:s') . "] ".$this->descriptions[$key]." - status: concluido". PHP_EOL;
                    file_put_contents(dirname(__DIR__).'/App/Logs/cronjob.log', $text, FILE_APPEND);
                }else{
                    $text = "[" . date('d/m/Y h:i:s') . "] ??? - status: concluido". PHP_EOL;
                    file_put_contents(dirname(__DIR__).'/App/Logs/cronjob.log', $text, FILE_APPEND);
                }

            } catch (Throwable $e) {
                if(isset($this->descriptions[$key])){    
                    $text = "[" . date('d/m/Y h:i:s') . "] ".$this->descriptions[$key]." - error: " . $e->getMessage() . PHP_EOL;
                    file_put_contents(dirname(__DIR__).'/App/Logs/cronjob.log', $text, FILE_APPEND);                   
                }else{
                    $text = "[" . date('d/m/Y h:i:s') . "] ??? - error: " . $e->getMessage() . PHP_EOL;
                    file_put_contents(dirname(__DIR__).'/App/Logs/cronjob.log', $text, FILE_APPEND);                       
                }         
            }
        }        
    }
}