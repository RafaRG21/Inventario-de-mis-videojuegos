<?php
    #ALMACENADO ID DE SESION
    $user_id_del = limpiar_cadena($_GET['user_id_del']);

    # VERIFICAR USUARIO

    $check_usuario = conexion();
    $check_usuario = $check_usuario->query("SELECT id_usuarios FROM usuarios WHERE id_usuarios='$user_id_del';");
    # SI EXISTE SE ELIMINA
    if($check_usuario->rowCount()==1){
        $eliminar_usuario = conexion();
        $eliminar_usuario = $eliminar_usuario->prepare("DELETE FROM usuarios WHERE id_usuarios=:id");
        $eliminar_usuario->execute([":id"=>$user_id_del]);
        #ALERTAS DE RESULTADO
        if($eliminar_usuario->rowCount()==1){
            echo '
                <div class="notification is-info is-light">
                    <strong>¡USUARIO ELIMINADO!</strong><br>
                    Los datos del usuario se eliminaron con éxito
                </div>
            ';
        }else{
            echo '
                <div class="notification is-danger is-light">
                    <strong>¡Ocurrió un error inesperado!</strong><br>
                    No se pudo eliminar el usuario, por favor intente nuevamente
                </div>
            ';
        }
        $eliminar_usuario=null;
    }else{
        echo '
            <div class="notification is-danger is-light">
                <strong>¡Ocurrió un error inesperado!</strong><br>
                El USUARIO que intenta eliminar no existe
            </div>
        ';
    }
    $check_usuario = null;
?>