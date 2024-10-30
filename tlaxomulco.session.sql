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
    FOREIGN KEY (municipio_id) REFERENCES municipio(id) ON DELETE CASCADE
);

CREATE TABLE genero (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL
);

CREATE TABLE grado (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    descripcion VARCHAR(50) NOT NULL,
    nivel_educativo_id INT NOT NULL,
    FOREIGN KEY (nivel_educativo_id) REFERENCES nivel_educativo(id) ON DELETE CASCADE
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
    FOREIGN KEY (nivel_educativo_id) REFERENCES nivel_educativo(id) ON DELETE CASCADE,
    FOREIGN KEY (grado_id) REFERENCES grado(id) ON DELETE CASCADE,
    FOREIGN KEY (ciclo_id) REFERENCES ciclo(id) ON DELETE CASCADE
);

CREATE TABLE alumno (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(60) NOT NULL,
    Ap VARCHAR(50) NOT NULL,
    Am VARCHAR(50) NOT NULL,
    matricula INT NOT NULL,
    municipio INT NOT NULL,
    genero INT NOT NULL,
    colonia INT NOT NULL,
    medio_enterado INT NOT NULL,
    promocion INT NOT NULL,
    estado INT NOT NULL,
    nivel_grado_ciclo_id INT NOT NULL,
    FOREIGN KEY (nivel_grado_ciclo_id) REFERENCES nivel_grado_ciclo(id) ON DELETE CASCADE,
    FOREIGN KEY (estado) REFERENCES estado(id) ON DELETE CASCADE,
    FOREIGN KEY (promocion) REFERENCES promocion(id) ON DELETE CASCADE,
    FOREIGN KEY (medio_enterado) REFERENCES medio_enterado(id) ON DELETE CASCADE,
    FOREIGN KEY (colonia) REFERENCES colonia(id) ON DELETE CASCADE,
    FOREIGN KEY (municipio) REFERENCES municipio(id) ON DELETE CASCADE,
    FOREIGN KEY (genero) REFERENCES genero(id) ON DELETE CASCADE
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
('Semestre 3', 4),
('Semestre 4', 4),
('Semestre 5', 4),  
('Semestre 6', 4);

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
(4, 13, 1),  -- Bachillerato, Semestre 1, 2020-2021
(4, 13, 2),  -- Bachillerato, Semestre 1, 2021-2022
(4, 13, 3),  -- Bachillerato, Semestre 1, 2022-2023
(4, 14, 1),  -- Bachillerato, Semestre 2, 2020-2021
(4, 14, 2),  -- Bachillerato, Semestre 2, 2021-2022
(4, 14, 3),  -- Bachillerato, Semestre 2, 2022-2023
(4, 15, 1),  -- Bachillerato, Semestre 3, 2020-2021
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

-- Inserciones de alumnos
INSERT INTO alumno (nombre, Ap, Am, matricula, estado, municipio, genero, colonia, medio_enterado, promocion, nivel_grado_ciclo_id) VALUES
('Juan', 'Pérez', 'López', 12345, 1, 1, 1, 1, 1, 1, 1),
('María', 'García', 'Hernández', 12346, 2, 1, 2, 2, 2, 2, 1),
('Luis', 'Méndez', 'Sánchez', 12347, 2, 2, 1, 3, 3, 3, 1),
('Sofía', 'Morales', 'Torres', 12348, 1, 3, 2, 4, 4, 1, 1),
('Diego', 'Castillo', 'Jiménez', 12349, 2, 1, 1, 1, 1, 1, 1),
('Ana', 'Rojas', 'Soto', 12350, 1, 2, 2, 2, 2, 2, 1),
('Carlos', 'Vázquez', 'Ríos', 12351, 1, 3, 1, 3, 3, 3, 1),
('Elena', 'Romero', 'Salinas', 12352, 2, 4, 2, 4, 4, 1, 1),
('Fernando', 'Núñez', 'Aguilar', 12353, 2, 1, 1, 1, 1, 1, 1),
('Gabriela', 'Mendoza', 'Palacios', 12354, 1, 2, 2, 2, 2, 2, 1),
('Mateo', 'Cervantes', 'Paredes', 12355, 1, 3, 1, 3, 3, 3, 1),
('Luisa', 'Alvarado', 'Martínez', 12356, 2, 4, 2, 4, 4, 1, 1),
('Roberto', 'Ponce', 'Aguilar', 12357, 1, 1, 1, 1, 1, 1, 1),
('Paola', 'Vera', 'Cisneros', 12358, 1, 2, 2, 2, 2, 2, 1),
('Andrés', 'Morales', 'Hernández', 12359, 2, 3, 1, 3, 3, 3, 1),
('Cecilia', 'Bermúdez', 'Rivas', 12360, 1, 4, 2, 4, 4, 1, 1),
('Ricardo', 'Salazar', 'Reyes', 12361, 2, 1, 1, 1, 1, 1, 1),
('Fernanda', 'Escobar', 'Sandoval', 12362, 1, 2, 2, 2, 2, 2, 1),
('Jorge', 'Camacho', 'Ramírez', 12363, 1, 3, 1, 3, 3, 3, 1),
('Tatiana', 'Cuéllar', 'Villanueva', 12364, 2, 4, 2, 4, 4, 1, 1),
('Hugo', 'Rangel', 'Fuentes', 12365, 1, 1, 1, 1, 1, 1, 1),
('Martha', 'López', 'Cortez', 12366, 1, 2, 2, 2, 2, 2, 1),
('Pablo', 'González', 'Esquivel', 12367, 2, 3, 1, 3, 3, 3, 1),
('Verónica', 'Cortez', 'Molina', 12368, 2, 4, 2, 4, 4, 1, 1),
('Emilio', 'Aragón', 'Salgado', 12369, 2, 1, 1, 1, 1, 1, 1),
('Claudia', 'Bautista', 'Sandoval', 12370, 2, 2, 2, 2, 2, 2, 1),
('Omar', 'Reyes', 'González', 12371, 2, 3, 1, 3, 3, 3, 1),
('Gina', 'Pérez', 'Ponce', 12372, 2, 4, 2, 4, 4, 1, 1),
('Nicolás', 'Aguirre', 'Delgado', 12373, 1, 1, 1, 1, 1, 1, 1),
('Juliana', 'Serrano', 'Armas', 12374, 1, 2, 2, 2, 2, 2, 1),
('Raúl', 'Medina', 'Téllez', 12375, 1, 3, 1, 3, 3, 3, 1),
('Lina', 'Santana', 'Valenzuela', 12376, 2, 4, 2, 4, 4, 1, 1),
('Álvaro', 'Cordero', 'Banda', 12377, 2, 1, 1, 1, 1, 1, 1),
('Natalia', 'Gálvez', 'Rojas', 12378, 1, 2, 2, 2, 2, 2, 1),
('Héctor', 'Chávez', 'Soto', 12379, 2, 3, 1, 3, 3, 3, 1),
('Karina', 'Pineda', 'Gómez', 12380, 2, 4, 2, 4, 4, 1, 1),
('Fernando', 'Vega', 'Riviera', 12381, 1, 1, 1, 1, 1, 1, 1),
('Martín', 'Flores', 'Zamora', 12382, 1, 2, 2, 2, 2, 2, 1),
('Alberto', 'Hinojosa', 'Salgado', 12383, 1, 3, 1, 3, 3, 3, 1),
('Silvia', 'Mora', 'Núñez', 12384, 2, 4, 2, 4, 4, 1, 1),
('Victor', 'Navarro', 'Rosales', 12385, 1, 1, 1, 1, 1, 1, 1),
('Gloria', 'Salas', 'Aguirre', 12386, 1, 2, 2, 2, 2, 2, 1),
('Fabián', 'Salinas', 'Vázquez', 12387, 2, 3, 1, 3, 3, 3, 1),
('Nora', 'Parra', 'Romero', 12388, 2, 4, 2, 4, 4, 1, 1),
('Raúl', 'Cano', 'Alvarado', 12389, 1, 1, 1, 1, 1, 1, 1),
('Julia', 'Montalvo', 'Téllez', 12390, 1, 2, 2, 2, 2, 2, 1),
('Santiago', 'Nava', 'Montes', 12391, 1, 3, 1, 3, 3, 3, 1),
('Rocío', 'Cruz', 'Gómez', 12392, 2, 4, 2, 4, 4, 1, 1),
('Arturo', 'Gámez', 'Sánchez', 12393, 2, 1, 1, 1, 1, 1, 1),
('Leticia', 'López', 'Zúñiga', 12394, 2, 2, 2, 2, 2, 2, 1),
('Pablo', 'Ortega', 'López', 12395, 2, 3, 1, 3, 3, 3, 1),
('Patricia', 'Sierra', 'Lira', 12396, 1, 4, 2, 4, 4, 1, 1),
('Omar', 'Quintero', 'Vallejo', 12397, 1, 1, 1, 1, 1, 1, 1),
('Araceli', 'Sandoval', 'Alarcón', 12398, 1, 2, 2, 2, 2, 2, 1),
('José', 'Hernández', 'Paredes', 12399, 2, 3, 1, 3, 3, 3, 1),
('Silvia', 'Cisneros', 'Cisneros', 12400, 2, 4, 2, 4, 4, 1, 1);
