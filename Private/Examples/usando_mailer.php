<?php
use App\Mailer;

$body = 
'<h1>ola haley</h1>
<p>pipi popo</p>';

$email =  new Mailer;
$email->email = 'warleyhacker@hotmail.com';
$email->name = 'warley rodrigues';
$email->title = 'ola warley';
$email->body = $body;
$email->send();

// resultado true/false
dd($email->result);