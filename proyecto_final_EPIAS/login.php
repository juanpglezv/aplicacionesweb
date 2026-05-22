<?php
$error = '';
if (isset($_GET['error'])) {
    if ($_GET['error'] === 'credenciales_invalidas') $error = '❌ Correo o contraseña incorrectos.';
    elseif ($_GET['error'] === 'campos_vacios')      $error = '⚠️ Por favor completa todos los campos.';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso al Sistema — EPIAS</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --azul-oscuro: #0b1f3a;
            --azul-medio:  #123458;
            --azul-agua:   #1e6fa8;
            --azul-claro:  #3a9fd6;
            --verde-agua:  #2aa198;
            --acento:      #00d4aa;
        }

        *, *::before, *::after { margin:0; padding:0; box-sizing:border-box; }

        body {
            font-family: 'Montserrat', sans-serif;
            min-height: 100vh;
            display: flex;
            background: var(--azul-oscuro);
            overflow: hidden;
        }

        /* ── Panel izquierdo decorativo ── */
        .left-panel {
            flex: 1;
            background:
                linear-gradient(155deg, rgba(11,31,58,0.85) 0%, rgba(0,212,170,0.12) 100%),
                linear-gradient(to bottom right, var(--azul-medio), var(--verde-agua));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px 50px;
            position: relative;
            overflow: hidden;
        }

        /* Círculos decorativos de fondo */
        .left-panel::before {
            content: '';
            position: absolute;
            width: 500px; height: 500px;
            border-radius: 50%;
            border: 1px solid rgba(0,212,170,0.12);
            top: -100px; left: -100px;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            width: 350px; height: 350px;
            border-radius: 50%;
            border: 1px solid rgba(0,212,170,0.1);
            bottom: -80px; right: -80px;
        }

        .brand-logo {
            width: 110px; height: 110px;
            border-radius: 24px;
            object-fit: cover;
            border: 3px solid rgba(0,212,170,0.5);
            box-shadow: 0 0 0 10px rgba(0,212,170,0.07), 0 20px 50px rgba(0,0,0,0.25);
            margin-bottom: 32px;
            position: relative;
            z-index: 1;
        }

        .brand-name {
            font-size: 42px;
            font-weight: 900;
            color: #fff;
            letter-spacing: 5px;
            position: relative;
            z-index: 1;
            margin-bottom: 8px;
        }

        .brand-line {
            width: 50px; height: 3px;
            background: var(--acento);
            border-radius: 2px;
            margin: 16px auto;
            position: relative;
            z-index: 1;
        }

        .brand-desc {
            font-size: 13px;
            color: rgba(255,255,255,0.65);
            text-align: center;
            max-width: 280px;
            line-height: 1.9;
            position: relative;
            z-index: 1;
        }

        .features-list {
            list-style: none;
            margin-top: 40px;
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 300px;
        }

        .features-list li {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid rgba(255,255,255,0.07);
            font-size: 13px;
            color: rgba(255,255,255,0.6);
            font-weight: 500;
        }

        .features-list li:last-child { border-bottom: none; }

        .feat-dot {
            width: 6px; height: 6px;
            background: var(--acento);
            border-radius: 50%;
            flex-shrink: 0;
        }

        /* ── Panel derecho — formulario ── */
        .right-panel {
            width: 480px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px 55px;
            position: relative;
            overflow-y: auto;
        }

        .right-panel::before {
            content: '';
            position: absolute;
            top: 0; left: 0; bottom: 0;
            width: 3px;
            background: linear-gradient(to bottom, var(--acento), var(--azul-agua), transparent);
        }

        .form-header { margin-bottom: 40px; }

        .form-header .welcome {
            font-size: 11px;
            font-weight: 700;
            color: var(--azul-agua);
            letter-spacing: 2px;
            text-transform: uppercase;
            display: block;
            margin-bottom: 12px;
        }

        .form-header h1 {
            font-size: 30px;
            font-weight: 900;
            color: var(--azul-oscuro);
            line-height: 1.2;
            margin-bottom: 10px;
        }

        .form-header p {
            font-size: 13px;
            color: #8899aa;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 11px;
            font-weight: 700;
            color: var(--azul-agua);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
        }

        .input-wrap {
            position: relative;
        }

        .input-wrap .icon {
            position: absolute;
            left: 16px; top: 50%;
            transform: translateY(-50%);
            font-size: 15px;
            opacity: 0.45;
            pointer-events: none;
        }

        .input-wrap input {
            width: 100%;
            padding: 14px 16px 14px 46px;
            border: 2px solid #e8f0f7;
            border-radius: 12px;
            font-size: 14px;
            font-family: 'Montserrat', sans-serif;
            color: var(--azul-oscuro);
            background: #f6f9fc;
            transition: all 0.25s;
        }

        .input-wrap input:focus {
            outline: none;
            border-color: var(--azul-agua);
            background: #fff;
            box-shadow: 0 0 0 4px rgba(30,111,168,0.08);
        }

        .toggle-pass {
            position: absolute;
            right: 14px; top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 16px;
            opacity: 0.4;
            transition: opacity 0.2s;
            user-select: none;
        }
        .toggle-pass:hover { opacity: 0.8; }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, var(--azul-agua) 0%, var(--verde-agua) 100%);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 800;
            font-family: 'Montserrat', sans-serif;
            cursor: pointer;
            transition: all 0.3s;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
            margin-top: 6px;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(255,255,255,0.1), transparent);
            opacity: 0;
            transition: opacity 0.3s;
        }

        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(30,111,168,0.35);
        }
        .btn-submit:hover::before { opacity: 1; }
        .btn-submit:active { transform: translateY(0); }

        .error-box {
            background: #fff1f0;
            border: 1px solid #ffd4d0;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 13px;
            font-weight: 600;
            color: #c0392b;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 14px;
            margin: 24px 0;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e8f0f7;
        }

        .divider span {
            font-size: 12px;
            color: #aab4be;
            font-weight: 600;
        }

        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            color: var(--azul-agua);
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            padding: 12px;
            border-radius: 12px;
            border: 2px solid #e8f0f7;
            transition: all 0.2s;
        }

        .back-link:hover {
            border-color: var(--azul-agua);
            background: rgba(30,111,168,0.04);
        }

        .form-footer {
            margin-top: 30px;
            text-align: center;
        }

        .form-footer p {
            font-size: 12px;
            color: #c0ccd8;
        }

        @media (max-width: 900px) {
            .left-panel { display: none; }
            .right-panel { width: 100%; padding: 50px 36px; }
        }
    </style>
