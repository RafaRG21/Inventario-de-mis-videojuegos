<?php
    require_once './main.php';
    
    #ALMACENANDO DATOS DE POST limpios
    $nombre = limpiar_cadena($_POST['usuario_nombre']);
    $apellido = limpiar_cadena($_POST['usuario_apellido']);
    $usuario = limpiar_cadena($_POST['usuario_usuario']);
    $privilegios = limpiar_cadena($_POST['usuario_privilegios']);
    $email = limpiar_cadena($_POST['usuario_email']);
    $clave_1 = limpiar_cadena($_POST['usuario_clave_1']);
    $clave_2 = limpiar_cadena($_POST['usuario_clave_2']);

    #verificando campos obligatorios
    if($nombre==""||$apellido==""||$usuario==""||$email==""||$clave_1==""||$clave_2==""||$privilegios==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    #VERIFICANDO INTEGRIDAD DE LOS DATOS
    if(!verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚnN ]{3,40}",$nombre)||!verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚnN ]{3,40}",$apellido)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El nombre/apellido no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    if(!verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El usuario no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    if(!verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || !verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Las contraseñas no coinciden con el formato solicitado
            </div>
        ';
        exit();
    }

    #VERIFICANDO EMAIL
    if($email!=""){
        if(filter_var($email,FILTER_VALIDATE_EMAIL)){
            $check_email = conexion();
            $check_email = $check_email->query("SELECT usuario_correo FROM usuarios WHERE usuario_correo ='$email'");
            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        El correo ya se encuentra registrado, ingrese otro
                    </div>
                    ';
                    exit();
            }
            $check_email = null;
        }else{
            echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El correo no coincide con el formato solicitado
            </div>
        ';
        exit();

        }
    }

    #VERIFICANDO EMAIL
    $check_usuario = conexion();
    $check_usuario = $check_usuario->query("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario ='$usuario'");
    if($check_usuario->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El nombre de usuario ya se encuentra registrado, ingrese otro
            </div>
            ';
            exit();
    }
    $check_usuario = null;

    #verificando claves
    if($clave_1!=$clave_2){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Las contraseñas ingresadas no coinciden, ingreselas de nuevo
            </div>
            ';
            exit();
    }else{
        $clave = password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]);
    }

    #GUARDANDO LOS DATOS A LA DB
    $guardar_usuario = conexion();
    $guardar_usuario = $guardar_usuario->prepare("INSERT INTO usuarios(usuario_nombre,usuario_usuario,usuario_correo,usuario_contrasena,tipoUsuario_id) VALUES(:nombre,:usuario,:correo,:clave,:privilegios);");
    $datos = [
        ":nombre"=>$nombre,
        ":usuario"=>$usuario,
        ":correo"=>$email,
        ":clave"=>$clave,
        ":privilegios"=>$privilegios
    ];
    $guardar_usuario->execute($datos);
    if($guardar_usuario->rowCount()==1){
        echo '
            <div class="notification is-success is-light">
                <strong>¡Éxito!</strong><br>
                La cuenta ha sido registrada exitosamente.
            </div>
            ';
            exit();
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo registrar el usuario, por favor intente de nuevo
                </div>
            ';
            exit();

    }
    $guardar_usuario = null;


?>


