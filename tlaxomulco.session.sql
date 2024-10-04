-- Inserciones de estados
INSERT INTO estado (descripcion) VALUES
('Jalisco'),
('Zacatecas'),
('Durango'),
('Guanajuato');

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

-- Inserciones de alumnos
INSERT INTO alumno (nombre, Ap, Am, matricula, direccion, estado, nivel, genero, grado_id) VALUES
('Juan', 'Pérez', 'López', 12345, 'Calle Falsa 123', 1, 2, 1, 4),  -- Primaria, Primero
('María', 'García', 'Hernández', 12346, 'Calle Verdadera 456', 2, 3, 2, 10), -- Secundaria, Primero
('Luis', 'Méndez', 'Sánchez', 12347, 'Calle Real 789', 3, 4, 1, 13), -- Bachillerato, Semestre 1
('Sofía', 'Morales', 'Torres', 12348, 'Calle Imaginaria 101', 4, 1, 2, 5); -- Primaria, Segundo

-- Inserciones de registros
INSERT INTO registro (fecha, pago_inscripcion, pago_colegiatura, medio_enterado, promocion, ciclo_escolar, alumno, usuario) VALUES
('2022-08-15', 500, 3000, 1, 1, 1, 1, 1),  -- Juan
('2022-08-16', 500, 3000, 2, 2, 1, 2, 1),  -- María
('2022-08-17', 500, 4000, 3, 3, 2, 3, 1),  -- Luis
('2022-08-18', 500, 3000, 1, 1, 1, 4, 1);  -- Sofía
