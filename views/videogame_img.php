<div class="container is-fluid mb-6">
	<h1 class="title"><i class="bi bi-joystick"></i>Videojuegos</h1>
	<h2 class="subtitle">Actualizar imagen de videojuego</h2>
</div>

<div class="container pb-6 pt-6">
<?php
		include "./template/btn_back.php";

		require_once "./php/main.php";

		$id = (isset($_GET['videogame_id_up'])) ? $_GET['videogame_id_up'] : 0;

		/*== Verificando producto ==*/
    	$check_videojuego=conexion();
    	$check_videojuego=$check_videojuego->query("SELECT * FROM videojuego WHERE id_videojuego='$id'");

        if($check_videojuego->rowCount()>0){
        	$datos=$check_videojuego->fetch();
	?>
    <div class="form-rest mb-6 mt-6">
        <div class="columns">
        <div class="column is-two-fifths">
			<?php if(is_file("./img/games/".$datos['videojuego_img'])){ ?>
			<figure class="image mb-6">
			  	<img src="./img/games/<?php echo $datos['videojuego_img']; ?>">
			</figure>
			<form class="FormularioAjax" action="./php/videojuego_img_eliminar.php" method="POST" autocomplete="off" >

				<input type="hidden" name="img_del_id" value="<?php echo $datos['id_videojuego']; ?>">

				<p class="has-text-centered">
					<button type="submit" class="button is-danger is-rounded">Eliminar imagen</button>
				</p>
			</form>
			<?php }else{ ?>
			<figure class="image mb-6">
			  	<img src="./img/game.jpg">
			</figure>
			<?php } ?>
		</div>
        <div class="column">
			<form class="mb-6 has-text-centered FormularioAjax" action="./php/videojuego_img_actualizar.php" method="POST" enctype="multipart/form-data" autocomplete="off" >

				<h4 class="title is-4 mb-6"><?php echo $datos['videojuego_nombre']; ?></h4>
				
				<label>Foto o imagen del videojuego</label><br>

				<input type="hidden" name="img_up_id" value="<?php echo $datos['id_videojuego']; ?>">

				<div class="file has-name is-horizontal is-justify-content-center mb-6">
				  	<label class="file-label">
				    	<input class="file-input" type="file" name="videojuego_foto" accept=".jpg, .png, .jpeg, .webp" >
				    	<span class="file-cta">
				      		<span class="file-label">Imagen</span>
				    	</span>
				    	<span class="file-name">JPG, JPEG, WEBP, PNG. (MAX 3MB)</span>
				  	</label>
				</div>
				<p class="has-text-centered">
					<button type="submit" class="button is-success is-rounded">Actualizar</button>
				</p>
			</form>
		</div>
        </div>
    </div>
    <?php 
		}else{
			include "./template/error_alert.php";
		}
		$check_producto=null;
	?>
</div>