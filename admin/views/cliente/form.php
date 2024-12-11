<h1>
    <?php echo ($_GET['action'] == 'update') ? 'Editar' : 'Nuevo'; ?>
    Formulario de empleados
</h1>

<form
    action="cliente.php?action=<?php echo ($action == 'update') ? 'change&id_cliente=' . $datos['id_cliente'] : 'save'; ?>"
    method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="mb-3">
            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="ingresa el nombre"
                value="<?php echo (isset($datos['nombre'])) ? $datos['nombre'] : ''; ?>" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="primer_apellido" name="primer_apellido"
                placeholder="ingresa la primer_apellido"
                value="<?php echo (isset($datos['primer_apellido'])) ? $datos['primer_apellido'] : ''; ?>">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="segundo_apellido" name="segundo_apellido"
                placeholder="ingresa la segundo_apellido"
                value="<?php echo (isset($datos['segundo_apellido'])) ? $datos['segundo_apellido'] : ''; ?>">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="rfc" name="rfc" placeholder="ingresa el rfc"
                value="<?php echo (isset($datos['rfc'])) ? $datos['rfc'] : ''; ?>">
        </div>
    
    </div>

    <input type="submit" name="save" class="btn btn-success" value="Guardar">
    </div>
</form>