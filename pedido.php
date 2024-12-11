<?php
include (__DIR__ . '/admin/order.class.php');
$web = new Pedidos();
$datos = $web->getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Caroshop</title>
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <style>
body {
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #fce4ec; /* Rosa claro */
  margin: 0;
  padding: 0;
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #ec407a; /* Rosa fuerte */
  padding: 10px 20px;
  color: #fff;
}

.navbar a {
  color: #fff;
  text-decoration: none;
  margin-left: 20px;
}

.navbar .logo {
  font-size: 1.5em;
  font-weight: bold;
}

.navbar .cart {
  font-size: 1.2em;
}

.container {
  width: 90%;
  margin: 20px auto;
}

.icon-box {
  background: #fff;
  border: 1px solid #f8bbd0; /* Bordes en rosa suave */
  border-radius: 8px;
  padding: 20px;
  text-align: center;
  transition: box-shadow 0.3s ease;
  flex: 1 1 calc(33.333% - 30px);
  box-sizing: border-box;
}

.icon-box:hover {
  box-shadow: 0 4px 8px rgba(236, 64, 122, 0.2); /* Sombra en rosa */
}

.icon-box img {
  max-width: 100%;
  height: 200px;
  object-fit: cover;
  margin-bottom: 15px;
  border-radius: 8px;
}

.icon-box h4 {
  font-size: 1.25em;
  margin-bottom: 15px;
  color: #ad1457; /* Rosa oscuro */
}

.icon-box form {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.icon-box input[type="number"] {
  width: 60px;
  margin-bottom: 10px;
  padding: 5px;
  border: 1px solid #f8bbd0;
  border-radius: 5px;
}

.icon-box input[type="submit"] {
  background-color: #d81b60; /* Rosa brillante */
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.icon-box input[type="submit"]:hover {
  background-color: #ad1457; /* Rosa oscuro */
}

table {
  width: 100%;
  margin-top: 20px;
  border-collapse: collapse;
  background-color: #fff;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 8px rgba(236, 64, 122, 0.2);
}

th,
td {
  padding: 10px;
  text-align: left;
  border-bottom: 1px solid #f8bbd0;
}

th {
  background-color: #ec407a; /* Rosa fuerte */
  color: #fff;
}

@media (max-width: 768px) {
  .icon-box {
    flex: 1 1 calc(50% - 30px);
  }
}

@media (max-width: 576px) {
  .icon-box {
    flex: 1 1 100%;
  }

  .navbar {
    flex-direction: column;
    align-items: flex-start;
  }

  .navbar .menu {
    display: flex;
    flex-direction: column;
    width: 100%;
  }

  .navbar .menu a {
    margin: 10px 0;
  }
}


  </style>
</head>
<body>

<div class="navbar">
  <div class="logo">Caroshop</div>
  <div class="menu">
    <a href="index.php">Inicio</a>
  </div>
</div>

<div class="container">
  <h1>Pedidos</h1>
  <table class="table table-striped">
    <thead>
      <tr>
        <th scope="col">Id_Venta</th>
        <th scope="col">Tienda</th>
        <th scope="col">Producto</th>
        <th scope="col">Cantidad</th>
        <th scope="col">Total</th>

        <th scope="col">Opciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($datos as $dato): ?>
      <tr>
        <th scope="row"><?php echo $dato['id_venta']; ?></th>
        <td><?php echo $dato['tienda']; ?></td>
        <td><?php echo $dato['producto']; ?></td>
        <td><?php echo $dato['cantidad']; ?></td>
        <td><?php echo $dato['total']; ?></td>
   
        <td>
          <div class="btn-group" role="group" aria-label="Basic example">
            <a href="order.php?action=delete&id_venta=<?php echo $dato['id_venta']; ?>" class="btn btn-danger">Borrar</a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
