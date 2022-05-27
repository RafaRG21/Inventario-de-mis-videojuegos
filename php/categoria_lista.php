<?php 
    $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
    $tabla="";
    $tablas = [
        "genero",
        "plataforma",
        "franquicia"
    ];
    $conexion=conexion();
    $pos;
    for($i=0;$i<3;$i++){
    if(isset($busqueda) && $busqueda!=""){
        $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM $tablas[$i] WHERE $tablas[$i]_nombre LIKE '%$busqueda%' ORDER BY $tablas[$i]_nombre ASC LIMIT $inicio,$registros";
        $datos = $conexion->query($consulta);
        if($datos->rowCount()>0){
            $pos = $i;
            break;
        }
        }
    }
    if(!isset($busqueda)){
        $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM genero ORDER BY genero_nombre ASC LIMIT $inicio,$registros";
    }
    
        


	$datos = $datos->fetchAll();

	$total = $conexion->query("SELECT FOUND_ROWS()");
	$total = (int) $total->fetchColumn();
    $Npaginas =ceil($total/$registros);
    $tabla.='
	<div class="table-container">
    <h2 class="subtitle"><strong>Género</strong></h2>
        <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                	<th class="has-text-centered">#</th>
                    <th class="has-text-centered">Nombre</th>
                    <th class="has-text-centered">Productos</th>
                    <th class="has-text-centered" colspan="2">Opciones</th>
                </tr>
            </thead>
    ';
    if($total>=1 && $pagina<=$Npaginas){
		$contador=$inicio+1;
		$pag_inicio=$inicio+1;
		foreach($datos as $rows){
			$tabla.='
				<tr class="has-text-centered" >
					<td>'.$contador.'</td>
                    <td>'.$rows["$tablas[$pos]_nombre"].'</td>
                    <td>
                        <a href="index.php?vista=product_category&category_id='.$rows["$tablas[$pos]_nombre"].'" class="button is-link is-rounded is-small">Ver videojuegos</a>
                    </td>
                    <td>
                        <a href="index.php?vista=category_update&category_id_up='.$rows["$tablas[$pos]_nombre"].'" class="button is-success is-rounded is-small">Actualizar</a>
                    </td>
                    <td>
                        <a href="'.$url.$pagina.'&category_id_del='.$rows["$tablas[$pos]_nombre"].'" class="button is-danger is-rounded is-small">Eliminar</a>
                    </td>
                </tr>
            ';
            $contador++;
		}
		$pag_final=$contador-1;
	}else{
		if($total>=1){
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="5">
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic acá para recargar el listado
						</a>
					</td>
				</tr>
			';
		}else{
			$tabla.='
				<tr class="has-text-centered" >
					<td colspan="5">
						No hay registros en el sistema
					</td>
				</tr>
			';
		}
	}
    $tabla.='</tbody></table></div>';

	if($total>0 && $pagina<=$Npaginas){
		$tabla.='<p class="has-text-right">Mostrando categorías <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
	}

	$conexion=null;
	echo $tabla;

	if($total>=1 && $pagina<=$Npaginas){
		echo paginador_tablas($pagina,$Npaginas,$url,7);
	}


?>