<?php
    //Este script de php va a destruir la session activa y se manda llamar al index principal.
    session_start(); //inicio session 
    session_unset(); //Libera todas las variables de session que esten activas
    session_destroy(); // Destruye la session 
    if(headers_sent()){
        echo "<script>window.location.href='index.php?vista=login';</script>";
    }else{
        header("Location: index.php?vista=login");
    }

?>