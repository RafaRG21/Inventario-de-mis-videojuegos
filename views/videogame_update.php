<div class="container is-fluid mb-6">
	<h1 class="title">Videojuegos</h1>
	<h2 class="subtitle">Actualizar videojuego</h2>
</div>
<div class="container pb-6 pt-6">
    <?php
        include "./template/btn_back.php";

		require_once "./php/main.php";
        $id = (isset($_GET['videogame_id_up'])) ? $_GET['videogame_id_up'] : 0;
        # VERFICANDO VIDEOJUEGO
        $check_videojuego=conexion();
    	$check_videojuego=$check_videojuego->query("SELECT * FROM videojuego WHERE id_videojuego='$id'");

        if($check_videojuego->rowCount()>0){
        	$datos=$check_videojuego->fetch();
    ?>
    <div class="form-rest mb-6 mt-6">
        <h2 class="title has-text-centered"><?php echo $datos['videojuego_nombre']; ?></h2>
        <form action="./php/videojuego_actualizar.php" method="POST" autocomplete="off" class="FormularioAjax">
        <input type="hidden" name="id_videojuego" value="<?php echo $datos['id_videojuego']; ?>" required >

        <div class="columns">
		  	<div class="column">
		    	<div class="control">
					<label>Nombre del videojuego</label>
				  	<input class="input" type="text" name="videojuego_nombre" pattern="[a-zA-Z0-9- ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		  	<div class="column">
		    	<div class="control">
					<label>Año de publicación</label>
				  	<input class="input" type="text" name="videojuego_anio" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ().,$#\-\/ ]{1,70}" maxlength="70" required >
				</div>
		  	</div>
		</div>
        <div class="columns">
            <div class="column">
                    <label>Clasificación</label><br>
                    <div class="select is-rounded">
                        <select name="videojuego_clasificacion" >
                            <option value="" selected="" >Seleccione una opción</option>
                            <?php
                                $categorias=conexion();
                                $categorias=$categorias->query("SELECT * FROM clasificacion");
                                if($categorias->rowCount()>0){
                                    $categorias=$categorias->fetchAll();
                                    foreach($categorias as $row){
                                        echo '<option value="'.$row['id_clasificacion'].'" >'.$row['esrb'].' - '.$row['clasificacion_edad'].'</option>';
                                    }
                                }
                                $categorias=null;
                            ?>
                        </select>
                    </div>
		  	</div>
            <div class="column">
                <label>Plataforma</label><br>
                <div class="select is-rounded">
                    <select name="videojuego_plataforma" >
                        <option value="" selected="" >Seleccione una opción</option>
                            <?php
                                $categorias=conexion();
                                $categorias=$categorias->query("SELECT * FROM plataforma");
                                if($categorias->rowCount()>0){
                                    $categorias=$categorias->fetchAll();
                                    foreach($categorias as $row){
                                        echo '<option value="'.$row['id_plataforma'].'" >'.$row['plataforma_nombre'].'</option>';
                                    }
                                }
                                $categorias=null;
                            ?>
                        </select>
                    </div>
		  	</div> 
        </div>
        <div class="columns">
            <div class="column">
                <label>Género</label><br>
                <div class="select is-rounded">
                    <select name="videojuego_genero" >
                        <option value="" selected="" >Seleccione una opción</option>
                            <?php
                                $categorias=conexion();
                                $categorias=$categorias->query("SELECT * FROM genero");
                                if($categorias->rowCount()>0){
                                    $categorias=$categorias->fetchAll();
                                    foreach($categorias as $row){
                                            echo '<option value="'.$row['id_genero'].'" >'.$row['genero_nombre'].'</option>';
                                    }
                                }
                                $categorias=null;
                            ?>
                    </select>
                </div>
            </div>
            <div class="column">
                <label>Franquicia</label><br>
                <div class="select is-rounded">
                    <select name="videojuego_franquicia" >
                        <option value="" selected="" >Seleccione una opción</option>
                            <?php
                                $categorias=conexion();
                                $categorias=$categorias->query("SELECT * FROM franquicia");
                                if($categorias->rowCount()>0){
                                    $categorias=$categorias->fetchAll();
                                    foreach($categorias as $row){
                                            echo '<option value="'.$row['id_franquicia'].'" >'.$row['franquicia_nombre'].'</option>';
                                    }
                                }
                                $categorias=null;
                            ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="columns">
        <div class="column">
            <label>Completado</label><br>
            <div class="select is-rounded">
                <select name="videojuego_completado" >
                    <option value="" selected="" >Seleccione una opción</option>
                    <option>SI</option>
                    <option>NO</option>

                </select>
            </div>
        </div>
       
        </div>
        <p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
        </form>
    </div>
    <?php 
		}else{
			include "./template/error_alert.php";
		}
		$check_producto=null;
        $categorias = null;
	?>
</div>