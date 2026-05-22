<?php
// api_productos.php — Módulo B (Fetch API / CRUD asíncrono)
session_start();

if (!isset($_SESSION['usuario'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado.']);
    exit;
}

header('Content-Type: application/json');
require_once 'conexion.php';

$metodo = $_SERVER['REQUEST_METHOD'];

if ($metodo === 'GET') {
    // Columnas reales de tu tabla: id, codigo, descripcion, precio, cantidad
    $stmt = $pdo->query('SELECT id, codigo, descripcion, precio, cantidad FROM productos ORDER BY id DESC');
    echo json_encode($stmt->fetchAll(PDO::FETCH_ASSOC));

} elseif ($metodo === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (empty($data['codigo']) || empty($data['descripcion'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Código y descripción son obligatorios.']);
        exit;
    }
    $stmt = $pdo->prepare('INSERT INTO productos (codigo, descripcion, precio, cantidad) VALUES (?, ?, ?, ?)');
    $stmt->execute([$data['codigo'], $data['descripcion'], $data['precio'] ?? 0, $data['cantidad'] ?? 0]);
    echo json_encode(['ok' => true, 'id' => $pdo->lastInsertId()]);

} elseif ($metodo === 'PUT') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (empty($data['id'])) { http_response_code(400); echo json_encode(['error' => 'ID requerido.']); exit; }
    $stmt = $pdo->prepare('UPDATE productos SET codigo=?, descripcion=?, precio=?, cantidad=? WHERE id=?');
    $stmt->execute([$data['codigo'], $data['descripcion'], $data['precio'] ?? 0, $data['cantidad'] ?? 0, $data['id']]);
    echo json_encode(['ok' => true]);

} elseif ($metodo === 'DELETE') {
    $data = json_decode(file_get_contents('php://input'), true);
    if (empty($data['id'])) { http_response_code(400); echo json_encode(['error' => 'ID requerido.']); exit; }
    $stmt = $pdo->prepare('DELETE FROM productos WHERE id=?');
    $stmt->execute([$data['id']]);
    echo json_encode(['ok' => true]);

} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido.']);
}
?>