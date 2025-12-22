<?php

require_once __DIR__ . "/../config/db.php";

class Usuario {

    private $db;

    public function __construct() {
        global $conexion;
        $this->db = $conexion;
    }


    public function validar($email, $password) {

        $sql = "SELECT id, email, rol, clave, estado, debe_cambiar_clave
                FROM usuarios
                WHERE email = ?
                LIMIT 1";

        $stmt = $this->db->prepare($sql);

        if (!$stmt) {
            return false;
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $resultado = $stmt->get_result();

        if ($resultado->num_rows !== 1) {
            return false;
        }

        $usuario = $resultado->fetch_assoc();

        if ($usuario["estado"] != 1) {
            return false;
        }

        if (!password_verify($password, $usuario["clave"])) {
            return false;
        }

        $this->actualizarUltimoLogin($usuario["id"]);

        return $usuario;
    }


    private function actualizarUltimoLogin($usuario_id) {
        $sql = "UPDATE usuarios SET ultimo_login = NOW() WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $usuario_id);
        $stmt->execute();
    }
}
