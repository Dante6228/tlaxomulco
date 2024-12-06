DROP DATABASE IF EXISTS tlaxomulco;

CREATE DATABASE tlaxomulco;

USE tlaxomulco;

CREATE TABLE usuario (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(50) NOT NULL,
    usuario VARCHAR(30) NOT NULL,
    contraseña VARCHAR(255) NOT NULL
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
    matricula INT NOT NULL UNIQUE,
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

-- ==============================================================
-- INSERT DE USUARIO --
-- ==============================================================

INSERT INTO usuario (nombre, usuario, contraseña) VALUES
('Admin', 'Admin', '$2y$10$NFX2D5z2RS6zHwaHTWD.nOCN2MtD5GeZrihqn0AdzK8oPH2ZS8ooy');

-- ==============================================================
-- INSERT DE NIVELES ESCOLARES --
-- ==============================================================

INSERT INTO nivel_educativo (descripcion) VALUES
('Preescolar'),
('Primaria'),
('Secundaria'),
('Bachillerato');

-- ==============================================================
-- INSERT DE GRADOS ESCOLARES --
-- ==============================================================

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

-- ==============================================================
-- INSERT DE CICLOS ESCOLARES --
-- ==============================================================

-- Ciclos escolares
INSERT INTO ciclo (descripcion) VALUES
('2020-2021'),
('2021-2022'),
('2022-2023'),
('2023-2024'),
('2024-2025');

-- =====================================================================
-- RELACIÓN ENTRE CICLOS ESCOLARES, CON GRADOS Y NIVELES EDUCATIVOS --
-- =====================================================================

-- Relación entre Preescolar y sus grados
INSERT INTO nivel_grado_ciclo (nivel_educativo_id, grado_id, ciclo_id) VALUES
(1, 1, 1),  -- Preescolar, Primero, 2020-2021
(1, 1, 2),  -- Preescolar, Primero, 2021-2022
(1, 1, 3),  -- Preescolar, Primero, 2022-2023
(1, 1, 4),  -- Preescolar, Primero, 2023-2024
(1, 1, 5),  -- Preescolar, Primero, 2024-2025
(1, 2, 1),  -- Preescolar, Segundo, 2020-2021
(1, 2, 2),  -- Preescolar, Segundo, 2021-2022
(1, 2, 3),  -- Preescolar, Segundo, 2022-2023
(1, 2, 4),  -- Preescolar, Segundo, 2023-2024
(1, 2, 5),  -- Preescolar, Segundo, 2024-2025
(1, 3, 1),  -- Preescolar, Tercero, 2020-2021
(1, 3, 2),  -- Preescolar, Tercero, 2021-2022
(1, 3, 3),  -- Preescolar, Tercero, 2022-2023
(1, 3, 4),  -- Preescolar, Tercero, 2023-2024
(1, 3, 5);  -- Preescolar, Tercero, 2024-2025

-- Relación entre Primaria y sus grados
INSERT INTO nivel_grado_ciclo (nivel_educativo_id, grado_id, ciclo_id) VALUES
(2, 4, 1),  -- Primaria, Primero, 2020-2021
(2, 4, 2),  -- Primaria, Primero, 2021-2022
(2, 4, 3),  -- Primaria, Primero, 2022-2023
(2, 4, 4),  -- Primaria, Primero, 2023-2024
(2, 4, 5),  -- Primaria, Primero, 2024-2025
(2, 5, 1),  -- Primaria, Segundo, 2020-2021
(2, 5, 2),  -- Primaria, Segundo, 2021-2022
(2, 5, 3),  -- Primaria, Segundo, 2022-2023
(2, 5, 4),  -- Primaria, Segundo, 2023-2024
(2, 5, 5),  -- Primaria, Segundo, 2024-2025
(2, 6, 1),  -- Primaria, Tercero, 2020-2021
(2, 6, 2),  -- Primaria, Tercero, 2021-2022
(2, 6, 3),  -- Primaria, Tercero, 2022-2023
(2, 6, 4),  -- Primaria, Tercero, 2023-2024
(2, 6, 5),  -- Primaria, Tercero, 2024-2025
(2, 7, 1),  -- Primaria, Cuarto, 2020-2021
(2, 7, 2),  -- Primaria, Cuarto, 2021-2022
(2, 7, 3),  -- Primaria, Cuarto, 2022-2023
(2, 7, 4),  -- Primaria, Cuarto, 2023-2024
(2, 7, 5),  -- Primaria, Cuarto, 2024-2025
(2, 8, 1),  -- Primaria, Quinto, 2020-2021
(2, 8, 2),  -- Primaria, Quinto, 2021-2022
(2, 8, 3),  -- Primaria, Quinto, 2022-2023
(2, 8, 4),  -- Primaria, Quinto, 2023-2024
(2, 8, 5),  -- Primaria, Quinto, 2024-2025
(2, 9, 1),  -- Primaria, Sexto, 2020-2021
(2, 9, 2),  -- Primaria, Sexto, 2021-2022
(2, 9, 3),  -- Primaria, Sexto, 2022-2023
(2, 9, 4),  -- Primaria, Sexto, 2023-2024
(2, 9, 5);  -- Primaria, Sexto, 2024-2025

-- Relación entre Secundaria y sus grados
INSERT INTO nivel_grado_ciclo (nivel_educativo_id, grado_id, ciclo_id) VALUES
(3, 10, 1),  -- Secundaria, Primero, 2020-2021
(3, 10, 2),  -- Secundaria, Primero, 2021-2022
(3, 10, 3),  -- Secundaria, Primero, 2022-2023
(3, 10, 4),  -- Secundaria, Primero, 2023-2024
(3, 10, 5),  -- Secundaria, Primero, 2024-2025
(3, 11, 1),  -- Secundaria, Segundo, 2020-2021
(3, 11, 2),  -- Secundaria, Segundo, 2021-2022
(3, 11, 3),  -- Secundaria, Segundo, 2022-2023
(3, 11, 4),  -- Secundaria, Segundo, 2023-2024
(3, 11, 5),  -- Secundaria, Segundo, 2024-2025
(3, 12, 1),  -- Secundaria, Tercero, 2020-2021
(3, 12, 2),  -- Secundaria, Tercero, 2021-2022
(3, 12, 3),  -- Secundaria, Tercero, 2022-2023
(3, 12, 4),  -- Secundaria, Tercero, 2023-2024
(3, 12, 5);  -- Secundaria, Tercero, 2024-2025

-- Relación entre Bachillerato y sus grados
INSERT INTO nivel_grado_ciclo (nivel_educativo_id, grado_id, ciclo_id) VALUES
(4, 13, 1),  -- Bachillerato, Semestre 1, 2020-2021
(4, 13, 2),  -- Bachillerato, Semestre 1, 2021-2022
(4, 13, 3),  -- Bachillerato, Semestre 1, 2022-2023
(4, 13, 4),  -- Bachillerato, Semestre 1, 2023-2024
(4, 13, 5),  -- Bachillerato, Semestre 1, 2024-2025
(4, 14, 1),  -- Bachillerato, Semestre 2, 2020-2021
(4, 14, 2),  -- Bachillerato, Semestre 2, 2021-2022
(4, 14, 3),  -- Bachillerato, Semestre 2, 2022-2023
(4, 14, 4),  -- Bachillerato, Semestre 2, 2023-2024
(4, 14, 5),  -- Bachillerato, Semestre 2, 2024-2025
(4, 15, 1),  -- Bachillerato, Semestre 3, 2020-2021
(4, 15, 2),  -- Bachillerato, Semestre 3, 2021-2022
(4, 15, 3),  -- Bachillerato, Semestre 3, 2022-2023
(4, 15, 4),  -- Bachillerato, Semestre 3, 2023-2024
(4, 15, 5),  -- Bachillerato, Semestre 3, 2024-2025
(4, 16, 1),  -- Bachillerato, Semestre 4, 2020-2021
(4, 16, 2),  -- Bachillerato, Semestre 4, 2021-2022
(4, 16, 3),  -- Bachillerato, Semestre 4, 2022-2023
(4, 16, 4),  -- Bachillerato, Semestre 4, 2023-2024
(4, 16, 5),  -- Bachillerato, Semestre 4, 2024-2025
(4, 17, 1),  -- Bachillerato, Semestre 5, 2020-2021
(4, 17, 2),  -- Bachillerato, Semestre 5, 2021-2022
(4, 17, 3),  -- Bachillerato, Semestre 5, 2022-2023
(4, 17, 4),  -- Bachillerato, Semestre 5, 2023-2024
(4, 17, 5),  -- Bachillerato, Semestre 5, 2024-2025
(4, 18, 1),  -- Bachillerato, Semestre 6, 2020-2021
(4, 18, 2),  -- Bachillerato, Semestre 6, 2021-2022
(4, 18, 3),  -- Bachillerato, Semestre 6, 2022-2023
(4, 18, 4),  -- Bachillerato, Semestre 6, 2023-2024
(4, 18, 5);  -- Bachillerato, Semestre 6, 2024-2025

-- ==============================================================
-- INSERT DE MUNICIPIOS --
-- ==============================================================

-- Inserciones de estados
INSERT INTO municipio (descripcion) VALUES
('Cuautitlán'),
('Xaltipa'),
('San Blas'),
('Melchor'),
('Toluca'),
('Acapulco'),
('Mazatlán'),
('Oaxaca de Juárez'),
('Guadalajara'),
('Monterrey'),
('Puebla'),
('Mérida'),
('Cancún'),
('Veracruz'),
('León'),
('Chihuahua'),
('Tijuana'),
('Hermosillo'),
('Morelia'),
('Culiacán'),
('Cuernavaca'),
('Villahermosa'),
('Durango'),
('Torreón'),
('Saltillo');

-- ==============================================================
-- RELACIÓN DE MUNICIPIO CON SU RESPECTIVA COLONIA --
-- ==============================================================

-- Inserciones de colonias para Cuautitlán (municipio_id = 1)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Villas de Cuautitlán', 1),
('San Mateo Ixtacalco', 1),
('Santa María Huecatitla', 1);

-- Inserciones de colonias para Xaltipa (municipio_id = 2)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Centro', 2),
('El Cerrito', 2),
('La Loma', 2);

-- Inserciones de colonias para San Blas (municipio_id = 3)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Centro Histórico', 3),
('Playa Norte', 3),
('Residencial San Blas', 3);

-- Inserciones de colonias para Melchor (municipio_id = 4)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Barrio de San Pedro', 4),
('Melchor Centro', 4),
('Los Pinos', 4);

-- Inserciones de colonias para Toluca (municipio_id = 5)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Centro de Toluca', 5),
('Santa Ana Tlapaltitlán', 5),
('San Mateo Otzacatipan', 5);

-- Inserciones de colonias para Acapulco (municipio_id = 6)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Costera Miguel Alemán', 6),
('La Garita', 6),
('Barra Vieja', 6);

-- Inserciones de colonias para Mazatlán (municipio_id = 7)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Centro Histórico', 7),
('Playa Sur', 7),
('Sábalo Country Club', 7);

-- Inserciones de colonias para Oaxaca de Juárez (municipio_id = 8)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Jalatlaco', 8),
('Centro Histórico', 8),
('Xochimilco', 8);

-- Inserciones de colonias para Guadalajara (municipio_id = 9)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Chapalita', 9),
('Colonia Americana', 9),
('Providencia', 9);

-- Inserciones de colonias para Monterrey (municipio_id = 10)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('San Pedro Garza García', 10),
('Cumbres', 10),
('Contry', 10);

-- Inserciones de colonias para Puebla (municipio_id = 11)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Centro Histórico', 11),
('Angelópolis', 11),
('La Paz', 11);

-- Inserciones de colonias para Mérida (municipio_id = 12)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Altabrisa', 12),
('Francisco de Montejo', 12),
('Centro de Mérida', 12);

-- Inserciones de colonias para Cancún (municipio_id = 13)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Zona Hotelera', 13),
('Supermanzana 20', 13),
('Puerto Juárez', 13);

-- Inserciones de colonias para Veracruz (municipio_id = 14)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Centro Histórico', 14),
('Los Pinos', 14),
('Costa Verde', 14);

-- Inserciones de colonias para León (municipio_id = 15)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('El Coecillo', 15),
('San Isidro', 15),
('Obregón', 15);

-- Inserciones de colonias para Chihuahua (municipio_id = 16)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Centro Histórico', 16),
('Santa Rita', 16),
('Los Portales', 16);

-- Inserciones de colonias para Tijuana (municipio_id = 17)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Playas de Tijuana', 17),
('Zona Río', 17),
('Otay', 17);

-- Inserciones de colonias para Hermosillo (municipio_id = 18)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Villa Satélite', 18),
('Colonia Pitic', 18),
('Centro de Hermosillo', 18);

-- Inserciones de colonias para Morelia (municipio_id = 19)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Villas del Pedregal', 19),
('Centro Histórico', 19),
('Bosques Camelinas', 19);

-- Inserciones de colonias para Culiacán (municipio_id = 20)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Tres Ríos', 20),
('Centro de Culiacán', 20),
('Jardines del Sol', 20);

-- Inserciones de colonias para Cuernavaca (municipio_id = 21)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Lomas de Cortés', 21),
('Vista Hermosa', 21),
('Acapantzingo', 21);

-- Inserciones de colonias para Villahermosa (municipio_id = 22)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Tabasco 2000', 22),
('Centro de Villahermosa', 22),
('Tierra Colorada', 22);

-- Inserciones de colonias para Durango (municipio_id = 23)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Centro de Durango', 23),
('Guadalupe Victoria', 23),
('Las Arboledas', 23);

-- Inserciones de colonias para Torreón (municipio_id = 24)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Centro Histórico', 24),
('Residencial Campestre', 24),
('San Isidro', 24);

-- Inserciones de colonias para Saltillo (municipio_id = 25)
INSERT INTO colonia (descripcion, municipio_id) VALUES
('Zona Centro', 25),
('Villas de Guadalupe', 25),
('San Ramón', 25);

-- ==============================================================
-- INSERT DE GÉNEROS --
-- ==============================================================

-- Inserciones de géneros
INSERT INTO genero (descripcion) VALUES
('Masculino'),
('Femenino'),
('No binario');

-- ==============================================================
-- INSERT DE MEDIOS ENTERADOS --
-- ==============================================================

-- Inserciones de medios enterados
INSERT INTO medio_enterado (descripcion) VALUES
('Internet'),
('Amigos'),
('Familia'),
('Publicidad'),
('Redes Sociales'),
('Televisión'),
('Radio'),
('Correo Electrónico'),
('Periódico'),
('Eventos'),
('Volantes'),
('Recomendaciones Personales'),
('Llamadas Telefónicas'),
('Anuncios en Sitios Web');

-- Inserciones de promociones
INSERT INTO promocion (descripcion) VALUES
('Beca completa'),
('2x1 en inscripción'),
('Matrícula gratuita'),
('Primera mensualidad sin costo'),
('Regalo de materiales'),
('Promoción especial para estudiantes destacados'),
('Promoción por recomendación'),
('Inscripción a mitad de precio'),
('Curso introductorio gratis'),
('Certificación gratuita'),
('Descuento para grupos'),
('Descuento por membresía'),
('Promoción de fin de año');

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
