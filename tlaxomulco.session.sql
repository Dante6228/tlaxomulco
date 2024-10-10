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

CREATE TABLE municipio (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE colonia (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL,
    municipio_id INT NOT NULL, 
    FOREIGN KEY (municipio_id) REFERENCES municipio(id) 
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

CREATE TABLE estado(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE nivel_grado_ciclo (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nivel_educativo_id INT NOT NULL,
    grado_id INT NOT NULL,
    ciclo_id INT NOT NULL,
    FOREIGN KEY (nivel_educativo_id) REFERENCES nivel_educativo(id),
    FOREIGN KEY (grado_id) REFERENCES grado(id),
    FOREIGN KEY (ciclo_id) REFERENCES ciclo(id)
);

CREATE TABLE alumno (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(60) NOT NULL,
    Ap VARCHAR(50) NOT NULL,
    Am VARCHAR(50) NOT NULL,
    matricula INT NOT NULL,
    municipio INT NOT NULL,
    nivel INT NOT NULL,
    genero INT NOT NULL,
    grado_id INT NOT NULL,
    colonia INT NOT NULL,
    medio_enterado INT NOT NULL,
    promocion INT NOT NULL,
    estado INT NOT NULL,
    FOREIGN KEY (estado) REFERENCES estado(id),
    FOREIGN KEY (promocion) REFERENCES promocion(id),
    FOREIGN KEY (medio_enterado) REFERENCES medio_enterado(id),
    FOREIGN KEY (colonia) REFERENCES colonia(id),
    FOREIGN KEY (grado_id) REFERENCES grado(id),
    FOREIGN KEY (municipio) REFERENCES municipio(id),
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
('Preescolar'),
('Primaria'),
('Secundaria'),
('Bachillerato');

-- Grados para Preescolar
INSERT INTO grado (descripcion, nivel_educativo_id) VALUES
('Primero', 1),
('Segundo', 1),
('Tercero', 1);

-- Grados para Primaria
INSERT INTO grado (descripcion, nivel_educativo_id) VALUES
('Primero', 2),
('Segundo', 2),
('Tercero', 2),
('Cuarto', 2),
('Quinto', 2),
('Sexto', 2);

-- Grados para Secundaria
INSERT INTO grado (descripcion, nivel_educativo_id) VALUES
('Primero', 3),
('Segundo', 3),
('Tercero', 3);

-- Grados para Preparatoria
INSERT INTO grado (descripcion, nivel_educativo_id) VALUES
('Semestre 1', 4),
('Semestre 2', 4),
('Semestre 3', 4);

INSERT INTO ciclo (descripcion) VALUES
('2020-2021'),
('2021-2022'),
('2022-2023');

-- Relación entre Preescolar y sus grados
INSERT INTO nivel_grado_ciclo (nivel_educativo_id, grado_id, ciclo_id) VALUES
(1, 1, 1),  -- Preescolar, Primero, 2020-2021
(1, 1, 2),  -- Preescolar, Primero, 2021-2022
(1, 1, 3),  -- Preescolar, Primero, 2022-2023
(1, 2, 1),  -- Preescolar, Segundo, 2020-2021
(1, 2, 2),  -- Preescolar, Segundo, 2021-2022
(1, 2, 3),  -- Preescolar, Segundo, 2022-2023
(1, 3, 1),  -- Preescolar, Tercero, 2020-2021
(1, 3, 2),  -- Preescolar, Tercero, 2021-2022
(1, 3, 3);  -- Preescolar, Tercero, 2022-2023

-- Relación entre Primaria y sus grados
INSERT INTO nivel_grado_ciclo (nivel_educativo_id, grado_id, ciclo_id) VALUES
(2, 4, 1),  -- Primaria, Primero, 2020-2021
(2, 4, 2),  -- Primaria, Primero, 2021-2022
(2, 4, 3),  -- Primaria, Primero, 2022-2023
(2, 5, 1),  -- Primaria, Segundo, 2020-2021
(2, 5, 2),  -- Primaria, Segundo, 2021-2022
(2, 5, 3),  -- Primaria, Segundo, 2022-2023
(2, 6, 1),  -- Primaria, Tercero, 2020-2021
(2, 6, 2),  -- Primaria, Tercero, 2021-2022
(2, 6, 3),  -- Primaria, Tercero, 2022-2023
(2, 7, 1),  -- Primaria, Cuarto, 2020-2021
(2, 7, 2),  -- Primaria, Cuarto, 2021-2022
(2, 7, 3),  -- Primaria, Cuarto, 2022-2023
(2, 8, 1),  -- Primaria, Quinto, 2020-2021
(2, 8, 2),  -- Primaria, Quinto, 2021-2022
(2, 8, 3),  -- Primaria, Quinto, 2022-2023
(2, 9, 1),  -- Primaria, Sexto, 2020-2021
(2, 9, 2),  -- Primaria, Sexto, 2021-2022
(2, 9, 3);  -- Primaria, Sexto, 2022-2023

-- Relación entre Secundaria y sus grados
INSERT INTO nivel_grado_ciclo (nivel_educativo_id, grado_id, ciclo_id) VALUES
(3, 10, 1),  -- Secundaria, Primero, 2020-2021
(3, 10, 2),  -- Secundaria, Primero, 2021-2022
(3, 10, 3),  -- Secundaria, Primero, 2022-2023
(3, 11, 1),  -- Secundaria, Segundo, 2020-2021
(3, 11, 2),  -- Secundaria, Segundo, 2021-2022
(3, 11, 3),  -- Secundaria, Segundo, 2022-2023
(3, 12, 1),  -- Secundaria, Tercero, 2020-2021
(3, 12, 2),  -- Secundaria, Tercero, 2021-2022
(3, 12, 3);  -- Secundaria, Tercero, 2022-2023

-- Relación entre Bachillerato y sus grados
INSERT INTO nivel_grado_ciclo (nivel_educativo_id, grado_id, ciclo_id) VALUES
(4, 13, 2),  -- Bachillerato, Semestre 1, 2021-2022
(4, 13, 3),  -- Bachillerato, Semestre 1, 2022-2023
(4, 14, 2),  -- Bachillerato, Semestre 2, 2021-2022
(4, 14, 3),  -- Bachillerato, Semestre 2, 2022-2023
(4, 15, 2),  -- Bachillerato, Semestre 3, 2021-2022
(4, 15, 3);  -- Bachillerato, Semestre 3, 2022-2023

-- Inserciones de estados
INSERT INTO municipio (descripcion) VALUES
('Cuautitlan'),
('Xaltipa'),
('San Blas'),
('Melchor');

-- Inserciones de colonias para Cuautitlán (municipio_id = 1)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Villas de Cuautitlán', 1),
('San Mateo Ixtacalco', 1),
('Santa María Huecatitla', 1);

-- Inserciones de colonias para Xaltipa (municipio_id = 2)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Centro', 2),
('El Cerrito', 2);

-- Inserciones de colonias para San Blas (municipio_id = 3)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('San Blas Centro', 3),
('La Concepción', 3);

-- Inserciones de colonias para Melchor Ocampo (municipio_id = 4)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Melchor Ocampo Centro', 4),
('Visitación', 4);

-- Inserciones de géneros
INSERT INTO genero (descripcion) VALUES
('Masculino'),
('Femenino'),
('No binario');

-- Inserciones de medios enterados
INSERT INTO medio_enterado (descripcion) VALUES
('Internet'),
('Amigos'),
('Familia'),
('Publicidad');

-- Inserciones de promociones
INSERT INTO promocion (descripcion) VALUES
('Descuento del 10%'),
('Descuento del 20%'),
('Beca del 50%');

INSERT INTO estado (descripcion) VALUES
('Nuevo ingreso'),
('Reinscripcion');

-- Inserciones de alumnos con el campo medio_enterado corregido
INSERT INTO alumno (nombre, Ap, Am, matricula, estado, municipio, nivel, genero, grado_id, colonia, medio_enterado, promocion) VALUES
('Juan', 'Pérez', 'López', 12345, 1, 1, 2, 1, 4, 1, 1, 1),  -- Medio enterado: Internet
('María', 'García', 'Hernández', 12346, 2, 2, 3, 2, 10, 4, 2, 2), -- Medio enterado: Amigos
('Luis', 'Méndez', 'Sánchez', 12347, 2, 3, 4, 1, 13, 6, 3, 3), -- Medio enterado: Familia
('Sofía', 'Morales', 'Torres', 12348, 2, 4, 1, 2, 5, 7, 4, 1); -- Medio enterado: Publicidad


-- Inserciones de registros
INSERT INTO registro (fecha, pago_inscripcion, pago_colegiatura, medio_enterado, promocion, ciclo_escolar, alumno, usuario) VALUES
('2022-08-15', 500, 3000, 1, 1, 1, 1, 1),  -- Juan
('2022-08-16', 500, 3000, 2, 2, 1, 2, 1),  -- María
('2022-08-17', 500, 4000, 3, 3, 2, 3, 1),  -- Luis
('2022-08-18', 500, 3000, 1, 1, 1, 4, 1);  -- Sofía
