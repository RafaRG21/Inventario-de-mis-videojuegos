<div class="container is-fluid mb-6">
	<h1 class="title">Categorías</h1>
	<h2 class="subtitle">Nueva subcategoría</h2>
</div>
<div class="container pb-6 pt-6">
    <div class="form-rest mb-6 mt-6">
        <form action="./php/categoria_guardar.php" method="POST" class="FormularioAjax" autocomplete="off" >
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <div class="select is-rounded">
                                <select name="categoria_tabla" id="category_table" onchange="cambiar()">
                                <option value="0" selected="" >Seleccione una categoria</option>
                                    <?php 
                                        $categoria = [
                                        "clasificacion",
                                        "franquicia",
                                        "genero",
                                        "plataforma"
                                        ];
                                        foreach($categoria as $row){
                                            echo '<option value="'.$row.'" >'.ucfirst($row).'</option>';
                                        }
                                    ?>
                                </select>

                        </div>
                    </div>
                </div>
                <div class="column" id="name">
                    <div class="control">
                        <label>Nombre</label>
                        <input class="input" type="text" name="categoria_nombre" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50" >
                    </div>
                </div>
            </div>
            <div class="columns">
                <div class="column" id="edad">
                    <div class="control">
                        <label>ESRB</label>
                        <input class="input" type="text" name="clasificacion_esrb" pattern="[a-zA-Z0-9áéíóúÁÉÍÓÚñÑ ]{1,50}" maxlength="50">
                    </div>
                </div>
                <div class="column" id="esrb">
                    <div class="control">
                        <label>Edad</label>
                        <input class="input" type="text" name="clasificacion_edad" pattern="[0-9+ ]{1,150}" maxlength="50" >
                    </div>
                </div>    
            </div>
                <style>
                    #esrb,#edad{
                        display: none;
                    }
                </style>

             <p class="has-text-centered">
                <button type="submit" class="button is-info is-rounded">Guardar</button>
            </p>
        </form>
    </div>
</div>
<script >
    
    function cambiar() {       
        var nombre = document.getElementById("name");
        var esrb = document.getElementById("esrb");
        var edad = document.getElementById("edad");
        var cat = document.getElementById("category_table"); 
        var tipo_categoria = cat.options[cat.selectedIndex].value;
        if(tipo_categoria=="clasificacion"){
            nombre.style.display = 'none';
            edad.style.display = 'block';
            esrb.style.display = 'block';
        }else{
            nombre.style.display = 'block';
            edad.style.display = 'none';
            esrb.style.display = 'none';

        }
    }
</script>
