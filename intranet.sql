DROP DATABASE IF EXISTS intranet;
CREATE DATABASE intranet CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE intranet;

CREATE TABLE usuarios(
    usuario varchar(45) PRIMARY KEY,
    clave varchar(255) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE datosPersonales(
    usuario varchar(45) PRIMARY KEY,
    nombre varchar(65),
    email varchar(45),
    FOREIGN KEY (usuario)
        REFERENCES usuarios(usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;

CREATE TABLE categorias(
    ID_Categoria int AUTO_INCREMENT PRIMARY KEY,
    categoria varchar(45) NOT NULL,
    descripcion varchar(255) NOT NULL,
    ruta varchar(40) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE permisos(
    usuario VARCHAR(45),
    ID_Categoria int,
    PRIMARY KEY (usuario, ID_Categoria),
    FOREIGN KEY (usuario)
        REFERENCES usuarios(usuario)
        ON DELETE CASCADE
        ON UPDATE CASCADE,
    FOREIGN KEY (ID_Categoria)
        REFERENCES categorias(ID_Categoria)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;
