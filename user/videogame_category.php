<div class="container is-fluid mb-6">
    <h1 class="title">Videojuegos</h1>
    <h2 class="subtitle">Lista de videojuegos por categoría</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "php-user/main.php";

    ?>
    <div class="columns">
    <div class="column is-one-third">
            <h2 class="title has-text-centered">Categorías</h2>
            <?php
               $clas = "clasificacion";
                $plat = "plataforma";
                $genre = "genero";
                $franq = "franquicia";
                $data = [
                    $clas=>"esrb",
                    $franq => 'franquicia_nombre',
                    $plat=>'plataforma_nombre',
                    $genre=>'genero_nombre'
                ];
                $categorias=conexion();
                #IMPRESION DE CATEGORIAS
                foreach($data as $i=>$j ){

                $query=$categorias->query("SELECT * FROM $i;");
                echo '<h2 class="subtitle has-text-centered">'.ucfirst($i).'</class>';
                
                if($query->rowCount()>0){
                    $query=$query->fetchAll();
                        foreach($query as $row){
                            echo '<a href="index.php?vista=videogame_category&category_id='.$row['id_'.$i].'&category_table='.$i.'" class="button is-link is-inverted is-fullwidth">'.$row[$j].'</a>';
                        
                }
                }else{
                    echo '<p class="has-text-centered" >No hay categorías registradas</p>';
                }
                $query = null;
                }
                $categorias=null;
            ?>
    </div>
            <div class="column">
            <?php
                $categoria_id = (isset($_GET['category_id'])) ? $_GET['category_id'] : -1;
                $categoria_tabla = (isset($_GET['category_table'])) ? $_GET['category_table'] : "genero";
                /*== Verificando categoria ==*/
                $check_categoria=conexion();
                $check_categoria=$check_categoria->query("SELECT * FROM $categoria_tabla WHERE id_$categoria_tabla='$categoria_id'");

                if($check_categoria->rowCount()>0){

                    $check_categoria=$check_categoria->fetch();

                    echo '
                        <h2 class="title has-text-centered"><strong>'.ucfirst($categoria_tabla).'</strong></h2>';
                        if($categoria_tabla=="clasificacion"){
                            echo '
                                <h3 class="has-text-centered pb-2" ><strong>'.$check_categoria['esrb'].'</strong></h3>
                                <h4 class="has-text-centered pb-6" >'.$check_categoria['clasificacion_edad'].'</h4>';
                        }else{
                            echo '
                                <h3 class="has-text-centered pb-6" ><strong>'.$check_categoria[$categoria_tabla.'_nombre'].'</strong></h3>';
                        }
                    

                    require_once "php-user/main.php";

        

                    if(!isset($_GET['page'])){
                        $pagina=1;
                    }else{
                        $pagina=(int) $_GET['page'];
                        if($pagina<=1){
                            $pagina=1;
                        }
                    }

                    $pagina=limpiar_cadena($pagina);
                    $url="index.php?vista=videogame_category&category_id=$categoria_id&page="; /* <== */
                    $registros=15;
                    $busqueda="";

                    # Paginador producto #
                    require_once "php-user/videojuego_lista.php";

                }else{
                    echo '<h2 class="has-text-centered title" >Seleccione una categoría para empezar</h2>';
                }
                $check_categoria=null;
            ?>
        </div>

    </div>
</div>