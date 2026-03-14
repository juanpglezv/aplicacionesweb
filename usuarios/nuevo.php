<?php
session_start();

// Verificar si el usuario inició sesión
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
            box-sizing: border-box;
        }
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #1e3c72;
        }
        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .checkbox-group input {
            width: auto;
            margin: 0;
        }
        .checkbox-group label {
            margin: 0;
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
            margin-top: 10px;
        }
        button:hover {
            background-color: #2a5298;
        }
        .mensaje-error {
            color: #d32f2f;
            background-color: #ffebee;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .mensaje-exito {
            color: #388e3c;
            background-color: #e8f5e8;
            padding: 10px;
            border-radius: 6px;
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .volver-link {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #666;
            text-decoration: none;
            font-size: 14px;
        }
        .volver-link:hover {
            color: #1e3c72;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Nuevo Usuario</h2>
        
        <?php
        // Mostrar mensajes de error
        if (isset($_SESSION['error'])) {
            echo "<div class='mensaje-error'>❌ " . htmlspecialchars($_SESSION['error']) . "</div>";
            unset($_SESSION['error']);
        }
        
        // Mostrar mensajes de éxito
        if (isset($_SESSION['exito'])) {
            echo "<div class='mensaje-exito'>✅ " . htmlspecialchars($_SESSION['exito']) . "</div>";
            unset($_SESSION['exito']);
        }
        ?>
        
        <form action="crear.php" method="POST">
            <div class="form-group">
                <label for="nombre">Nombre de Usuario</label>
                <input type="text" id="nombre" name="nombre" required 
                       value="<?= isset($_SESSION['old_nombre']) ? htmlspecialchars($_SESSION['old_nombre']) : '' ?>">
            </div>
            
            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" required
                       value="<?= isset($_SESSION['old_correo']) ? htmlspecialchars($_SESSION['old_correo']) : '' ?>">
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
                <input type="checkbox" id="admin" name="admin" 
                       <?= isset($_SESSION['old_admin']) ? 'checked' : '' ?>>
                <label for="admin">Usuario Administrador</label>
            </div>
            
            <button type="submit">Registrar Usuario</button>
        </form>
        
        <a href="index.php" class="volver-link">← Volver a la lista de usuarios</a>
    </div>
</body>
</html>
<?php
// Limpiar datos antiguos después de mostrarlos
unset($_SESSION['old_nombre']);
unset($_SESSION['old_correo']);
unset($_SESSION['old_admin']);
?>

