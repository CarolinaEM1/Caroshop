<h1>
    <?php echo ($_GET['action'] == 'update') ? 'Editar' : 'Nuevo'; ?>
    Formulario de Marcas
</h1>

<form action="marca.php?action=<?php echo ($action == 'update') ? 'change&id_marca=' . $datos['id_marca'] : 'save'; ?>"
    method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="mb-3">
            <input type="text" class="form-control" id="marca" name="marca" placeholder="ingresa el marca"
                value="<?php echo (isset($datos['marca'])) ? $datos['marca'] : ''; ?>" required>
        </div>
        <div class="mb-3">
            <input type="file" class="form-control" id="fotografia" name="fotografia"
                placeholder="ingresa el fotografia"
                value="<?php echo (isset($datos['fotografia'])) ? $datos['fotografia'] : ''; ?>" required>
        </div>
        <input type="submit" name="save" class="btn btn-success" value="Guardar">
    </div>
</form>