</head>
<body>

    <!-- Panel izquierdo — branding -->
    <div class="left-panel">
        <img src="EPIAS.jpg" alt="EPIAS" class="brand-logo">
        <div class="brand-name">EPIAS</div>
        <div class="brand-line"></div>
        <p class="brand-desc">Estudios y Proyectos de Ingeniería Ambiental y Sanitaria de los Altos de Jalisco</p>

        <ul class="features-list">
            <li><span class="feat-dot"></span> Plantas Potabilizadoras</li>
            <li><span class="feat-dot"></span> Tratamiento de Aguas Residuales</li>
            <li><span class="feat-dot"></span> Biogás e Hidrógeno Renovable</li>
            <li><span class="feat-dot"></span> Cumplimiento NOM / SEMARNAT</li>
            <li><span class="feat-dot"></span> Más de 20 años de experiencia</li>
        </ul>
    </div>

    <!-- Panel derecho — formulario -->
    <div class="right-panel">
        <div class="form-header">
            <span class="welcome">Sistema de Administración</span>
            <h1>Bienvenido<br>de vuelta</h1>
            <p>Ingresa tus credenciales para acceder al panel de administración.</p>
        </div>

        <?php if ($error): ?>
        <div class="error-box">
            <span>⚠️</span> <?php echo htmlspecialchars($error); ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="verificacion.php">
            <div class="form-group">
                <label>Correo Electrónico</label>
                <div class="input-wrap">
                    <span class="icon">✉️</span>
                    <input type="email" name="email" placeholder="tu@correo.com" required autocomplete="email">
                </div>
            </div>

            <div class="form-group">
                <label>Contraseña</label>
                <div class="input-wrap">
                    <span class="icon">🔒</span>
                    <input type="password" name="password" id="pwd-input" placeholder="••••••••" required autocomplete="current-password">
                    <span class="toggle-pass" onclick="togglePass()">👁</span>
                </div>
            </div>

            <button type="submit" class="btn-submit">Iniciar Sesión →</button>
        </form>

        <div class="divider"><span>o</span></div>

        <a href="index.html" class="back-link">← Volver al sitio web</a>

        <div class="form-footer">
            <p>Contraseña de prueba: <strong>12345678</strong></p>
        </div>
    </div>

    <script>
        function togglePass() {
            const i = document.getElementById('pwd-input');
            i.type = i.type === 'password' ? 'text' : 'password';
        }
    </script>
</body>
</html>