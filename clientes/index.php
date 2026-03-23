<?php
// dashboard.php
session_start();

// Verificar si el usuario está autenticado
//if (!isset($_SESSION['clientes'])) {
//    header('Location: login.php');
//    exit;
//}

$userName = $_SESSION['user_name'] ?? 'Cliente';


require_once '../lib/conn.php';

// Obtener usuarios de la base de datos
$sql = "SELECT * FROM clientes ORDER BY id DESC";
$result = $conexion->query($sql);
$clientes = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Listado de Clientes</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* Header */
        .header {
            background-color: #2c3e50;
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .header h1 {
            font-size: 24px;
        }

        .user-menu {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info span {
            font-weight: 500;
        }

        .logout-btn {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        /* Container Principal */
        .container {
            display: flex;
            flex: 1;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #34495e;
            color: white;
            padding: 20px 0;
            box-shadow: 2px 0 5px rgba(0,0,0,0.1);
        }

        .sidebar ul {
            list-style: none;
        }

        .sidebar li {
            margin: 0;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 15px 20px;
            transition: background-color 0.3s, padding-left 0.3s;
            border-left: 4px solid transparent;
        }

        .sidebar a:hover {
            background-color: #2c3e50;
            border-left-color: #3498db;
            padding-left: 25px;
        }

        .sidebar a.active {
            background-color: #2980b9;
            border-left-color: #3498db;
        }

        /* Contenido Principal */
        .main-content {
            flex: 1;
            padding: 30px;
            background-color: #f5f5f5;
        }

        .content-area {
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            min-height: 400px;
        }

        .content-area h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }

        /* Footer */
        .footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: auto;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.1);
        }

        .footer p {
            margin: 0;
            font-size: 14px;
        }

        .footer a {
            color: #3498db;
            text-decoration: none;
        }

        .footer a:hover {
            text-decoration: underline;
        }
        
        .tabla-usuarios {
            font-size: 0.95rem;
        }
        .tabla-usuarios thead {
            background-color: #007bff;
            color: white;
        }
        .tabla-usuarios tbody tr:hover {
            background-color: #f5f5f5;
        }
        .acciones {
            display: flex;
            gap: 5px;
            justify-content: center;
        }
        .btn-sm {
            padding: 0.4rem 0.6rem;
            font-size: 0.85rem;
        }
    </style>
</head>
<body>
    <!-- Header -->
     <?php 
     include ('../templates/header.php'); 
     ?>

    <!-- Container Principal -->
    <div class="container">
        <!-- Sidebar -->
             <?php 
             include ('../templates/sidebar.php'); 
             ?>

        <!-- Contenido Principal -->
        <main class="main-content">
            <div class="content-area">
                <h2>Listado de clientes</h2>

                
        <?php if (isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_SESSION['mensaje']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; 
            unset($_SESSION['mensaje']);
        ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (count($clientes) > 0): ?>
            <div class="table-responsive">
                <table class="table table-hover tabla-usuarios">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Domicilio</th>
                            <th>Giro</th>
                            <th>Razon Social</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clientes as $cliente): ?>
                            <tr>
                                <td><?php echo $cliente['id']; ?></td>
                                <td><?php echo htmlspecialchars($cliente['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['domicilio']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['giro']); ?></td>
                                <td><?php echo htmlspecialchars($cliente['razon_social']); ?></td>
                                <td>
                                    <div class="acciones">
                                        <a href="ver.php?id=<?php echo $cliente['id']; ?>" class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="editar.php?id=<?php echo $cliente['id']; ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" action="delete.php" 
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?');">
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                ><i class="fas fa-trash"></i></button>
                                            <input id="id" name="id" type="hidden" 
                                                value="<?php echo $cliente['id']; ?>">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center">
                <i class="fas fa-info-circle"></i> No hay clientes registrados
            </div>
        <?php endif; ?>
    </div>

            </div>
        </main>
    </div>

    <!-- Footer -->
        <?php 
        include ('../templates/footer.php'); 
        ?>
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>