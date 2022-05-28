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
 

    if(isset($busqueda) && $busqueda!=""){
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();
        $Npaginas =ceil($total/$registros);
        $titulo = ucfirst($tablas[$pos]);
        
        $tabla.='
        <div class="table-container">
        <h2 class="subtitle"><strong>'.$titulo.'</strong></h2>
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th class="has-text-centered">#</th>
                        <th class="has-text-centered">Nombre</th>
                        <th class="has-text-centered">Videojuegos</th>
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
        echo $tabla;

        if($total>=1 && $pagina<=$Npaginas){
            echo paginador_tablas($pagina,$Npaginas,$url,7);
        }
    }else{

     #        PARTE LISTAR LAS CATEGORIAS    #

        # CONSULTA A CADA TABLA
        $consulta_genre="SELECT SQL_CALC_FOUND_ROWS * FROM genero ORDER BY genero_nombre ASC LIMIT $inicio,$registros";
        $consulta_plat="SELECT SQL_CALC_FOUND_ROWS * FROM plataforma ORDER BY plataforma_nombre ASC LIMIT $inicio,$registros";
        $consulta_franq="SELECT SQL_CALC_FOUND_ROWS * FROM franquicia ORDER BY franquicia_nombre ASC LIMIT $inicio,$registros";
        $consulta_clas="SELECT SQL_CALC_FOUND_ROWS * FROM clasificacion ORDER BY esrb ASC LIMIT $inicio,$registros";
        # REALIZACION DE LA CONSULTA
        $datos_genre = $conexion->query($consulta_genre);
        $total_genre = $conexion->query("SELECT FOUND_ROWS()");
        $datos_plat = $conexion->query($consulta_plat);
        $total_plat = $conexion->query("SELECT FOUND_ROWS()");
        $datos_franq = $conexion->query($consulta_franq);
        $total_franq = $conexion->query("SELECT FOUND_ROWS()");
        $datos_clas = $conexion->query($consulta_clas);
        $total_clas= $conexion->query("SELECT FOUND_ROWS()");

        $datos_genre = $datos_genre->fetchAll();
        $datos_plat = $datos_plat->fetchAll();
        $datos_franq = $datos_franq->fetchAll();
        $datos_clas = $datos_clas->fetchAll();

        $total_genre = (int) $total_genre->fetchColumn();
        $total_plat = (int) $total_plat->fetchColumn();
        $total_franq = (int) $total_franq->fetchColumn();
        $total_clas = (int) $total_clas->fetchColumn();
     

        $Npaginas =ceil($total_genre/$registros);

    #      PARTE GENERO        #

        $tabla='
            <div class="table-container">
            <h2 class="subtitle"><strong>Género</strong></h2>

                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr class="has-text-centered">
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Videojuegos</th>
                            <th colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
        ';
        if($total_genre>=1 && $pagina<=$Npaginas){
            $contador=$inicio+1;
            $pag_inicio=$inicio+1;
            foreach($datos_genre as $rows){
                $tabla.='
                    <tr class="has-text-centered" >
                        <td>'.$contador.'</td>
                        <td>'.$rows['genero_nombre'].'</td>
                        <td>
                            <a href="index.php?vista=product_category&category_id='.$rows['id_genero'].'" class="button is-link is-rounded is-small">Ver videojuegos</a>
                        </td>
                        <td>
                            <a href="index.php?vista=category_update&category_id_up='.$rows['id_genero'].'" class="button is-success is-rounded is-small">Actualizar</a>
                        </td>
                        <td>
                            <a href="'.$url.$pagina.'&category_id_del='.$rows['id_genero'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                        </td>
                    </tr>
                ';
                $contador++;
            }
            $pag_final=$contador-1;
        }else{
            if($total_genre>=1){
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

        
        echo $tabla;
        if($total_genre>=1 && $pagina<=$Npaginas){
            echo paginador_tablas($pagina,$Npaginas,$url,7);
        }
        
    #      PARTE PLATAFORMA
        $tabla='
            <div class="table-container">
            <h2 class="subtitle"><strong>Plataforma</strong></h2>

                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr class="has-text-centered">
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Videojuegos</th>
                            <th colspan="2">Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
            ';


        if($total_plat>=1 && $pagina<=$Npaginas){
        
            foreach($datos_plat as $rows){
                $tabla.='
                    <tr class="has-text-centered" >
                        <td>'.$contador.'</td>
                        <td>'.$rows['plataforma_nombre'].'</td>
                        <td>
                            <a href="index.php?vista=product_category&category_id='.$rows['id_plataforma'].'" class="button is-link is-rounded is-small">Ver videojuegos</a>
                        </td>
                        <td>
                            <a href="index.php?vista=category_update&category_id_up='.$rows['id_plataforma'].'" class="button is-success is-rounded is-small">Actualizar</a>
                        </td>
                        <td>
                            <a href="'.$url.$pagina.'&category_id_del='.$rows['id_plataforma'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                        </td>
                    </tr>
                ';
                $contador++;
            }
          
        
        }else{
            if($total_genre>=1){
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

        
        echo $tabla;
        if($total_genre>=1 && $pagina<=$Npaginas){
            echo paginador_tablas($pagina,$Npaginas,$url,7);
        }

    #      PARTE FRANQUICIA
        $tabla='
        <div class="table-container">
        <h2 class="subtitle"><strong>Franquicia</strong></h2>

            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Videojuegos</th>
                        <th colspan="2">Opciones</th>
                    </tr>
                </thead>
                <tbody>
        ';
        if($total_franq>=1 && $pagina<=$Npaginas){
            
            foreach($datos_franq as $rows){
                $tabla.='
                    <tr class="has-text-centered" >
                        <td>'.$contador.'</td>
                        <td>'.$rows['franquicia_nombre'].'</td>
                        <td>
                            <a href="index.php?vista=product_category&category_id='.$rows['id_franquicia'].'" class="button is-link is-rounded is-small">Ver videojuegos</a>
                        </td>
                        <td>
                            <a href="index.php?vista=category_update&category_id_up='.$rows['id_franquicia'].'" class="button is-success is-rounded is-small">Actualizar</a>
                        </td>
                        <td>
                            <a href="'.$url.$pagina.'&category_id_del='.$rows['id_franquicia'].'" class="button is-danger is-rounded is-small">Eliminar</a>
                        </td>
                    </tr>
                ';
                $contador++;
            }
            $pag_final=$contador-1;
        
        }else{
            if($total_franq>=1){
                $tabla.='
                    <tr class="has-text-centered" >
                        <td colspan="5">
                            <a href="'.$url.'1" class="button is-link is-rounded is-small mt-4 mb-4">
                                Haga clic aqui para recargar el listado
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

        if($total_franq>0 && $pagina<=$Npaginas){
            $tabla.='<p class="has-text-right">Mostrando categorías <strong>'.$pag_inicio.'</strong> al <strong>'.$pag_final.'</strong> de un <strong>total de '.$total_franq.'</strong></p>';
        }
        echo $tabla;
        if($total_franq>=1 && $pagina<=$Npaginas){
            echo paginador_tablas($pagina,$Npaginas,$url,7);
        }
        
    }
	$conexion=null;


?>