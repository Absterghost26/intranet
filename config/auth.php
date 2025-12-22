<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/db.php";

/**
 * Obliga a que el usuario esté logueado
 */
function requireLogin() {
    if (!isset($_SESSION["usuario_id"])) {
        header("Location: index.php");
        exit;
    }
}

/**
 * Obliga a que el usuario tenga uno de los roles indicados
 */
function requireRole(array $rolesPermitidos) {
    requireLogin();

    if (!in_array($_SESSION["rol"], $rolesPermitidos)) {
        http_response_code(403);
        echo "Acceso denegado (rol insuficiente)";
        exit;
    }
}

/**
 * Obliga a que el usuario tenga permiso sobre una categoría
 */
function requirePermiso(string $categoria) {
    requireLogin();

    global $conexion;

    $sql = "
        SELECT 1
        FROM permisos p
        INNER JOIN categorias c ON c.id = p.categoria_id
        WHERE p.usuario_id = ?
        AND c.categoria = ?
        LIMIT 1
    ";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("is", $_SESSION["usuario_id"], $categoria);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 0) {
        http_response_code(403);
        echo "No tienes permiso para acceder a esta sección";
        exit;
    }
}
