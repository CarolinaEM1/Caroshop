<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #74ebd5 0%, #acb6e5 100%);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            color: #333;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #343a40;
            padding: 10px 20px;
            color: #fff;
            width: 100%;
            position: absolute;
            top: 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .navbar a {
            color: #fff;
            text-decoration: none;
            margin-left: 20px;
            transition: color 0.3s ease;
        }
        .navbar a:hover {
            color: #ddd;
        }
        .navbar .logo {
            font-size: 1.5em;
            font-weight: bold;
        }
        .navbar .menu {
            display: flex;
        }
        .navbar .cart {
            font-size: 1.2em;
        }
        .container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            margin-bottom: 20px;
            color: #343a40;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ced4da;
            font-size: 1em;
        }
        .btn-color {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            transition: background-color 0.3s ease;
            font-size: 1em;
        }
        .btn-color:hover {
            background-color: #0056b3;
        }
        .form-text {
            margin-top: 10px;
            font-size: 0.9em;
        }
        .text-dark {
            color: #343a40 !important;
        }
        .fw-bold {
            font-weight: bold;
        }
    </style>
</head>
<body>


<div class="container">
    <h2 class="text-center text-dark mt-5">Inicio de Sesión</h2>
    <div class="card my-5">
        <form action="login.perfil.php" method="post" class="card-body cardbody-color p-lg-5">
            <div class="mb-3">
                <input type="text" class="form-control" id="correo" aria-describedby="emailHelp"
                    placeholder="Correo" name="correo" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" id="contrasena" placeholder="Contraseña" name="contrasena" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-color px-5 mb-5 w-100">Iniciar Sesión</button>
            </div>
            <div class="form-text text-center mb-5 text-dark">¿No estás registrado? 
                <a href="/../../../register.php" class="text-dark fw-bold">Crea una cuenta</a>
            </div>
            <div class="form-text text-center mb-5 text-dark">
                <a href="login.php?action=forgot" class="text-dark fw-bold">¿Olvidaste tu contraseña?</a>
            </div>
        </form>
    </div>
</div>

</body>

</html>
