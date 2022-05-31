<?php 
    $id = (isset($_GET['user_id_up'])) ? $_GET['user_id_up'] : 0;

?>
<div class="container is-fluid mb-6">
<?php if($id==$_SESSION['id']){ ?>
    <h1 class="title">Mi cuenta</h1>
    <h2 class="subtitle">Actualizar datos de cuenta</h2>
<?php }else{ ?>
    <h1 class="title">Usuarios</h1>
    <h2 class="subtitle">Actualizar usuario</h2>
<?php } ?>
</div>

<div class="container pb-6 pt-6">
    <?php

    include "./template/btn_back.php";

    require_once "./php/main.php";

    #VERIFICAR USUARIO
    $check_usuario=conexion();
    $check_usuario=$check_usuario->query("SELECT * FROM usuarios WHERE id_usuarios='$id'");

    if($check_usuario->rowCount()>0){
        $datos=$check_usuario->fetch();
    ?>
    <div class="form-rest mb-6 mt-6">
        <form action="./php/usuario_actualizar.php" class="FormularioAjax" method="POST" autocomplete="off">
		    <input type="hidden" name="usuario_id" value="<?php echo $datos['id_usuarios']; ?>" required >

            <div class="columns">
		  	    <div class="column">
		    	    <div class="control">
					    <label>Nombres</label>
				  	    <input class="input" type="text" name="usuario_nombre" pattern="[a-zA-ZáéíóúÁÉÍÓÚñÑ ]{3,40}" maxlength="40" required value="<?php echo $datos['usuario_nombre']; ?>" >
				    </div>
		  	    </div>
                  <div class="column">
                    <div class="control">
                        <label>Usuario</label>
                        <input class="input" type="text" name="usuario_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required value="<?php echo $datos['usuario_usuario']; ?>" >
                    </div>
                </div>
		    </div>

            <div class="columns">
                <?php if($id!=$_SESSION['id']) {?>
                <div class="column">
                    <label>Privilegios</label><br>
                    <div class="select is-rounded">
                        <div class="control">
                            <select name="usuario_privilegios" >
                                <?php
                                    $tipo = conexion();
                                    $tip = $tipo->query("SELECT id_usuarios, tipoUsuario_id, tipo_usuario 
                                                        FROM usuarios
                                                        inner join tipousuario
                                                        on tipoUsuario_id=id_TipoUsuario
                                                        where id_usuarios=".$id."");
                                    $type = $tip->fetch();
                                    echo"<option value='".$type["tipoUsuario_id"]."' selected=''>".$type['tipo_usuario']."</option>";
                                    $tipouser=conexion();
                                    $tipouser=$tipouser->query("SELECT * FROM tipousuario WHERE id_TipoUsuario<>".$type['tipoUsuario_id'].";");
                                    if($tipouser->rowCount()>0){
                                        $tipouser=$tipouser->fetchAll();
                                        foreach($tipouser as $row){
                                            echo '<option value="'.$row['id_TipoUsuario'].'" >'.$row['tipo_usuario'].'</option>';
                                        }
                                    }
                                    $tipouser=null;
                                    $tipo = null;
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <?php }?>
                <div class="column">
                    <div class="control">
                        <label>Email</label>
                        <input class="input" type="email" name="usuario_email" maxlength="70" value="<?php echo $datos['usuario_correo']; ?>" >
                    </div>
                </div>
		    </div>
            <br> <br>
            <p class="has-text-centered">
			Si desea actualizar la contraseña del usuario llene los 2 campos. Si NO deje los campos vacíos.
		    </p>
            <br>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Contraseña</label>
                        <input class="input" type="password" name="usuario_clave_1" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Repetir contraseña</label>
                        <input class="input" type="password" name="usuario_clave_2" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" >
                    </div>
		  	    </div>
		    </div>
            <br> <br>
            <p class="has-text-centered">
			Para actualizar los datos del usuario, ingrese su USUARIO y CONTRASEÑA con la que inició sesión
		    </p>
            <div class="columns">
                <div class="column">
                    <div class="control">
                        <label>Usuario</label>
                        <input class="input" type="text" name="administrador_usuario" pattern="[a-zA-Z0-9]{4,20}" maxlength="20" required >
                    </div>
                </div>
                <div class="column">
                    <div class="control">
                        <label>Contraseña</label>
                        <input class="input" type="password" name="administrador_clave" pattern="[a-zA-Z0-9$@.-]{7,100}" maxlength="100" required >
                    </div>
                </div>
	    	</div>
            <p class="has-text-centered">
			<button type="submit" class="button is-success is-rounded"><i class="bi bi-check-lg is-success"></i> Actualizar</button>
		    </p>
        </form>
    </div>
    <?php 
		}else{
			include "./template/error_alert.php";
		}
		$check_usuario=null;
	?>
</div>