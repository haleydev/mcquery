<?php
namespace Core;
use App\Commands\Command_Dashboard;

class Commander
{    
    public $headline = false;
    public function __construct()
    {
        $string = "";
        global $argv;
        foreach ($argv as $console) {
            $string .= $console . " ";
        }             
    
        $c = explode(':',$string,2);
        $this->command = $c[0];

        if(isset($c[1])){
            $this->headline = trim($c[1]);
        }
    }

    public function command(string $command, $action)
    {  
        if(trim($this->command) == "mcquery"){
            (new Command_Dashboard)->dashboard();
            die;
        }

        if($command == str_replace("mcquery ", "", trim($this->command))){
            call_user_func($action);
            die;
        }      
    }
}