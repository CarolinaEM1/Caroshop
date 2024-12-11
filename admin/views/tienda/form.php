<h1>
    <?php echo ($_GET['action'] == 'update') ? 'Editar' : 'Nuevo'; ?>
    Formulario de tiendas
</h1>

<form
    action="tienda.php?action=<?php echo ($action == 'update') ? 'change&id_tienda=' . $datos['id_tienda'] : 'save'; ?>"
    method="post" enctype="multipart/form-data">
    <div class="container">
        <div class="mb-3">
            <input type="text" class="form-control" id="tienda" name="tienda" placeholder="ingresa el tienda"
                value="<?php echo (isset($datos['tienda'])) ? $datos['tienda'] : ''; ?>" required>
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="latitud" name="latitud" placeholder="ingresa la latitud"
                value="<?php echo (isset($datos['latitud'])) ? $datos['latitud'] : ''; ?>">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" id="longitud" name="longitud" placeholder="ingresa la longitud"
                value="<?php echo (isset($datos['longitud'])) ? $datos['longitud'] : ''; ?>">
        </div>
    </div>
    <?php if ($action == 'update'): ?>
        <div class="mb-3">
            <label for="imagenTienda" class="form-label">Imagen Actual</label>
            <img src="../uploads/tiendas/<?php echo $datos['fotografia']; ?>" id="imagenTienda" name="imagenTienda"
                height="50px" width="50px">
        <?php endif; ?>
    </div>
    <div class="mb-3">
        <input type="file" class="form-control" id="fotografia" name="fotografia" placeholder="ingresa el fotografia"
            value="<?php echo (isset($datos['fotografia'])) ? $datos['fotografia'] : ''; ?>">
    </div>

    <?php if ($action == 'update'): ?>

        <div class="mb-3">
            <label for="mapaTienda" class="form-label">Mapa Actual</label>
            <iframe class="iframe"
                src="https://maps.google.com/?ll=<?php echo $datos['latitud']; ?>,<?php echo $datos['longitud']; ?>&z=14&t=m&output=embed&quot; height="
                600" width="600" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
    <?php endif; ?>


    <input type="submit" name="save" class="btn btn-success" value="Guardar">
    </div>
</form>