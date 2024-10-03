DROP DATABASE IF EXISTS tlaxomulco;

CREATE DATABASE tlaxomulco;

USE tlaxomulco;

CREATE TABLE usuario (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    usuario VARCHAR(30) NOT NULL,
    contraseña VARCHAR(30) NOT NULL
);

CREATE TABLE nivel_educativo (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE estado (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE genero (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE grado (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL,
    nivel_educativo_id INT NOT NULL,
    FOREIGN KEY (nivel_educativo_id) REFERENCES nivel_educativo(id)
);

CREATE TABLE ciclo (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE promocion (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE medio_enterado (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

-- La tabla alumno debe ser creada después de que grado esté creada
CREATE TABLE alumno (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(60) NOT NULL,
    Ap VARCHAR(50) NOT NULL,
    Am VARCHAR(50) NOT NULL,
    matricula INT NOT NULL,
    direccion VARCHAR(100) NOT NULL,
    estado INT NOT NULL,
    nivel INT NOT NULL,
    genero INT NOT NULL,
    grado_id INT NOT NULL,
    FOREIGN KEY (grado_id) REFERENCES grado(id),
    FOREIGN KEY (estado) REFERENCES estado(id),
    FOREIGN KEY (nivel) REFERENCES nivel_educativo(id),
    FOREIGN KEY (genero) REFERENCES genero(id)
);

CREATE TABLE registro (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    fecha DATE NOT NULL,
    pago_inscripcion INT NOT NULL,
    pago_colegiatura INT NOT NULL,
    medio_enterado INT NOT NULL,
    promocion INT NOT NULL,
    ciclo_escolar INT NOT NULL,
    alumno INT NOT NULL,
    usuario INT NOT NULL,
    FOREIGN KEY (medio_enterado) REFERENCES medio_enterado(id),
    FOREIGN KEY (promocion) REFERENCES promocion(id),
    FOREIGN KEY (ciclo_escolar) REFERENCES ciclo(id),
    FOREIGN KEY (alumno) REFERENCES alumno(id),
    FOREIGN KEY (usuario) REFERENCES usuario(id)
);

-- Inserciones iniciales
INSERT INTO usuario (usuario, contraseña) VALUES
('Dante', '123');

INSERT INTO nivel_educativo (descripcion) VALUES
('Primaria'),
('Secundaria'),
('Preparatoria');

-- Grados para Primaria
INSERT INTO grado (descripcion, nivel_educativo_id) VALUES
('Primero', 1),
('Segundo', 1),
('Tercero', 1),
('Cuarto', 1),
('Quinto', 1),
('Sexto', 1);

-- Grados para Secundaria
INSERT INTO grado (descripcion, nivel_educativo_id) VALUES
('Primero', 2),
('Segundo', 2),
('Tercero', 2);

-- Grados para Preparatoria
INSERT INTO grado (descripcion, nivel_educativo_id) VALUES
('Semestre 1', 3),
('Semestre 2', 3),
('Semestre 3', 3);
