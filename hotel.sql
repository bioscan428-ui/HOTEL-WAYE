-- 1. Tabla de Clientes (Corregida)
CREATE TABLE CLIENTE (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    telefono VARCHAR(20), 
    correo VARCHAR(100)
);

-- 2. Tabla de Tipos de Habitación (Para no repetir precios y descripciones)
CREATE TABLE TIPO_HABITACION (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50), -- Ejemplo: 'Suite', 'Doble', 'Simple'
    precio_noche DECIMAL(10, 2),
    capacidad INT
);

-- 3. Tabla de Habitaciones
CREATE TABLE HABITACION (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    numero VARCHAR(10), -- Ejemplo: '101', '204A'
    piso INT,
    id_tipo INT,
    estado VARCHAR(20) DEFAULT 'Disponible', -- 'Disponible', 'Ocupada', 'Mantenimiento'
    FOREIGN KEY (id_tipo) REFERENCES TIPO_HABITACION(id)
);

-- 4. La tabla clave: RESERVAS
CREATE TABLE RESERVA (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT,
    id_habitacion INT,
    id_usuario INT,
    fecha_entrada DATE NOT NULL,
    fecha_salida DATE NOT NULL,
    total_pago DECIMAL(10, 2),
    FOREIGN KEY (id_cliente) REFERENCES CLIENTE(id),
    FOREIGN KEY (id_habitacion) REFERENCES HABITACION(id),
    FOREIGN KEY (id_usuario) REFERENCES USUARIOS(id)
);


CREATE TABLE AREAS(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE
)


CREATE TABLE USUARIOS(
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    usuario VARCHAR(100) UNIQUE, -- Para que no se repitan nombres de acceso
    contraseña VARCHAR(255),    -- Aumentado a 255 por seguridad (hashes)               -- Esta es la llave foránea
    tipo ENUM('normal', 'admin'),
    activo BOOLEAN DEFAULT TRUE,
    id_area INT,
    FOREIGN KEY (id_area) REFERENCES AREAS(id)
);