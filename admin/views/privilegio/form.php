<h1>
    <?php echo ($_GET['action'] == 'update') ? 'Editar' : 'Nuevo'; ?>
    Formulario de Privilegios
</h1>

<form action="privilegio.php?action=<?php echo ($action == 'update') ? 'change&id_privilegio=' . $datos['id_privilegio'] : 'save'; ?>"
    method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="mb-3">
            <input type="text" class="form-control" id="privilegio" name="privilegio" placeholder="ingresa el privilegio"
                value="<?php echo (isset($datos['privilegio'])) ? $datos['privilegio'] : ''; ?>" required>
        </div>
      
      
        <input type="submit" name="save" class="btn btn-success" value="Guardar">
    </div>
</form>