<div class="container is-fluid mb-6">
    <h1 class="title"><i class="bi bi-joystick"></i>Mis Videojuegos</h1>
    <h2 class="subtitle"><i class="bi bi-list-ul"></i>Lista de videojuegos</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once "./php/main.php";

        # Eliminar producto #
        if(isset($_GET['videogame_id_del'])){
            require_once "./php/videojuego_eliminar.php";
        }

        if(!isset($_GET['page'])){
            $pagina=1;
        }else{
            $pagina=(int) $_GET['page'];
            if($pagina<=1){
                $pagina=1;
            }
        }
        $categoria_id = (isset($_GET['category_id'])) ? $_GET['category_id'] : 0;

        $pagina=limpiar_cadena($pagina);
        $url="index.php?vista=videogame_list&page="; /* <== */
        $registros=15;
        $busqueda="";

        # Paginador producto #
        require_once "./php/videojuego_lista.php";
    ?>
</div>