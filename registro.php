<!DOCTYPE html>
<html lang="en">

<head>
    <title>Registro</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 400px;
            margin: 100px auto;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 40px;
        }

        .container h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
        }

        .input-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .input-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        .btn {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Registro de Login</h2>
        <form action="process.php" method="POST">
            <div class="input-group">
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="input-group">
                <label for="primer-apellido">Primer Apellido:</label>
                <input type="text" id="primer-apellido" name="primer_apellido" required>
            </div>
            <div class="input-group">
                <label for="segundo-apellido">Segundo Apellido:</label>
                <input type="text" id="segundo-apellido" name="segundo_apellido" required>
            </div>
            <div class="input-group">
                <label for="rfc">RFC:</label>
                <input type="text" id="rfc" name="rfc" required>
            </div>
            <div class="input-group">
                <label for="correo">Correo:</label>
                <input type="email" id="correo" name="correo" required>
            </div>
            <div class="input-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit" class="btn">Registrarse</button>
        </form>
    </div>

</body>

</html>
