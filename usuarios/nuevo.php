<?php
session_start();

if (!isset($_SESSION["usuario"])) {
    header("Location: ../login.php");
    exit;
}

if (isset($_GET['error'])) {
    $error = urldecode($_GET['error']);
}
if (isset($_GET['exito'])) {
    $exito = urldecode($_GET['exito']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            padding: 40px;
        }

        h1 {
            color: #1e3a8a;
            margin-bottom: 10px;
            text-align: center;
            font-size: 28px;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            color: #334155;
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 14px;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e7ff;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="password"]:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 15px;
            background-color: #f0f4ff;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: #667eea;
        }

        .checkbox-group label {
            margin: 0;
            cursor: pointer;
            color: #1e3a8a;
            font-weight: 500;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background-color: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .alert-success {
            background-color: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-bottom: 15px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        button:active {
            transform: translateY(0);
        }

        .login-link {
            text-align: center;
            color: #64748b;
            font-size: 14px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registro de Usuarios</h1>
        <p class="subtitle">Crea una nueva cuenta</p>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if (isset($exito)): ?>
            <div class="alert alert-success"><?php echo $exito; ?></div>
        <?php endif; ?>

        <form method="POST" action="crear.php">
            <div class="form-group">
                <label for="nombre">Nombre de Usuario</label>
                <input type="text" id="nombre" name="nombre" required placeholder="Ingrese su nombre">
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo" required placeholder="Ingrese su correo">
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="Mínimo 6 caracteres">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirmar Contraseña</label>
                <input type="password" id="confirm_password" name="confirm_password" required placeholder="Confirme su contraseña">
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="es_admin" name="es_admin">
                <label for="es_admin">¿Es administrador?</label>
            </div>

            <button type="submit">Registrarse</button>
        </form>

        <div class="login-link">
            ¿Ya tienes cuenta? <a href="#">Inicia sesión aquí</a>
        </div>
    </div>
</body>
</html>
