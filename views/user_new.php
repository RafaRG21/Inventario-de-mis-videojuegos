<div class="container is-fluid mb-6">
    <h1 class="title"><i class="bi bi-people-fill"></i>Usuarios</h1>
    <h2 class="subtitle"><i class="bi bi-person-plus-fill"></i> Nuevo usuario</h2>
</div>
<div class="container pb-6 pt-6">
    <div class="form-rest mb-6 mt-6"></div>
    <form action="./php/usuario_guardar.php" method="POST" class="FormularioAjax" autocomplete="off">
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Nombres</label>
                    <input type="text" class="input" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚÑñ ]{3,40}" maxlength="40" required>           
                </div>
            </div>    
            <div class="column">
                <div class="control">
                    <label>Apellidos</label>
                    <input type="text" class="input" name="usuario_apellido" pattern="[a-zA-ZáéíóúÁÉÍÓÚÑñ]{3,40}" maxlength="40" required>           
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Privilegios</label><br>
                    <div class="select is-rounded">
                        <select name="usuario_privilegios" >
                            <option value="" selected="" >Seleccione una opción</option>
                            <?php
                                include_once "./php/main.php";
                                $tipouser=conexion();
                                $tipouser=$tipouser->query("SELECT * FROM tipousuario;");
                                if($tipouser->rowCount()>0){
                                    $tipouser=$tipouser->fetchAll();
                                    foreach($tipouser as $row){
                                    echo '<option value="'.$row['id_TipoUsuario'].'" >'.$row['tipo_usuario'].'</option>';
                                    }
                                }
                                $tipouser=null;
                                ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
            <div class="control">
                <label>Usuario</label>
                <input type="text" class="input" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required>
            </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Email</label>
                    <input type="email" class="input" name="usuario_email" maxlength="70" required>

                </div>
            </div>
        </div>
        <div class="columns">
            <div class="column">
                <div class="control">
                    <label>Clave</label>
                    <input type="password" class="input" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
            <div class="column">
                <div class="control">
                    <label>Repetir clave</label>
                    <input type="password" class="input" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required>
                </div>
            </div>
        </div>
        <p class="has-text-centered">
            <button class="button is-info is-rounded" type="submit">Registrar</button>
        </p>
    </form>
</div>