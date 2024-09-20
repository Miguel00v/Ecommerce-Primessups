<?php

    $host='localhost';
    $user='root';
    $senha='';
    $bd='primesupps';
    
    //criar conexão
    $conn=new mysqli($host,$user,$senha,$bd);
    //verificar conexão
    if($conn->connect_error){
        error_log('Falha ao conectar ao banco de dados: ' . $conn->connect_error);
        die('Falha ao conectar ao banco de dados. Por favor, contacte o administrador.');
    }

?>