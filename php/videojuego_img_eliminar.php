<?php
    require_once "main.php";

	/*== Almacenando datos ==*/
    $videojuego_id=limpiar_cadena($_POST['img_del_id']);

    /*== Verificando videojuego ==*/
    $check_videojuego=conexion();
    $check_videojuego=$check_videojuego->query("SELECT * FROM videojuego WHERE id_videojuego='$videojuego_id'");

    if($check_videojuego->rowCount()==1){
    	$datos=$check_videojuego->fetch();
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                La imagen del VIDEOJUEGO que intenta eliminar no existe
            </div>
        ';
        exit();
    }
    $check_videojuego=null;
    
    /* Directorios de imagenes */
	$img_dir='../img/games/';

	/* Cambiando permisos al directorio */
	chmod($img_dir, 0777);


	/* Eliminando la imagen */
	if(is_file($img_dir.$datos['videojuego_img'])){

		chmod($img_dir.$datos['videojuego_img'], 0777);

		if(!unlink($img_dir.$datos['videojuego_img'])){
			echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrió un error inesperado!</strong><br>
	                Error al intentar eliminar la imagen del videojuego, por favor intente nuevamente
	            </div>
	        ';
	        exit();
		}
	}
    /*== Actualizando datos ==*/
    $actualizar_videojuego=conexion();
    $actualizar_videojuego=$actualizar_videojuego->prepare("UPDATE videojuego SET videojuego_img=:foto WHERE id_videojuego=:id");

    $marcadores=[
        ":foto"=>"",
        ":id"=>$videojuego_id
    ];
    if($actualizar_videojuego->execute($marcadores)){
        echo '
            <div class="notification is-info is-light">
                <strong>¡IMAGEN O FOTO ELIMINADA!</strong><br>
                La imagen del videojuego ha sido eliminada exitosamente, pulse Aceptar para recargar los cambios.

                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=videogame_img&videogame_id_up='.$videojuego_id.'" class="button is-link is-rounded">Aceptar</a>
                </p">
            </div>
        ';
    }else{
        echo '
            <div class="notification is-warning is-light">
                <strong>¡IMAGEN O FOTO ELIMINADA!</strong><br>
                Ocurrieron algunos inconvenientes, sin embargo la imagen del videojuego ha sido eliminada, pulse Aceptar para recargar los cambios.

                <p class="has-text-centered pt-5 pb-5">
                    <a href="index.php?vista=videogame_img&videogame_id_up='.$videojuego_id.'" class="button is-link is-rounded">Aceptar</a>
                </p">
            </div>
        ';
    }
    $actualizar_videojuego=null;
?>