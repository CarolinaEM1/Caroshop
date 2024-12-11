<h1>
    <?php echo ($_GET['action'] == 'update') ? 'Editar' : 'Nuevo'; ?>
    Formulario de productos
</h1>

<form
    action="producto.php?action=<?php echo ($action == 'update') ? 'change&id_producto=' . $datos['id_producto'] : 'save'; ?>"
    method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="mb-3">
            <input type="text" class="form-control" id="producto" name="producto" placeholder="ingresa el producto"
                value="<?php echo (isset($datos['producto'])) ? $datos['producto'] : ''; ?>" required>
        </div>
        <div class="mb-3">
            <input type="number" class="form-control" id="precio" name="precio" placeholder="ingresa el precio"
                value="<?php echo (isset($datos['precio'])) ? $datos['precio'] : ''; ?>" required>
        </div>
        <div class="mb-3">
            <label for="id_marca" class="form-label">Marcas</label>
            <select name="id_marca" class="form-control">
                <?php foreach ($marcas as $marca):
                    $selected = "";
                    if ($marca['id_marca'] == $datos['id_marca']):
                        $selected = "selected";
                    endif;
                    ?>
                    <option value="<?php echo $marca['id_marca']; ?>" <?php echo $selected; ?>>
                        <?php echo $marca['marca']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <?php if($action=='update'): ?>
        <div class="mb-3">
        <label for="imagenProducto" class="form-label">Imagen Actual</label>
            <img src="../uploads/productos/<?php echo $datos['fotografia'];?>"  id="imagenProducto" name="imagenProducto" height="50px" width="50px">
        <?php endif; ?>
        </div>
        <div class="mb-3">
            <input type="file" class="form-control" id="fotografia" name="fotografia"
                placeholder="ingresa el fotografia"
                value="<?php echo (isset($datos['fotografia'])) ? $datos['fotografia'] : ''; ?>" >
        </div>

        <input type="submit" name="save" class="btn btn-success" value="Guardar">
    </div>
</form>