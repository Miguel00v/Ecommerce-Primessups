<?php
    session_start(); 
    $_SESSION = array();
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_destroy();
    }
    echo "<script>alert('Sessão encerrada com sucesso!');
            window.location.href='index.php';</script>";
  
?>