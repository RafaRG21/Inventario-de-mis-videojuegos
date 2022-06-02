<?php 
    require_once "../template/session_start.php";

	require_once "main.php";

    # ALMACENANDO DATOS DEL POST
    $nombre=limpiar_cadena($_POST['videojuego_nombre']);
	$publicacion=limpiar_cadena($_POST['videojuego_anio']);
	$clasificacion=limpiar_cadena($_POST['videojuego_clasificacion']);
	$plataforma=limpiar_cadena($_POST['videojuego_plataforma']);
    $genero=limpiar_cadena($_POST['videojuego_genero']);
	$franquicia=limpiar_cadena($_POST['videojuego_franquicia']);
    $completado=limpiar_cadena($_POST['videojuego_completado']);

    #VERIFICAR DATOS OBLIGATORIOS
    if($nombre=="" || $publicacion=="" || $clasificacion=="" || $plataforma=="" || $genero==""||$franquicia==""||$completado==""){
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No has llenado todos los campos que son obligatorios
            </div>
        ';
        exit();
    }

    #VERIFICAR INTEGRIDAD DE DATOS
    $datos = [
        "EL NOMBRE" => $nombre,
        "LA PUBLICACIÓN"=>$publicacion,
        "LA CLASIFICACIÓN"=>$clasificacion,
        "LA PLATAFORMA"=>$plataforma,
        "EL GÉNERO"=>$genero,
        "LA FRANQUICIA"=>$franquicia,
        "COMPLETADO"=>$completado
    ];
    
    foreach($datos as $i=>$j){
        
        if(!verificar_datos("[a-zA-Z0-9áéíóúÁÉÍÓÚ ]{1,100}",$j)){
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrio un error inesperado!</strong><br>
                    '.$i.' no coincide con el formato solicitado
                </div>
            ';
            exit();
            
        }
    }

    #VERIFICAR NOMBRE    
    $check_nombre = conexion();
    $check_nombre=$check_nombre->query("SELECT videojuego_nombre FROM videojuego WHERE videojuego_nombre='$nombre'");
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

    #IMAGENES
    $img_dir='../img/games/';
    #COMPROBAR SI SE SUBIO IMAGEN
    if($_FILES['videojuego_foto']['name']!="" && $_FILES['videojuego_foto']['size']>0){
        # CREANDO DIRECTORIO DE IMAGEN
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
        #COMPROBAR FORMATO DE IMAGEN
        if(mime_content_type($_FILES['videojuego_foto']['tmp_name'])!="image/jpeg" && mime_content_type($_FILES['videojuego_foto']['tmp_name'])!="image/png"&& mime_content_type($_FILES['videojuego_foto']['tmp_name'])!="image/jpeg"&& mime_content_type($_FILES['videojuego_foto']['tmp_name'])!="image/webp"){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrió un error inesperado!</strong><br>
	                La imagen que ha seleccionado es de un formato que no está permitido
	            </div>
	        ';
	        exit();
		}
        #COMPROBAR PESO DE IMAGEN
        if(($_FILES['videojuego_foto']['size']/1024)>3072){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡OcurriÓ un error inesperado!</strong><br>
	                La imagen que ha seleccionado supera el límite de peso permitido
	            </div>
	        ';
			exit();
		}
        #EXTENCION DE IMAGEN
        switch(mime_content_type($_FILES['videojuego_foto']['tmp_name'])){
			case 'image/jpg':
			  $img_ext=".jpg";
			break;
			case 'image/png':
			  $img_ext=".png";
            break;
            case 'image/jpeg':
                $img_ext=".jpeg";
			break;
            case 'image/webp':
                $img_ext=".webp";
			break;
		}
        #PERMISOS DEL DIRECTORIO
        chmod($img_dir, 0777);
        #nombre imagen
        $img_nombre=renombrar_fotos($nombre);
        #NOMBRE CON EXTENSION
        $foto=$img_nombre.$img_ext;
        #MOVIENDO IMAGEN AL DIRECTORIO
        if(!move_uploaded_file($_FILES['videojuego_foto']['tmp_name'], $img_dir.$foto)){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrió un error inesperado!</strong><br>
	                No podemos subir la imagen al sistema en este momento, por favor intente nuevamente
	            </div>
	        ';
			exit();
		}
    }else{
		$foto="";
	}

    #GUARDAR DATOS
    $guardar_videojuego=conexion();
    $guardar_videojuego=$guardar_videojuego->prepare("
    INSERT INTO videojuego(videojuego_nombre,videojuego_publicacion,videojuego_img,clasificacion_id,plataforma_id,genero_id,franquicia_id,completado) 
    VALUES(:nombre,:publicacion,:img,:clasificacion,:plataforma,:genero,:franquicia,:completado)");
  
    $marcadores=[
        ":nombre"=>$nombre,
        ":publicacion"=>$publicacion,
        ":img"=>$foto,
        ":clasificacion"=>$clasificacion,
        ":plataforma"=>$plataforma,
        ":genero"=>$genero,
        ":franquicia"=>$franquicia,
        ":completado"=>$completado
    ];
    $guardar_videojuego->execute($marcadores);
    if($guardar_videojuego->rowCount()==1){
        echo '
            <div class="notification is-info is-light">
                <strong>¡VIDEOJUEGO REGISTRADO!</strong><br>
                El videojuego se registró con éxito
            </div>
        ';
    }else{

    	if(is_file($img_dir.$foto)){
			chmod($img_dir.$foto, 0777);
			unlink($img_dir.$foto);
        }

        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                No se pudo registrar el producto, por favor intente nuevamente
            </div>
        ';
    }
    $guardar_videojuego=null;

?>