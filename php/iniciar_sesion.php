<?php

    #ALMACENAR DATOS
    #ALMACENANDO DATOS DE POST limpios
    $usuario = limpiar_cadena($_POST['login_usuario']);
    $clave = limpiar_cadena($_POST['login_clave']);
    #VERIFICAR CAMPOS OBLIGATORIOS
    if($usuario==""||$clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }
    #VERIFICANDO INTEGRIDAD DE LOS DATOS
    if(!verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)||!verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El usuario o contraseña no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    #CONEXION A LA BASE DE DATOS 
    $check_user = conexion();
    $check_user = $check_user->query("SELECT * FROM usuarios WHERE usuario_usuario='$usuario';");
    if($check_user->rowCount()==1){
        $check_user = $check_user->fetch();
        if(password_verify($clave,$check_user['usuario_contrasena'])){
            $_SESSION['id'] = $check_user['id_usuarios'];
            $_SESSION['nombre'] = $check_user['usuario_nombre'];
            $_SESSION['usuario'] = $check_user['usuario_usuario'];
            $_SESSION['tipo'] = $check_user['tipoUsuario_id'];

            if(headers_sent()){
                echo "<script>window.location.href='index.php?vista=home';</script>";
            }else{
                header("Location: index.php?vista=home");
            }
        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Usuario o contraseña incorrecto
            </div>
        ';
        }

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Usuario o contraseña incorrecto
            </div>
        ';
    }
    $check_user = null;