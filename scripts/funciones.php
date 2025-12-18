<?php

function obtenerUsuariosConCategorias() {

    $conexion = mysqli_connect("127.0.0.1", "root", "", "intranet", 3307);

    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

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
        die("Error en la consulta SQL");
    }

    return $resultado;
}
