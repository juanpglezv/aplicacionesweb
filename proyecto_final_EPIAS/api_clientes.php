<?php
// api_clientes.php — CRUD Fetch API para tabla clientes
session_start();

// Protección: solo usuarios autenticados
if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado. Inicia sesión primero.']);
    exit;
}

header('Content-Type: application/json');

// ── CONEXIÓN ÚNICA ────────────────────────────────────────────────────────────
require_once 'conexion.php';
// ─────────────────────────────────────────────────────────────────────────────

$metodo = $_SERVER['REQUEST_METHOD'];

// ── GET: Leer todos los clientes ─────────────────────────────────────────────
if ($metodo === 'GET') {
    $stmt = $pdo->query('SELECT id, nombre, domicilio, giro, razon_social FROM clientes ORDER BY id DESC');
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));
}

// ── POST: Crear un nuevo cliente ─────────────────────────────────────────────
elseif ($metodo === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['nombre'])) {
        http_response_code(400);
        echo json_encode(['error' => 'El nombre del cliente es obligatorio.']);
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO clientes (nombre, domicilio, giro, razon_social) VALUES (?, ?, ?, ?)');
    $stmt->execute([
        $data['nombre'],
        $data['domicilio']    ?? '',
        $data['giro']         ?? '',
        $data['razon_social'] ?? ''
    ]);
    echo json_encode(['ok' => true, 'id' => $pdo->lastInsertId()]);
}

// ── PUT: Actualizar un cliente existente ──────────────────────────────────────
elseif ($metodo === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID requerido para actualizar.']);
        exit;
    }

    $stmt = $pdo->prepare('UPDATE clientes SET nombre=?, domicilio=?, giro=?, razon_social=? WHERE id=?');
    $stmt->execute([
        $data['nombre'],
        $data['domicilio']    ?? '',
        $data['giro']         ?? '',
        $data['razon_social'] ?? '',
        $data['id']
    ]);
    echo json_encode(['ok' => true]);
}

// ── DELETE: Eliminar un cliente ───────────────────────────────────────────────
elseif ($metodo === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID requerido para eliminar.']);
        exit;
    }

    $stmt = $pdo->prepare('DELETE FROM clientes WHERE id=?');
    $stmt->execute([$data['id']]);
    echo json_encode(['ok' => true]);
}

else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido.']);
}
?>