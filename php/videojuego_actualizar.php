<?php
    require_once 'main.php';

    #ALMACENAR ID
    $id=limpiar_cadena($_POST["id_videojuego"]);

    #VERIFICAR PRODUCTO
    $check_videojuego=conexion();
	$check_videojuego=$check_videojuego->query("SELECT * FROM videojuego WHERE id_videojuego='$id'");

    if($check_videojuego->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El producto no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_videojuego->fetch();
    }
    $check_videojuego=null;

    #ALMACENANDO DATOS
    $nombre=limpiar_cadena($_POST['videojuego_nombre']);
	$publicacion=limpiar_cadena($_POST['videojuego_anio']);
	$clasificacion=limpiar_cadena($_POST['videojuego_clasificacion']);
	$plataforma=limpiar_cadena($_POST['videojuego_plataforma']);
    $genero=limpiar_cadena($_POST['videojuego_genero']);
	$franquicia=limpiar_cadena($_POST['videojuego_franquicia']);
    $completado=limpiar_cadena($_POST['videojuego_completado']);
    #VERIFICAR CAMPOS OBLIGATORIOS
    if($nombre=="" || $publicacion=="" || $clasificacion=="" || $plataforma=="" || $genero==""|| $franquicia==""|| $completado==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }
    #VERIFICAR INTEGRIDAD DE DATOS
    $data = [
        "EL NOMBRE" => $nombre,
        "LA PUBLICACIÓN"=>$publicacion,
        "LA CLASIFICACIÓN"=>$clasificacion,
        "LA PLATAFORMA"=>$plataforma,
        "EL GÉNERO"=>$genero,
        "LA FRANQUICIA"=>$franquicia,
        "COMPLETADO"=>$completado
    ];
    
    foreach($data as $i=>$j){
        
        if(!verificar_datos("[a-zA-Z0-9 ]{1,50}",$j)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    '.$i.' no coincide con el formato solicitado
                </div>
            ';
            exit();
            
        }
    }
    if($nombre!=$datos['videojuego_nombre']){
	    $check_nombre=conexion();
	    $check_nombre=$check_nombre->query("SELECT videojuego_nombre FROM videojuego WHERE videojuego_nombre='$nombre'");
	    if($check_nombre->rowCount()>0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrió un error inesperado!</strong><br>
	                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
	            </div>
	        ';
	        exit();
	    }
	    $check_nombre=null;
    }

    #ACTUALIZANDO DATOS
    $actualizar_videojuego=conexion();
    $actualizar_videojuego=$actualizar_videojuego->prepare("
    UPDATE videojuego SET videojuego_nombre=:nombre,videojuego_publicacion=:publicacion,clasificacion_id=:clasificacion,plataforma_id=:plataforma,genero_id=:genero,franquicia_id=:franquicia,completado=:completado
    WHERE id_videojuego=:id");
  
    $marcadores=[
        ":nombre"=>$nombre,
        ":publicacion"=>$publicacion,
        ":clasificacion"=>$clasificacion,
        ":plataforma"=>$plataforma,
        ":genero"=>$genero,
        ":franquicia"=>$franquicia,
        ":completado"=>$completado,
        ":id"=>$id
    ];
    $actualizar_videojuego->execute($marcadores);
    
    if($actualizar_videojuego->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡VIDEOJUEGO ACTUALIZADO!</strong><br>
                El videojuego se actualizó con éxito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo actualizar el producto, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_producto=null;
?>