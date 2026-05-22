<?php
// api_usuarios.php — CRUD Fetch API para tabla usuarios
session_start();

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

header('Content-Type: application/json');

// ── CONEXIÓN ÚNICA ────────────────────────────────────────────────────────────
require_once 'conexion.php';
// ─────────────────────────────────────────────────────────────────────────────

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    // No devolvemos el password por seguridad
    $stmt = $pdo->query('SELECT id, nombre, correo, es_admin FROM usuarios ORDER BY id DESC');
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} elseif ($metodo === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['nombre']) || empty($data['correo']) || empty($data['password'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Nombre, correo y contraseña son obligatorios.']);
        exit;
    }

    $hash = password_hash($data['password'], PASSWORD_DEFAULT);
    $stmt = $pdo->prepare('INSERT INTO usuarios (nombre, correo, password, es_admin) VALUES (?, ?, ?, ?)');
    $stmt->execute([$data['nombre'], $data['correo'], $hash, $data['es_admin'] ?? 0]);
    echo json_encode(['ok' => true, 'id' => $pdo->lastInsertId()]);

} elseif ($metodo === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID requerido para actualizar.']);
        exit;
    }

    // Si mandan nueva contraseña la actualizamos, si no solo los demás campos
    if (!empty($data['password'])) {
        $hash = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt = $pdo->prepare('UPDATE usuarios SET nombre=?, correo=?, password=?, es_admin=? WHERE id=?');
        $stmt->execute([$data['nombre'], $data['correo'], $hash, $data['es_admin'] ?? 0, $data['id']]);
    } else {
        $stmt = $pdo->prepare('UPDATE usuarios SET nombre=?, correo=?, es_admin=? WHERE id=?');
        $stmt->execute([$data['nombre'], $data['correo'], $data['es_admin'] ?? 0, $data['id']]);
    }
    echo json_encode(['ok' => true]);

} elseif ($metodo === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (empty($data['id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'ID requerido para eliminar.']);
        exit;
    }

    $stmt = $pdo->prepare('DELETE FROM usuarios WHERE id=?');
    $stmt->execute([$data['id']]);
    echo json_encode(['ok' => true]);

} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido.']);
}
?>