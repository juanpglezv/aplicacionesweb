<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../login.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de Nuevo Usuario</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(to right, #1e3c72, #2a5298);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .form-container {
      background-color: #ffffff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0px 4px 12px rgba(0,0,0,0.2);
      width: 350px;
    }
    .form-container h2 {
      text-align: center;
      color: #1e3c72;
      margin-bottom: 20px;
    }
    .form-group {
      margin-bottom: 15px;
    }
    label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
      color: #2a5298;
    }
    input[type="text"],
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      border: 1px solid #ccc;
      border-radius: 6px;
      outline: none;
      transition: border-color 0.3s;
    }
    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: #1e3c72;
    }
    .checkbox-group {
      display: flex;
      align-items: center;
    }
    .checkbox-group input {
      margin-right: 10px;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #1e3c72;
      color: #fff;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #2a5298;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Nuevo Usuario</h2>
    <?php
if (isset($_GET['error'])) {
    $error = $_GET['error'];
    echo "<p style='color: red; text-align: center;'>$error</p>";
}
if (isset($_GET['exito'])) {
    $exito = $_GET['exito'];
    echo "<p style='color: green; text-align: center;'>$exito</p>";
}
?>
    <form action="crear.php" method="POST">
      <div class="form-group">
        <label for="nombre">Nombre de Usuario</label>
        <input type="text" id="nombre" name="nombre" required>
      </div>
      <div class="form-group">
        <label for="correo">Correo Electrónico</label>
        <input type="email" id="correo" name="correo" required>
      </div>
      <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" id="password" name="password" required>
      </div>
      <div class="form-group">
        <label for="confirmar">Confirmar Contraseña</label>
        <input type="password" id="confirmar" name="confirmar" required>
      </div>
      <div class="form-group checkbox-group">
        <input type="checkbox" id="admin" name="admin">
        <label for="admin">Usuario Administrador</label>
      </div>
      <button type="submit">Registrar</button>
    </form>
  </div>
</body>
</html>
