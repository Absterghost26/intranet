DROP DATABASE IF EXISTS intranet;
CREATE DATABASE intranet CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE intranet;

CREATE TABLE usuarios(
    id int AUTO_INCREMENT PRIMARY KEY,
    email varchar(100) NOT NULL UNIQUE,
    clave varchar(255) NOT NULL,
    rol ENUM('admin','usuario','supervisor') DEFAULT 'usuario',
    estado TINYINT(1) DEFAULT 1,
    debe_cambiar_clave TINYINT(1) DEFAULT 1,
    token_activacion varchar(64) NULL,
    fecha_creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    ultimo_login DATETIME NULL
) ENGINE=InnoDB;

CREATE TABLE datosPersonales(
    id int AUTO_INCREMENT PRIMARY KEY,
    usuario_id int NOT NULL,
    nombre varchar(65),
    telefono varchar(20),
    documento varchar(30),
    actualizado_en DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE categorias(
    id int AUTO_INCREMENT PRIMARY KEY,
    categoria varchar(45) NOT NULL,
    descripcion varchar(255),
    ruta varchar(40)
) ENGINE=InnoDB;

CREATE TABLE permisos(
    usuario_id int,
    categoria_id int,
    PRIMARY KEY (usuario_id, categoria_id),
    FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (categoria_id)
        REFERENCES categorias(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;
