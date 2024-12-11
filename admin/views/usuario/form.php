<h1>
    <?php echo ($_GET['action'] == 'update') ? 'Editar' : 'Nuevo'; ?>
    Formulario de Usuarios
</h1>
<div class="btn-group" role="group" aria-label="Basic example">
    <a href="usuario.php" type="button" class="btn btn-primary">Regresar</a>
</div>

<form
    action="usuario.php?action=<?php echo ($action == 'update') ? 'change&id_usuario=' . $datos['id_usuario'] : 'save'; ?>"
    method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="mb-3">
            <input type="text" class="form-control" id="correo" name="correo" placeholder="ingresa el correo"
                value="<?php echo (isset($datos['correo'])) ? $datos['correo'] : ''; ?>" required>
        </div>
        <div class="mb-3">
            <input type="password" class="form-control" id="password" name="password" placeholder="ingresa el password"
                value="<?php echo (isset($datos['password'])) ? $datos['password'] : ''; ?>" required>
        </div>
        <div class="mb-3">
            <?php

            echo '<select name="id_rol" id="id_rol">';
            foreach ($roles as $rol):
                echo '<option value="' . $rol['id_rol'] . '"';
                if (isset($datos['correo'])) {
                    if ($rol['id_rol'] == $rolesSeleccionados[0]['id_rol']) {
                        echo ' selected';
                    }
                }
                echo '>' . $rol['rol'] . '</option>';
            endforeach;
            echo '</select>';
            ?>

        </div>


        <input type="submit" name="save" class="btn btn-success" value="Guardar">
    </div>
</form>