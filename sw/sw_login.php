<?php
require_once __DIR__ . "/../config/auth.php";
require_once __DIR__ . "/../clases/Usuario.php";

$usuarioObj = new Usuario();

if (!isset($_POST["email"], $_POST["password"])) {
    header("Location: ../index.php?error=2");
    exit;
}

$usuario = $usuarioObj->validar($_POST["email"], $_POST["password"]);

if ($usuario) {

    $_SESSION["usuario_id"] = $usuario["id"];
    $_SESSION["email"]      = $usuario["email"];
    $_SESSION["rol"]        = $usuario["rol"];

    $_SESSION["flash"] = "Bienvenido {$usuario['email']}";

    header("Location: ../inicio.php");
    exit;

} else {
    header("Location: ../index.php?error=1");
    exit;
}
