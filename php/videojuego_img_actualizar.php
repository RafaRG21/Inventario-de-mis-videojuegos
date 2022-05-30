<?php 
    require_once "main.php";

	/*== Almacenando datos ==*/
    $videogame_id=limpiar_cadena($_POST['img_up_id']);
    /*== Verificando producto ==*/
    $check_videojuego=conexion();
    $check_videojuego=$check_videojuego->query("SELECT * FROM videojuego WHERE id_videojuego='$videogame_id'");
    if($check_videojuego->rowCount()==1){
        $datos = $check_videojuego->fetch();
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La imagen del VIDEOJUEGO que intenta actualizar no existe
            </div>
        ';
        exit();
    }
    $check_producto=null;
    /*== Comprobando si se ha seleccionado una imagen ==*/
    if($_FILES['videojuego_foto']['name']=="" || $_FILES['videojuego_foto']['size']==0){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No ha seleccionado ninguna imagen o foto
            </div>
        ';
        exit();
    }
        /* Directorios de imagenes */
        $img_dir='../img/games/';


        /* Creando directorio de imagenes */
        if(!file_exists($img_dir)){
            if(!mkdir($img_dir,0777)){
                echo '
                    <div class="notification is-danger is-light">
                        <strong>¡Ocurrió un error inesperado!</strong><br>
                        Error al crear el directorio de imágenes
                    </div>
                ';
                exit();
            }
        }
    /* Cambiando permisos al directorio */
    chmod($img_dir, 0777);


    /* Comprobando formato de las imagenes */
    if(mime_content_type($_FILES['videojuego_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['videojuego_foto']['tmp_name'])!="image/png"&& mime_content_type($_FILES['videojuego_foto']['tmp_name'])!="image/webp"&& mime_content_type($_FILES['videojuego_foto']['tmp_name'])!="image/jpg"){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La imagen que ha seleccionado tiene un formato no permitido
            </div>
        ';
        exit();
    }
    /* Comprobando que la imagen no supere el peso permitido */
    if(($_FILES['videojuego_foto']['size']/1024)>3072){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La imagen que ha seleccionado supera el límite de peso permitido
            </div>
        ';
        exit();
    }


    /* extencion de las imagenes */
    switch(mime_content_type($_FILES['videojuego_foto']['tmp_name'])){
        case 'image/jpeg':
            $img_ext=".jpg";
        break;
        case 'image/png':
            $img_ext=".png";
        break;
        case 'image/jpg':
            $img_ext=".jpg";
          break;
        case 'image/webp':
            $img_ext=".webp";
        break;
    }
    /* Nombre de la imagen */
    $img_nombre=renombrar_fotos($datos['videojuego_img']);

    /* Nombre final de la imagen */
    $foto=$img_nombre.$img_ext;

    /* Moviendo imagen al directorio */
    if(!move_uploaded_file($_FILES['videojuego_foto']['tmp_name'], $img_dir.$foto)){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
            </div>
        ';
        exit();
    }
     /* Eliminando la imagen anterior */
     if(is_file($img_dir.$datos['videojuego_img']) && $datos['videojuego_img']!=$foto){

        chmod($img_dir.$datos['videojuego_img'], 0777);
        unlink($img_dir.$datos['videojuego_img']);
    }
    /*== Actualizando datos ==*/
    $actualizar_videojuego=conexion();
    $actualizar_videojuego=$actualizar_videojuego->prepare("UPDATE videojuego SET videojuego_img=:foto WHERE id_videojuego=:id");

    $marcadores=[
        ":foto"=>$foto,
        ":id"=>$videogame_id
    ];

    if($actualizar_videojuego->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡IMAGEN O FOTO ACTUALIZADA!</strong><br>
                La imagen del videojuego ha sido actualizada exitosamente, pulse Aceptar para recargar los cambios.

                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=videogame_img&videogame_id_up='.$videogame_id.'" class="button is-link is-rounded">Aceptar</a>
                </p">
            </div>
        ';
    }else{

        if(is_file($img_dir.$foto)){
            chmod($img_dir.$foto, 0777);
            unlink($img_dir.$foto);
        }

        echo '
            <div class="notification is-warning is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
            </div>
        ';
    }
    $actualizar_producto=null;

?>