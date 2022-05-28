<?php
    require_once "main.php";

	/*== Almacenando id ==*/
    $id=limpiar_cadena($_POST['categoria_id']);
    $category = limpiar_cadena($_POST['categoria_type']);

    /*== Verificando categoria ==*/
	$check_categoria=conexion();
	$check_categoria=$check_categoria->query("SELECT * FROM $category WHERE id_$category='$id'");

    if($check_categoria->rowCount()<=0){
    	echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La subcategoría no existe en el sistema
            </div>
        ';
        exit();
    }else{
    	$datos=$check_categoria->fetch();
    }
    $check_categoria=null;

    # SI ES TIPO CLASIFICACION

    if($category=="clasificacion"){
        /*== Almacenando datos ==*/
    $tipo=limpiar_cadena($_POST['categoria_clas']);
    $clas=limpiar_cadena($_POST['categoria_edad']);

    /*== Verificando campos obligatorios ==*/
    if($tipo==""||$clas==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }
      /*== Verificando integridad de los datos ==*/
      if(!verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ+ ]{1,50}",$tipo)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La CLASIFICACIÓN no coincide con el formato solicitado
            </div>
        ';
        exit();
    }

    	if(!verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ+ ]{1,50}",$clas)){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrió un error inesperado!</strong><br>
	                La EDAD no coincide con el formato solicitado
	            </div>
	        ';
	        exit();
	    }
         /*== Verificando tipo ==*/
    if($tipo!=$datos['esrb']){
	    $check_nombre=conexion();
	    $check_nombre=$check_nombre->query("SELECT esrb FROM clasificacion WHERE esrb='$tipo'");
	    if($check_nombre->rowCount()>0){
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrió un error inesperado!</strong><br>
	                La CLASIFICACIÓN ingresado ya se encuentra registrado, por favor elija otro
	            </div>
	        ';
	        exit();
	    }
	    $check_nombre=null;
    }
    /*== Actualizar datos ==*/
    $actualizar_categoria=conexion();
    $actualizar_categoria=$actualizar_categoria->prepare("UPDATE clasificacion SET esrb=:tipo,clasificacion_edad=:clas WHERE id_clasificacion=:id");
    $marcadores = [
        ':tipo'=>$tipo,
        ':clas'=>$clas,
        ':id'=>$id
    ];
    if($actualizar_categoria->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡SUBCATEGORIA ACTUALIZADA!</strong><br>
                La CLASIFICACIÓN se actualizo con éxito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo actualizar la categoría, por favor intente nuevamente
            </div>
        ';
    }

    }else{
        $nombre=limpiar_cadena($_POST['categoria_nombre']);
        /*== Verificando campos obligatorios ==*/
    if($nombre==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }
     /*== Verificando integridad de los datos ==*/
     if(!verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    /*== Verificando nombre ==*/
    if($nombre!=$datos[$category.'_nombre']){
	    $check_nombre=conexion();
	    $check_nombre=$check_nombre->query("SELECT ".$category."_nombre FROM $category WHERE ".$category."_nombre='$nombre'");
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
    /*== Actualizar datos ==*/
    $actualizar_categoria=conexion();
    $actualizar_categoria=$actualizar_categoria->prepare("UPDATE $category SET ".$category."_nombre=:nombre WHERE id_$category=:id");

    $marcadores=[
        ":nombre"=>$nombre,
        ":id"=>$id
    ];
    if($actualizar_categoria->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡SUBCATEGORÍA ACTUALIZADA!</strong><br>
                La categoría se actualizó con éxito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo actualizar la categoría, por favor intente nuevamente
            </div>
        ';
    }
    }
    $actualizar_categoria=null;

?>