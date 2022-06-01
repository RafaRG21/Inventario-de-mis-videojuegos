<?php require 'template/session_start.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <?php include 'template/head.php'; ?>
</head>
<body>
    <?php 
        if(!isset($_GET['vista'])||$_GET["vista"]==""){
            $_GET['vista']="login";
        }
        
        if((is_file("views/". $_GET['vista'].".php")||is_file("views/". $_GET['vista'].".php"))&& $_GET['vista']!="login"&&$_GET['vista']!="404"){
                
            #CERRAR SESION
            #SE VERIFICA SI EXISTE VALORES DE SESION
            if(!isset($_SESSION['id']) && $_SESSION['id']=="" && !isset($_SESSION['usuario']) && $_SESSION['usuario']==""){
                if(headers_sent()){
                    echo "<script> window.location.href='index.php?vista=login'; </script>";
                }else{
                    header("Location: index.php?vista=login");
                }
            }
            #VISTAS PARA ADMIN
            if($_SESSION['tipo']==1 ){
            include 'template/navbar.php';
            include 'views/'.$_GET['vista'].'.php';
            include 'template/script.php';    
            }else if($_SESSION['tipo']==2){
                #VISTAS PARA USER
                include 'template/navbar-user.php';
                include 'user/'.$_GET['vista'].'.php';
                include 'template/script.php';    

            }
        }else{

            if ($_GET['vista']=="login") {
                    include "views/login.php";
            } else {
                include 'views/'.$_GET['vista'].'.php';                
            }
            
        }
        
    
    ?>

</body>
</html>