<h1>
    <?php echo ($_GET['action'] == 'update') ? 'Editar' : 'Nuevo'; ?>
    Formulario de empleados
</h1>

<form
    action="empleado.php?action=<?php echo ($action == 'update') ? 'change&id_empleado=' . $datos['id_empleado'] : 'save'; ?>"
    method="post" enctype="multipart/form-data">

    <div class="container">
        <div class="mb-3">
            <label for="" class="form-label">Tomando foto</label>
            <label for="" class="form-label">Selecciona un dispositivo</label>
            <div>
                <select name="listaDeDispositivos" id="listaDeDispositivos"></select>
                <p id="estado"></p>
            </div>
            <br>
            <video muted="muted" id="video"></video>
            <canvas id="canvas" style="display: none;"></canvas>
        </div>
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
            <input type="text" class="form-control" pattern="[A-Z]{4}[0-9]{6}[A-Z0-9]{3}" id="rfc" name="rfc"
                placeholder="ingresa el rfc" value="<?php echo (isset($datos['rfc'])) ? $datos['rfc'] : ''; ?>">
        </div>
        <div class="mb-3">
            <input type="text" class="form-control" pattern="[A-Z]{4}[0-9]{6}[HM][A-Z]{5}[0-9]{2}" id="curp" name="curp"
                placeholder="ingresa el curp" value="<?php echo (isset($datos['curp'])) ? $datos['curp'] : ''; ?>">
        </div>
    </div>

    <input type="submit" name="save" class="btn btn-success" value="Guardar">
    </div>
</form>
<script src="script.js"></script>