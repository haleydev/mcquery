<?php
namespace App\Console\Commands;
use App\Database\Migration;

class Command_List
{   
    public function list_migrations()
    {
        (new Migration)->list();
    }
}