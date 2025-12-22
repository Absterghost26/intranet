<?php
require_once __DIR__ . "/config/db.php";

function obtenerUsuariosConCategorias() {
    global $conexion;

    $sql = "
        SELECT 
            u.usuario,
            d.nombre,
            d.email,
            c.categoria
        FROM usuarios u
        INNER JOIN datosPersonales d ON u.usuario = d.usuario
        INNER JOIN permisos p ON u.usuario = p.usuario
        INNER JOIN categorias c ON p.ID_Categoria = c.ID_Categoria
    ";

    $resultado = mysqli_query($conexion, $sql);

    if (!$resultado) {
        die("Error en la consulta SQL: " . mysqli_error($conexion));
    }

    return $resultado;
}
