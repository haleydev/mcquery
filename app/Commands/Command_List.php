<?php
namespace App\Commands;
use Core\Database\Migration;

class Command_List
{   
    public function list_migrations()
    {
        (new Migration)->list();
    }
}