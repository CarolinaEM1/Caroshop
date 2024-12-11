<h1>
    <?php echo ($_GET['action'] == 'update') ? 'Editar' : 'Nuevo'; ?>
    Formulario de Roles
</h1>
<div class="btn-group" role="group" aria-label="Basic example">
    <a href="rol.php" type="button" class="btn btn-primary">Regresar</a>
</div>

<form action="rol.php?action=<?php echo ($action == 'update') ? 'change&id_rol=' . $datos['id_rol'] : 'save'; ?>"
    method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="mb-3">
            <input type="text" class="form-control" id="rol" name="rol" placeholder="ingresa el rol"
                value="<?php echo (isset($datos['rol'])) ? $datos['rol'] : ''; ?>" required>
        </div>

        <?php
        if (isset($datos['rol'])):
            foreach ($privilegios as $privilegio): ?>
                <?php
                $checked = false;
                foreach ($privilegiosSeleccionados as $asociacion) {
                    if ($privilegio['id_privilegio'] == $asociacion['id_privilegio']) {
                        $checked = true;
                        break;
                    }
                }
                ?>
                <input type="checkbox" id="privilegio_<?php echo $privilegio['id_privilegio']; ?>" name="privilegios[]"
                    value="<?php echo $privilegio['id_privilegio']; ?>" <?php if ($checked)
                           echo 'checked'; ?>>
                <label
                    for="privilegio_<?php echo $privilegio['id_privilegio']; ?>"><?php echo $privilegio['privilegio']; ?></label><br>
            <?php
            endforeach;
        else:
            foreach ($privilegios as $privilegio): ?>
                <input type="checkbox" id="privilegio_<?php echo $privilegio['id_privilegio']; ?>" name="privilegios[]"
                    value="<?php echo $privilegio['id_privilegio']; ?>">
                <label
                    for="privilegio_<?php echo $privilegio['id_privilegio']; ?>"><?php echo $privilegio['privilegio']; ?></label><br>
            <?php
            endforeach;
        endif;

        ?>

        <input type="submit" name="save" class="btn btn-success" value="Guardar">
    </div>
</form>