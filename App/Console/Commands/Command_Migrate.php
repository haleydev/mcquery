<?php
namespace App\Console\Commands;
use App\Database\Migration;

class Command_Migrate
{   
    public function migrate()
    {
        (new Migration)->migrate();       
    }
}