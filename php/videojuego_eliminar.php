<?php
    #Almacendando datos
    $product_id_del=limpiar_cadena($_GET['videogame_id_del']);
    #VERIFICAR PROUDCTO
    $check_videojuego=conexion();
    $check_videojuego=$check_videojuego->query("SELECT * FROM videojuego WHERE id_videojuego='$product_id_del'");

    if($check_videojuego->rowCount()==1){

        $datos=$check_videojuego->fetch();

    	$eliminar_videojuego=conexion();
    	$eliminar_videojuego=$eliminar_videojuego->prepare("DELETE FROM videojuego WHERE id_videojuego=:id");

    	$eliminar_videojuego->execute([":id"=>$product_id_del]);

        if($eliminar_videojuego->rowCount()==1){

    		if(is_file("./img/games/".$datos['videojuego_img'])){
    			chmod("./img/games/".$datos['videojuego_img'], 0777);
				unlink("./img/games/".$datos['videojuego_img']);
    		}

	        echo '
	            <div class="notification is-info is-light">
	                <strong>¡PRODUCTO ELIMINADO!</strong><br>
	                Los datos del producto se eliminaron con éxito
	            </div>
	        ';
	    }else{
	        echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrió un error inesperado!</strong><br>
	                No se pudo eliminar el producto, por favor intente nuevamente
	            </div>
	        ';
	    }
        $eliminar_producto=null;

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El VIDEOJUEGO que intenta eliminar no existe
            </div>
        ';
    }
    $check_producto=null;
?>