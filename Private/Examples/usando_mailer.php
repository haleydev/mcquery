<?php
use App\Mailer;

$body = '<h1>ola mcquery</h1>';

$email =  new Mailer;
$email->email = 'warleyhacker@hotmail.com';
$email->name = 'warley rodrigues';
$email->title = 'ola warley';
$email->body = $body;

// $email->anexo = 'Public/images/....'; // opcinal
$email->send();

// resultado true/false
dd($email->result);