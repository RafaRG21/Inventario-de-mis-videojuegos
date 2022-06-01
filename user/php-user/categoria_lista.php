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
    $found = false;
    for($i=0;$i<3;$i++){
    if(isset($busqueda) && $busqueda!=""){
        $consulta="SELECT SQL_CALC_FOUND_ROWS * FROM $tablas[$i] WHERE $tablas[$i]_nombre LIKE '%$busqueda%' ORDER BY $tablas[$i]_nombre ASC LIMIT $inicio,$registros";
        $datos = $conexion->query($consulta);
        if($datos->rowCount()>0){
            $pos = $i;
            $found = true;
            break;
        }
        }
    }
 

    if(isset($busqueda) && $busqueda!=""){
        $datos = $datos->fetchAll();

        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int) $total->fetchColumn();
        $Npaginas =ceil($total/$registros);
        if($found){
            $titulo = ucfirst($tablas[$pos]);
        }else{
            $titulo="";
        }
        
        $tabla.='
        <div class="table-container">
        <h2 class="subtitle"><strong>'.$titulo.'</strong></h2>
            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th class="has-text-centered">#</th>
                        <th class="has-text-centered">Nombre</th>
                        <th class="has-text-centered">Videojuegos</th>
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
                            <a href="index.php?vista=videogame_category&category_id='.$rows["id_$tablas[$pos]"].'&category_table='.$tablas[$pos].'" class="button is-link is-rounded is-small">Ver videojuegos</a>
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
        $consulta_plat="SELECT SQL_CALC_FOUND_ROWS * FROM plataforma ORDER BY id_plataforma ASC LIMIT $inicio,$registros";
        $consulta_franq="SELECT SQL_CALC_FOUND_ROWS * FROM franquicia ORDER BY franquicia_nombre ASC LIMIT $inicio,$registros";
        $consulta_clas="SELECT SQL_CALC_FOUND_ROWS * FROM clasificacion ORDER BY esrb ASC LIMIT $inicio,$registros";
        # REALIZACION DE LA CONSULTA
        $datos_genre = $conexion->query($consulta_genre);
        $total_genre = $conexion->query("SELECT FOUND_ROWS();");
        $datos_plat = $conexion->query($consulta_plat);
        $total_plat = $conexion->query("SELECT FOUND_ROWS()");
        $datos_franq = $conexion->query($consulta_franq);
        $total_franq = $conexion->query("SELECT FOUND_ROWS()");
        $datos_clas = $conexion->query($consulta_clas);
        $total_clas = $conexion->query("SELECT FOUND_ROWS()");

        $total_genre = (int) $total_genre->fetchColumn();
        $total_plat = (int) $total_plat->fetchColumn();
        $total_franq = (int) $total_franq->fetchColumn();
        $total_clas = (int) $total_clas->fetchColumn();

        
        $datos_genre = $datos_genre->fetchAll();
        $datos_plat = $datos_plat->fetchAll();
        $datos_franq = $datos_franq->fetchAll();
        $datos_clas = $datos_clas->fetchAll();



    #      PARTE GENERO        #

        $tabla='
            <div class="table-container">
            <h2 class="subtitle"><strong>Género</strong></h2>

                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr class="has-text-centered">
                            <th class="has-text-centered">#</th>
                            <th class="has-text-centered">Nombre</th>
                            <th class="has-text-centered">Videojuegos</th>
                        </tr>
                    </thead>
                    <tbody>
        ';
        $contador = 0;
        foreach($datos_genre as $rows){
            $contador++;
            $tabla.='
                <tr class="has-text-centered" >
                    <td>'.$contador.'</td>
                    <td>'.$rows['genero_nombre'].'</td>
                    <td>
                        <a href="index.php?vista=videogame_category&category_id='.$rows['id_genero'].'&category_table=genero" class="button is-link is-rounded is-small">Ver videojuegos</a>
                    </td>
                </tr>
            ';
            
        }
        if(!$total_genre>=1){
            $tabla.='
            <tr class="has-text-centered" >
                <td colspan="5">
                No hay registros en el sistema
                </td>
            </tr>
        ';
        }
        
        $tabla.='</tbody></table></div><br>';
        echo $tabla;
        
    #      PARTE PLATAFORMA
        $tabla = null;
        $tabla='
            <div class="table-container">
            <h2 class="subtitle"><strong>Plataforma</strong></h2>

                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr class="has-text-centered">
                            <th class="has-text-centered">#</th>
                            <th class="has-text-centered">Nombre</th>
                            <th class="has-text-centered">Videojuegos</th>
                        </tr>
                    </thead>
                    <tbody>
            ';


            $contador=0;
            foreach($datos_plat as $rows){
                $contador++;
                $tabla.='
                    <tr class="has-text-centered" >
                        <td>'.$contador.'</td>
                        <td>'.$rows['plataforma_nombre'].'</td>
                        <td>
                            <a href="index.php?vista=videogame_category&category_id='.$rows['id_plataforma'].'&category_table=plataforma" class="button is-link is-rounded is-small">Ver videojuegos</a>
                        </td>
                    </tr>
                ';
                
            }
          
        
        
            if(!$total_plat>=1){
                $tabla.='
                <tr class="has-text-centered" >
                <td colspan="5">
                    No hay registros en el sistema
                </td>
            </tr>                    
                ';
            }
        

        $tabla.='</tbody></table></div>';

        
        echo $tabla;
      

    #      PARTE FRANQUICIA
        $tabla='
        <div class="table-container">
        <h2 class="subtitle"><strong>Franquicia</strong></h2>

            <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                <thead>
                    <tr class="has-text-centered">
                        <th class="has-text-centered">#</th>
                        <th class="has-text-centered">Nombre</th>
                        <th class="has-text-centered">Videojuegos</th>
                    </tr>
                </thead>
                <tbody>
        ';
        
        $contador=0;

        foreach($datos_franq as $rows){
            $contador++;
            $tabla.='
                <tr class="has-text-centered" >
                    <td>'.$contador.'</td>
                    <td>'.$rows['franquicia_nombre'].'</td>
                    <td>
                        <a href="index.php?vista=videogame_category&category_id='.$rows['id_franquicia'].'&category_table=franquicia" class="button is-link is-rounded is-small">Ver videojuegos</a>
                    </td>
                  
                </tr>
            ';
        }
        
        
        if(!$total_franq>=1){
            $tabla.='
            <tr class="has-text-centered" >
                <td colspan="5">
                No hay registros en el sistema
                </td>
            </tr>
            ';
        }
        $tabla.='</tbody></table></div>';
        echo $tabla;

    #PARTE CLASIFICACION
        $tabla='
            <div class="table-container">
            <h2 class="subtitle"><strong>Clasificación de Edad</strong></h2>

                <table class="table is-bordered is-striped is-narrow is-hoverable is-fullwidth">
                    <thead>
                        <tr class="has-text-centered">
                            <th class="has-text-centered">#</th>
                            <th class="has-text-centered">Tipo</th>
                            <th class="has-text-centered">Clasificacion</th>
                            <th class="has-text-centered">Videojuegos</th>
                        </tr>
                    </thead>
                    <tbody>
        ';
        $contador=0;

        foreach($datos_clas as $rows){
            $contador++;

            $tabla.='
                <tr class="has-text-centered" >
                    <td>'.$contador.'</td>
                    <td>'.$rows['esrb'].'</td>
                    <td>'.$rows['clasificacion_edad'].'</td>
                    <td>
                        <a href="index.php?vista=videogame_category&category_id='.$rows['id_clasificacion'].'&category_table=clasificacion" class="button is-link is-rounded is-small">Ver videojuegos</a>
                    </td>
                   
                </tr>
            ';
        }
        if(!$total_clas>=1){
            $tabla.='
            <tr class="has-text-centered" >
                <td colspan="5">
                No hay registros en el sistema
                </td>
            </tr>
            ';
        }
        $tabla.='</tbody></table></div>';
        echo $tabla;

       
        
    }
	$conexion=null;


?>