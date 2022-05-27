<?php 
    require_once "main.php";

    #ALMACENAR DATOS CATEGORIA
    $nombre=limpiar_cadena($_POST['categoria_nombre']);
    $ubicacion=limpiar_cadena($_POST['categoria_ubicacion']);

    #VERIFICAR CAMPOS

    if($nombre == ""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }
    #VERIFICAR INTEGRIDAD DATOS
    if(!verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}",$nombre)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El NOMBRE no coincide con el formato solicitado
            </div>
        ';
        exit();
    }
    
    #Verificar Nombre
    $check_nombre=conexion();
    $check_nombre=$check_nombre->query("SELECT genero_nombre FROM genero WHERE genero_nombre='$nombre'");
    if($check_nombre->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                El NOMBRE ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_nombre=null;
    #GUARDAR DATOS
    $guardar_categoria=conexion();
    $guardar_categoria=$guardar_categoria->prepare("
    INSERT INTO genero(genero_nombre) 
    VALUES(:nombre)");

    $marcadores=[
        ":nombre"=>$nombre,
    ];
    $guardar_categoria->execute($marcadores);

    if($guardar_categoria->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡SUBCATEGORIA REGISTRADA!</strong><br>
                La categoría se registró con éxito
            </div>
        ';
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo registrar la categoría, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_categoria=null;

?>