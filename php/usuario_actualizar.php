<?php
    require_once '../template/session_start.php';

    require_once './main.php';

    # GUARDAR ID DEL USER A EDITAR
    $id = limpiar_cadena($_POST['usuario_id']);

    # VERIFICAR USER
    $check_usuario=conexion();
	$check_usuario=$check_usuario->query("SELECT * FROM usuarios WHERE id_usuarios='$id'");

    if($check_usuario->rowCount()<=0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El usuario no existe en el sistema
            </div>
        ';
        exit();
    }else{
        $datos=$check_usuario->fetch();
    }
    $check_usuario = null;
    #DATOS DEL ADMIN
    $admin_usuario=limpiar_cadena($_POST['administrador_usuario']);
    $admin_clave=limpiar_cadena($_POST['administrador_clave']);
    #VERIFICAR DATOS ADMIN
    if($admin_usuario=="" || $admin_clave==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡OcurriÓ un error inesperado!</strong><br>
                No ha llenado los campos que corresponden a su USUARIO o CLAVE
            </div>
        ';
        exit();
    }
    # VERIFICAR INTEGRIDAD DE DATOS
    if(!verificar_datos("[a-zA-Z0-9]{4,20}",$admin_usuario)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Su USUARIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(!verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$admin_clave)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                Su contraseña no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    # VERIFICAR DATOS ADMIN EN DB
    $check_admin=conexion();
    $check_admin=$check_admin->query("
    SELECT usuario_usuario,usuario_contrasena 
    FROM usuarios 
    WHERE usuario_usuario='$admin_usuario' 
        AND id_usuarios='".$_SESSION['id']."'
        AND tipoUsuario_id=1");

    if($check_admin->rowCount()==1){
        $check_admin=$check_admin->fetch();
        
    	if($check_admin['usuario_usuario']!=$admin_usuario || !password_verify($admin_clave, $check_admin['usuario_contrasena'])){
    		echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrio un error inesperado!</strong><br>
	                usuario o contraseña de administrador incorrectos
	            </div>
	        ';
	        exit();
    	}
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                USUARIO o CLAVE de administrador incorrectos
            </div>
        ';
        exit();
    }
    $check_admin=null;
    # ALMACENANDO DATOS DE USUARIOS A EDITAR
    $nombre=limpiar_cadena($_POST['usuario_nombre']);
    $usuario=limpiar_cadena($_POST['usuario_usuario']);
    $email=limpiar_cadena($_POST['usuario_email']);
    $privilegios = limpiar_cadena($_POST['usuario_privilegios']);
    $clave_1=limpiar_cadena($_POST['usuario_clave_1']);
    $clave_2=limpiar_cadena($_POST['usuario_clave_2']);

    if($nombre=="" || $usuario==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado TODOS los campos que son obligatorios
            </div>
        ';
        exit();
    }

    #VERIFICAR INTEGRIDAD DATOS USUARIO

    if(!verificar_datos("[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    if(!verificar_datos("[a-zA-Z0-9]{4,20}",$usuario)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El USUARIO no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    #VERIFICAR EMAIL

    if($email!="" && $email!=$datos['usuario_correo']){
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){
            $check_email=conexion();
            $check_email=$check_email->query("SELECT usuario_correo FROM usuarios WHERE usuario_correo='$email'");
            if($check_email->rowCount()>0){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        El email ingresado ya se encuentra registrado, por favor elija otro
                    </div>
                ';
                exit();
            }
            $check_email=null;
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    Ha ingresado un correo electrónico no válido
                </div>
            ';
            exit();
        } 
    }
    #VERIFICACION DE USUARIO
    if($usuario!=$datos['usuario_usuario']){
	    $check_usuario=conexion();
	    $check_usuario=$check_usuario->query("SELECT usuario_usuario FROM usuarios WHERE usuario_usuario='$usuario'");
	    if($check_usuario->rowCount()>0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrió un error inesperado!</strong><br>
	                El USUARIO ingresado ya se encuentra registrado, por favor elija otro
	            </div>
	        ';
	        exit();
	    }
	    $check_usuario=null;
    }
    #VERIFICACION CLAVE
    if($clave_1!="" || $clave_2!=""){
    	if(!verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_1) || !verificar_datos("[a-zA-Z0-9$@.-]{7,100}",$clave_2)){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrió un error inesperado!</strong><br>
	                Las CONTRASEÑAS no coinciden con el formato solicitado
	            </div>
	        ';
	        exit();
	    }else{
		    if($clave_1!=$clave_2){
		        echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrió un error inesperado!</strong><br>
		                Las CONTRASEÑAS que ha ingresado no coinciden
		            </div>
		        ';
		        exit();
		    }else{
		        $clave=password_hash($clave_1,PASSWORD_BCRYPT,["cost"=>10]);
		    }
	    }
    }else{
    	$clave=$datos['usuario_contrasena'];
    }

    #ACTUALIZACION DE DATOS
    $actualizar_usuario=conexion();
    $actualizar_usuario=$actualizar_usuario->prepare("
        UPDATE usuarios 
        SET usuario_nombre=:nombre,usuario_usuario=:usuario,usuario_contrasena=:clave,usuario_correo=:email, tipoUsuario_id=:privilegios 
        WHERE id_usuarios=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":usuario"=>$usuario,
        ":clave"=>$clave,
        ":email"=>$email,
        ":privilegios"=>$privilegios,
        ":id"=>$id
    ];
    $actualizar_usuario->execute($marcadores);
    if($actualizar_usuario->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡USUARIO ACTUALIZADO!</strong><br>
                El usuario se actualizó con éxito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo actualizar el usuario, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_usuario=null;


?>