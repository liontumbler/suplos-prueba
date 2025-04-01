-- Crear la base de datos
CREATE DATABASE prueba_suplos;
USE prueba_suplos;

-- Crear la tabla ofertas
CREATE TABLE ofertas (
    id_oferta INT AUTO_INCREMENT PRIMARY KEY,
    creador_oferta VARCHAR(255) NOT NULL,
    objeto VARCHAR(255) NOT NULL,
    actividad VARCHAR(255),
    descripcion TEXT,
    moneda VARCHAR(10) NOT NULL,
    presupuesto DECIMAL(15,2) NOT NULL,
    fecha_inicio DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    fecha_cierre DATE NOT NULL,
    estado ENUM('ACTIVO', 'PUBLICADO', 'EVALUACIÓN') NOT NULL
);

-- Consultas CRUD

-- 1. Insertar una oferta
INSERT INTO ofertas (creador_oferta, objeto, actividad, descripcion, moneda, presupuesto, fecha_inicio, hora_inicio, fecha_cierre, estado)
VALUES ('Juan Pérez', 'Compra de equipos', 'Adquisición', 'Compra de 10 laptops', 'COP', 50000000, '2025-04-01', '08:00:00', '2025-04-15', 'ACTIVO');

-- 2. Obtener todas las ofertas
SELECT * FROM ofertas;

-- 3. Obtener una oferta específica por ID
SELECT * FROM ofertas WHERE id_oferta = 1;

-- 4. Actualizar una oferta
UPDATE ofertas SET estado = 'Cerrado' WHERE id_oferta = 1;

-- 5. Eliminar una oferta
DELETE FROM ofertas WHERE id_oferta = 1;