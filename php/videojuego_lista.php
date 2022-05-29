<?php 
    $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
	$tabla="";

    $campos = "v.id_videojuego,v.videojuego_nombre,v.videojuego_publicacion,
    v.videojuego_img, v.clasificacion_id, v.plataforma_id, v.genero_id, v.franquicia_id, v.completado,
    f.id_franquicia, f.franquicia_nombre, g.id_genero, g.genero_nombre, p.id_plataforma,p.plataforma_nombre,
    c.id_clasificacion,c.esrb,c.clasificacion_edad";
    if(isset($busqueda)&&$busqueda!=""){
        $consulta="SELECT SQL_CALC_FOUND_ROWS $campos
                    FROM videojuego v
                    INNER JOIN clasificacion c
                    ON v.clasificacion_id=c.id_clasificacion 
                    INNER JOIN plataforma p
                    ON v.plataforma_id=p.id_plataforma
                    INNER JOIN genero g
                    ON v.genero_id=g.id_genero
                    INNER JOIN franquicia f
                    ON v.franquicia_id=f.id_franquicia
                    WHERE v.videojuego_nombre 
                    LIKE '%$busqueda%' 
                    OR c.esrb
                    LIKE '%$busqueda%'
                    OR c.clasificacion_edad
                    LIKE '%$busqueda%' 
                    OR p.plataforma_nombre
                    LIKE '%$busqueda%' 
                    OR g.genero_nombre
                    LIKE '%$busqueda%' 
                    OR v.videojuego_publicacion 
                    LIKE '%$busqueda%' 
                    OR f.franquicia_nombre
                    LIKE '%$busqueda%' 
                    ORDER BY v.videojuego_nombre
                    ASC LIMIT $inicio,$registros;";
    }elseif($categoria_id>0){
		$consulta="SELECT SQL_CALC_FOUND_ROWS $campos FROM videojuego INNER JOIN categoria ON videojuego.categoria_id=categoria.categoria_id INNER JOIN usuario ON producto.usuario_id=usuario.usuario_id WHERE producto.categoria_id='$categoria_id' ORDER BY producto.producto_nombre ASC LIMIT $inicio,$registros";
	}else{
        $consulta ="SELECT SQL_CALC_FOUND_ROWS $campos
                    FROM videojuego v
                    INNER JOIN clasificacion c
                    ON v.clasificacion_id=c.id_clasificacion 
                    INNER JOIN plataforma p
                    ON v.plataforma_id=p.id_plataforma
                    INNER JOIN genero g
                    ON v.genero_id=g.id_genero
                    INNER JOIN franquicia f
                    ON v.franquicia_id=f.id_franquicia
        ";
	}
    $conexion=conexion();

	$datos = $conexion->query($consulta);

	$datos = $datos->fetchAll();

	$total = $conexion->query("SELECT FOUND_ROWS()");
	$total = (int) $total->fetchColumn();

	$Npaginas =ceil($total/$registros);

    if($total>=1 && $pagina<=$Npaginas){
        $contador=$inicio+1;
        $pag_inicio=$inicio+1;
        foreach($datos as $rows){
			$tabla.='
				<article class="media">
			        <figure class="media-left">
			            <p class="image is-64x64">';
			            if(is_file("./img/games/".$rows['videojuego_img'])){
			            	$tabla.='<img src="./img/games/'.$rows['videojuego_img'].'">';
			            }else{
			            	$tabla.='<img src="./img/game.png">';
			            }
			   $tabla.='</p>
			        </figure>
			        <div class="media-content">
			            <div class="content">
			              <p>
			                <strong>'.$contador.' - '.$rows['videojuego_nombre'].'</strong><br>
			                <strong>PUBLICACIÓN:</strong> '.$rows['videojuego_publicacion'].', <strong>EDAD:</strong>'.$rows['clasificacion_edad'].', <strong>PLATAFORMA:</strong> '.$rows['plataforma_nombre'].', <strong>GÉNERO:</strong> '.$rows['genero_nombre'].', <strong>FRANQUICIA:</strong> '.$rows['franquicia_nombre'].',<strong>COMPLETADO:</strong> '.$rows['completado'].'
			              </p>
			            </div>
			            <div class="has-text-right">
			                <a href="index.php?vista=videogame_img&videogame_id_up='.$rows['id_videojuego'].'" class="button is-link is-rounded is-small">Imagen</a>
			                <a href="index.php?vista=videogame_update&videogame_id_up='.$rows['id_videojuego'].'" class="button is-success is-rounded is-small">Actualizar</a>
			                <a href="'.$url.$pagina.'&videogame_id_del='.$rows['id_videojuego'].'" class="button is-danger is-rounded is-small">Eliminar</a>
			            </div>
			        </div>
			    </article>

			    <hr>
            ';
            $contador++;
		}
        $pag_final=$contador-1;
        
    }else{
		if($total>=1){
			$tabla.='
				<p class="has-text-centered" >
					<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
						Haga clic acá para recargar el listado
					</a>
				</p>
			';
		}else{
			$tabla.='
				<p class="has-text-centered" >No hay registros en el sistema</p>
			';
		}
	}
    if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando videojuegos <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}
?>