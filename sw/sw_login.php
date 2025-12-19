<?php
session_start();
require_once "../clases/Usuario.php";

$usuarioObj = new Usuario();

if (isset($_POST["email"]) && isset($_POST["password"])) {

    if ($usuarioObj->validar($_POST["email"], $_POST["password"])) {

        $_SESSION["usuario"] = $_POST["email"];
        header("Location: ../inicio.php");
        exit;

    } else {
        header("Location: ../index.php?error=1");
        exit;
    }

} else {
    header("Location: ../index.php?error=2");
    exit;
}
