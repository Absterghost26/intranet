<?php

class Usuario {

    private $conexion;

    public function __construct() {
        $this->conexion = new mysqli("127.0.0.1", "root", "", "intranet", 3307);

        if ($this->conexion->connect_error) {
            die("Error de conexión: " . $this->conexion->connect_error);
        }
    }

    public function validar($email, $password) {

        $stmt = $this->conexion->prepare(
            "SELECT usuario FROM datosPersonales 
             INNER JOIN usuarios USING(usuario)
             WHERE email = ? AND clave = ?"
        );

        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $stmt->store_result();

        return $stmt->num_rows > 0;
    }
}
