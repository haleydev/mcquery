<?php
namespace App\Console\Commands;
use Core\Database\Migration;

class Command_Migrate
{   
    public function migrate()
    {
        (new Migration)->migrate();       
    }
}