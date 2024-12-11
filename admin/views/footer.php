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
      background-color: #f0f2f5;
      margin: 0;
      padding: 0;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background-color: #0062cc;
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
      border: 1px solid #dee2e6;
      border-radius: 8px;
      padding: 20px;
      text-align: center;
      transition: box-shadow 0.3s ease;
      flex: 1 1 calc(33.333% - 30px);
      box-sizing: border-box;
    }

    .icon-box:hover {
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
      color: #343a40;
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
      border: 1px solid #ced4da;
      border-radius: 5px;
    }

    .icon-box input[type="submit"] {
      background-color: #28a745;
      color: #fff;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .icon-box input[type="submit"]:hover {
      background-color: #218838;
    }

    table {
      width: 100%;
      margin-top: 20px;
      border-collapse: collapse;
      background-color: #fff;
      border-radius: 8px;
      overflow: hidden;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
      padding: 10px;
      text-align: left;
      border-bottom: 1px solid #dee2e6;
    }

    th {
      background-color: #0062cc;
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

    footer {
      background-color: #343a40;
      color: #fff;
      text-align: center;
      padding: 20px;
      margin-top: 20px;
      position: relative;
      width: 100%;
    }

    footer p {
      margin: 0;
    }
  </style>
</head>

<body>




  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
