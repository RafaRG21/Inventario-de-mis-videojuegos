<?php 
    require_once "main.php";

    #ALMACENAR DATOS CATEGORIA
    if(isset($_POST['categoria_nombre']) && $_POST['categoria_nombre']!=""){
        $nombre_cat=limpiar_cadena($_POST['categoria_nombre']);
        $nombre_table=limpiar_cadena($_POST['categoria_tabla']);
        #VERIFICAR CAMPOS
        if($nombre_cat == ""){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    No has llenado todos los campos
                </div>
            ';
            exit();
        }
        #VERIFICAR INTEGRIDAD DATOS
        if(!verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}",$nombre_cat)){
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
        $check_nombre=$check_nombre->query("SELECT ".$nombre_table."_nombre FROM $nombre_table WHERE ".$nombre_table."_nombre='$nombre_cat'");
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
        #GUARDAR DATOS
        $guardar_categoria=conexion();
        $guardar_categoria=$guardar_categoria->prepare("
        INSERT INTO $nombre_table(".$nombre_table."_nombre) 
        VALUES(:nombre)");

        $marcadores=[
            ":nombre"=>$nombre_cat,
        ];
        $guardar_categoria->execute($marcadores);
    }else{

        #CLASIFICACION
        
    $clas_edad=limpiar_cadena($_POST['clasificacion_edad']);
    $clas_esrb=limpiar_cadena($_POST['clasificacion_esrb']);
    #VERIFICAR CAMPOS
    if($clas_edad == ""&&$clas_esrb== ""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos
            </div>
        ';
        exit();
    }
    #VERIFICAR INTEGRIDAD DATOS
    if(!verificar_datos("[0-9áéíó+ ]{1,50}",$clas_edad)||!verificar_datos("[a-zA-Z0-9áéíó+ ]{1,50}",$clas_esrb)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                Los campos no coinciden con el formato solicitado
            </div>
        ';
        exit();
    }
    #Verificar clasificacion
    $check_clas=conexion();
    $check_clas=$check_clas->query("SELECT esrb FROM clasificacion WHERE esrb='$clas_esrb'");
    if($check_clas->rowCount()>0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El ESRB ingresado ya se encuentra registrado, por favor elija otro
            </div>
        ';
        exit();
    }
    $check_nombre=null;
    #GUARDAR DATOS
    $guardar_categoria=conexion();
    $guardar_categoria=$guardar_categoria->prepare("
    INSERT INTO clasificacion(esrb,clasificacion_edad) 
    VALUES(:esrb,:edad)");

    $marcadores=[
        ":esrb"=>$clas_esrb,
        ":edad"=>$clas_edad
    ];
    $guardar_categoria->execute($marcadores);

    }

    if($guardar_categoria->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡CATEGORIA REGISTRADA!</strong><br>
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