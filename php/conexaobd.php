<?php

    $host='sql207.infinityfree.com';
    $user='if0_37327637';
    $senha='ye2BJ43qh9n3t';
    $bd='if0_37327637_primesupps';
    
    //criar conexão
    $conn=new mysqli($host,$user,$senha,$bd);
    //verificar conexão
    if($conn->connect_error){
        error_log('Falha ao conectar ao banco de dados: ' . $conn->connect_error);
        die('Falha ao conectar ao banco de dados. Por favor, contacte o administrador.');
    }

    // Define o charset
    mysqli_set_charset($conn, "utf8mb4");

?>