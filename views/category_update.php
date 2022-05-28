<?php
		include "./template/btn_back.php";

		require_once "./php/main.php";

		$id = (isset($_GET['category_id_up'])) ? $_GET['category_id_up'] : 0;
        $category = $_GET['category_table'] ;
        $title = ucfirst($category);
?>
<div class="container is-fluid mb-6">
	<h1 class="title"><?php echo $title; ?></h1>
	<h2 class="subtitle">Actualizar subcategoría</h2>
</div>
<div class="container pb-6 pt-6">
    <?php
    #VERIFICANDO CATEGORIA
    $check_categoria=conexion();
    	$check_categoria=$check_categoria->query("SELECT * FROM $category WHERE id_$category='$id'");

        if($check_categoria->rowCount()>0){
        	$datos=$check_categoria->fetch();
    ?>
    <div class="form-rest mb-6 mt-6">
        <form action="./php/categoria_actualizar.php" method="POST" class="FormularioAjax" autocomplete="off">
        <?php
        echo'
        <input type="hidden" name="categoria_id" value="'.$datos["id_$category"].'" required>
        <input type="hidden" name="categoria_type" value="'.$category.'" required>
        ';
        ?>
        <?php 
            if($category=="clasificacion"){
                echo '
                    <div class="columns">
                        <div class="column">
                            <div class="control">
                                <label>Clasificación</label>
                                <input class="input" type="text" name="categoria_clas" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ+ ]{1,50}" maxlength="50" required value="'.$datos['esrb'].'" >
                            </div>
                
                        </div>
                   
                        <div class="column">
                            <div class="control">
                                <label>Edad</label>
                                <input class="input" type="text" name="categoria_edad" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ+ ]{1,50}" maxlength="150" value="'.$datos["clasificacion_edad"].'" >
                            </div>
                        </div>
                    </div>
                    ';
            }else{
          echo '      
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Nombre</label>
                        <input class="input" type="text" name="categoria_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{4,50}" maxlength="50" required value="'.$datos[$category.'_nombre'].'" >
                    </div>
                
                </div>
            </div>
            ';
                }
        ?>
        <p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded">Actualizar</button>
		</p>
        </form>
        <?php 
		}else{
			include "./inc/error_alert.php";
		}
		$check_categoria=null;
	?>
    </div>
</div>