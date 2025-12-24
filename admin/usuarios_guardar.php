<?php
require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../config/db.php";

requireLogin();
requireRole(['admin']);

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /intranet/usuarios.php");
    exit;
}

$email = trim($_POST['email']);
$rol   = $_POST['rol'];

if (!$email || !$rol) {
    $_SESSION['flash_error'] = "Datos incompletos.";
    header("Location: /intranet/admin/usuarios_crear.php");
    exit;
}

/* ===============================
   GENERAR CONTRASEÑA ALEATORIA
   =============================== */
$passwordPlano = bin2hex(random_bytes(4)); // 8 caracteres
$passwordHash  = password_hash($passwordPlano, PASSWORD_DEFAULT);

/* ===============================
   INSERTAR USUARIO
   =============================== */
$stmt = $conexion->prepare(
    "INSERT INTO usuarios (email, clave, rol, estado, debe_cambiar_clave)
     VALUES (?, ?, ?, 1, 1)"
);

$stmt->bind_param("sss", $email, $passwordHash, $rol);

if (!$stmt->execute()) {
    $_SESSION['flash_error'] = "Error al crear el usuario.";
    header("Location: /intranet/admin/usuarios_crear.php");
    exit;
}

/* ===============================
   GUARDAR DATOS PARA EL MODAL
   =============================== */
$_SESSION['nuevo_usuario'] = [
    'email'    => $email,
    'password' => $passwordPlano,
    'rol'      => $rol
];

/* ===============================
   REDIRECCIÓN CORRECTA
   =============================== */
header("Location: /intranet/usuarios.php");
exit;
