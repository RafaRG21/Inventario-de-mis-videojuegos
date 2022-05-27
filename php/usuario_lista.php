<?php
    $inicio = ($pagina>0) ? (($pagina * $registros)-$registros) : 0;
    $tabla = "";

    if(isset($busqueda) && $busqueda!=""){
        $consulta = "
            SELECT SQL_CALC_FOUND_ROWS id_usuarios,usuario_nombre,usuario_usuario,usuario_correo,tipo_usuario
            FROM usuarios
            INNER JOIN tipousuario ON usuarios.tipoUsuario_id = tipousuario.id_TipoUsuario
            WHERE ((id_usuarios<>'".$_SESSION['id']."') 
                AND (usuario_nombre LIKE '%$busqueda%' 
                OR usuario_usuario LIKE '%$busqueda%' 
                OR usuario_correo LIKE '%$busqueda%'))
            ORDER BY usuario_nombre ASC LIMIT $inicio,$registros;
        ";
        
    }else{
        $consulta = "
        SELECT SQL_CALC_FOUND_ROWS id_usuarios,usuario_nombre,usuario_usuario,usuario_correo,tipo_usuario
        FROM usuarios
        INNER JOIN tipousuario ON usuarios.tipoUsuario_id = tipousuario.id_TipoUsuario
        WHERE id_usuarios<>'".$_SESSION['id']."'
        ORDER BY usuario_nombre ASC LIMIT $inicio,$registros;
        ";

    }
    $conexion = conexion();
    $datos = $conexion->query($consulta);
    
    $datos = $datos->fetchAll();

    $total = $conexion->query("SELECT FOUND_ROWS();");
   
    $total = (int) $total->fetchColumn();
    $nPaginas = ceil($total/$registros);
    #IMPRESION DE CAMPOS
    $tabla.='
        <div class="table-container">
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
            <thead>
                <tr class="has-text-centered">
                    <th class="has-text-centered">#</th>
                    <th class="has-text-centered">Nombres</th>
                    <th class="has-text-centered">Usuario</th>
                    <th class="has-text-centered">Email</th>
                    <th class="has-text-centered">Privilegios</th>
                    <th class="has-text-centered" colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
    ';
    # IMPRESION DE CADA FILA
    if($total>=1 && $pagina<=$nPaginas){
        $contador = $inicio + 1;
        $pag_inicio = $inicio + 1;
        foreach($datos as $rows){
            $tabla.='
            <tr class="has-text-centered" >
                <td>'.$contador.'</td>
                <td>'.$rows['usuario_nombre'].'</td>
                <td>'.$rows['usuario_usuario'].'</td>
                <td>'.$rows['usuario_correo'].'</td>
                <td>'.$rows['tipo_usuario'].'</td>

                <td>
                    <a href="index.php?vista=user_update&user_id_up='.$rows['id_usuarios'].'" class="button is-success is-rounded is-small">Editar</a>
                </td>
                <td>
                    <a href="'.$url.$pagina.'&user_id_del='.$rows['id_usuarios'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                </td>
            </tr>
            ';
            $contador++; 
        }
        $pag_final = $contador - 1;
    }else{
        if($total>=1){
            $tabla.='
				<tr class="has-text-centered" >
					<td colspan="7">
						<a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
							Haga clic aqui para recargar el listado
						</a>
					</td>
				</tr>
			';
        }else{
            $tabla.='
				<tr class="has-text-centered" >
					<td colspan="7">
						No hay registros en el sistema
					</td>
				</tr>
			';
        }
    }

    $tabla.= '</tbody></table></div>';

    if($total>0 && $pagina<=$nPaginas){
		$tabla.='<p class="has-text-right">Mostrando usuarios <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total.'</strong></p>';
    }
    $conexion = null;
    echo $tabla;

    if($total>=1 && $pagina<=$nPaginas){
        echo paginador_tablas($pagina,$nPaginas,$url,7);
    }
?>