<?php
    # ALMACENAR DATOS
    $category_tabla = limpiar_cadena($_GET['category_table']);
    $category_id_del = limpiar_cadena($_GET['category_id_del']);
    echo $category_tabla;
    #VERIFICAR CATEGORIA
    $check_categoria=conexion();
    $check_categoria=$check_categoria->query("SELECT id_$category_tabla FROM $category_tabla WHERE id_$category_tabla='$category_id_del'");
    if($check_categoria->rowCount()==1){
        $check_productos=conexion();
    	$check_productos=$check_productos->query("SELECT ".$category_tabla."_id FROM videojuego WHERE ".$category_tabla."_id='$category_id_del' LIMIT 1");
        if($check_productos->rowCount()<=0){
            $eliminar_categoria=conexion();
	    	$eliminar_categoria=$eliminar_categoria->prepare("DELETE FROM $category_tabla WHERE id_$category_tabla=:id");

	    	$eliminar_categoria->execute([":id"=>$category_id_del]);
            if($eliminar_categoria->rowCount()==1){
                echo '
		            <div class="notification is-info is-light">
		                <strong>¡SUBCATEGORIA ELIMINADA!</strong><br>
		                Los datos de la subcategoría se eliminaron con éxito
		            </div>
		        ';
            }else{
                echo '
		            <div class="notification is-danger is-light">
		                <strong>¡Ocurrió un error inesperado!</strong><br>
		                No se pudo eliminar la subcategoría, por favor intente nuevamente
		            </div>
		        ';
            }
            $eliminar_categoria=null;

        }else{
            echo '
	            <div class="notification is-danger is-light">
	                <strong>¡Ocurrió un error inesperado!</strong><br>
	                No podemos eliminar la categoría ya que tiene productos asociados
	            </div>
	        ';
        }
        $check_productos=null;

    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrio un error inesperado!</strong><br>
                La CATEGORIA que intenta eliminar no existe
            </div>
        ';
    }
    $check_categoria=null;
?>