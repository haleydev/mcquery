<?php
    foreach($usuarios as $u){
        echo $u['nome']." - ". $u['created_dt'] . "<br>";
    }

    // dd($usuarios);
    // dd(router('home'));
?>