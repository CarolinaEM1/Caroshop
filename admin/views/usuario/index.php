<h1> Usuario</h1>
<div class="btn-group" role="group" aria-label="Basic example">
    <button type="button" class="btn btn-primary">Regresar</button>
    <a href="usuario.php?action=create" class="btn btn-success">Nuevo</a>
</div>
<table class="table">
    <thead>
        <tr>
            <th scope="col">Id</th>
            <th scope="col">Correo</th>
            <th scope="col">Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($datos as $dato): ?>
            <tr>
                <th scope="row">
                    <?php echo $dato['id_usuario'] ?>
                </th>
                <td>
                    <?php echo $dato['correo']; ?>
                </td>
                
                <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                        <a href="usuario.php?action=update&id_usuario=<?php echo $dato['id_usuario']; ?>"
                            class="btn btn-primary">Actualizar</a>
                        <a href="usuario.php?action=delete&id_usuario=<?php echo $dato['id_usuario']; ?>"
                            class="btn btn-danger">Borrar</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<p>Se encontraron <?php echo $app->getCount();?> usuarios</p