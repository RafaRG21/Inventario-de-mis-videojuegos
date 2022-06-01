<div class="container is-fliud">
    <h1 class="title"><i class="bi bi-people-fill"></i> Usuarios</h1>
    <h2 class="subtitle"><i class="bi bi-person-lines-fill"></i>Lista de Usuarios</h2>
</div>

<div class="container pb-6 pt-6">
    <?php
        require_once './php/main.php';
        #ELIMINAR USUARIO
        if(isset($_GET['user_id_del'])){
            require_once './php/usuario_eliminar.php';
        }
        if(!isset($_GET['page'])){
            $pagina = 1;
        }else{
            $pagina= (int) $_GET['page'];
            if($pagina<=1){
                $pagina = 1;
            }
        }
        $pagina = limpiar_cadena($pagina);
        $url = "index.php?vista=user_list&page=";
        $registros = 15;
        $busqueda = "";
        # PAGINADOR USUARIO
        require_once './php/usuario_lista.php';
    ?>
</div>