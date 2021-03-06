<?php
use App\Commands\Command_Autoload;
use App\Commands\Command_Cache;
use App\Commands\Command_Class;
use App\Commands\Command_Conexao;
use App\Commands\Command_Controller;
use App\Commands\Command_Cron_Job;
use App\Commands\Command_Database;
use App\Commands\Command_Drop;
use App\Commands\Command_Env;
use App\Commands\Command_List;
use App\Commands\Command_Middleware;
use App\Commands\Command_Migrate;
use App\Commands\Command_Model;
use App\Commands\Command_Server;
use Core\Commander;

// --------------------------------------------------------------------------|
//                            CONSOLE MCQUERY                                |
// --------------------------------------------------------------------------|

class Console
{
    private $headline = false;
    private $console;

    public function __construct()
    {
        $this->console = new Commander;
        $this->headline = $this->console->headline;
    }

    public function commands()
    {
        $this->console->command('server', function () {
            (new Command_Server)->server();
        });

        $this->console->command('server --port', function () {
            (new Command_Server)->port($this->headline);
        });

        $this->console->command('controller', function () {
            (new Command_Controller)->controller($this->headline);
        });

        $this->console->command('class', function () {
            (new Command_Class)->class($this->headline);
        });

        $this->console->command('middleware', function () {
            (new Command_Middleware)->middleware($this->headline);
        });

        $this->console->command('autoload', function () {
            (new Command_Autoload)->autoload();
        });

        $this->console->command('conexao', function () {
            (new Command_Conexao)->conexao();
        });

        $this->console->command('env', function () {
            (new Command_Env)->env();
        });

        $this->console->command('cache', function () {
            switch ($this->headline):
                case "env":
                    (new Command_Cache)->cache_env();
                    break;    
                case "template":
                    (new Command_Cache)->template_clear();
                    break;            
                default:
                    $this->command_end();
                    break;
            endswitch;
        });

        $this->console->command('cronjob', function () {
            if($this->headline == false){
                (new Command_Cron_Job)->cron_start();
            }else{
                (new Command_Cron_Job)->crontab($this->headline);
            }
        });

        // commands data base
        $this->console->command('model', function () {
            (new Command_Model)->model($this->headline);
        });

        $this->console->command('database', function () {
            (new Command_Database)->database($this->headline);
        });

        $this->console->command('migrate', function () {
            (new Command_Migrate)->migrate();
        });

        $this->console->command('drop', function () {
            (new Command_Drop)->drop_table($this->headline);
        });

        $this->console->command('list', function () {
            switch ($this->headline):
                case "migrations":
                    (new Command_List)->list_migrations();
                    break;
                default:
                    $this->command_end();
                    break;
            endswitch;
        });   

        $this->command_end();
    }

    public function command_end()
    {
        die("\033[1;31mcomando inv??lido\033[0m" . PHP_EOL);
    }
}