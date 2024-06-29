CREATE TABLE Cliente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    direccion VARCHAR(255),
    telefono VARCHAR(50),
    email VARCHAR(100),
    password VARCHAR(255) -- Necesario para el inicio de sesión
);
CREATE TABLE Empleado (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    trabajo VARCHAR(100),
    zona VARCHAR(100),
    email VARCHAR(100),
    telefono VARCHAR(50),
    password VARCHAR(255), -- Necesario para el inicio de sesión
    trabajos_realizados INT
);
CREATE TABLE Servicio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255),
    descripcion TEXT,
    precio DECIMAL(10, 2)
);
CREATE TABLE ServiciosDelDia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(50),
    cliente_id INT,
    trabajo VARCHAR(255),
    direccion VARCHAR(255),
    telefono VARCHAR(50),
    completado BOOLEAN,
    FOREIGN KEY (cliente_id) REFERENCES Cliente(id)
);
CREATE TABLE ReporteNotasDeServicio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    empleado_id INT,
    servicio_id INT,
    no_orden VARCHAR(50),
    codigo VARCHAR(50),
    descripcion_falla TEXT,
    cantidad INT,
    descripcion VARCHAR(255),
    precio_unitario DECIMAL(10, 2),
    total DECIMAL(10, 2),
    FOREIGN KEY (cliente_id) REFERENCES Cliente(id),
    FOREIGN KEY (empleado_id) REFERENCES Empleado(id),
    FOREIGN KEY (servicio_id) REFERENCES Servicio(id)
);
CREATE TABLE Control (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE,
    empleado_id INT,
    horas_laboradas INT,
    FOREIGN KEY (empleado_id) REFERENCES Empleado(id)
);
CREATE TABLE ReporteControlAlmacen (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    fecha_servicio DATE,
    tipo_servicio VARCHAR(255),
    costo_asociado DECIMAL(10, 2),
    material VARCHAR(255),
    cantidad INT,
    precio_unitario DECIMAL(10, 2),
    total DECIMAL(10, 2),
    FOREIGN KEY (cliente_id) REFERENCES Cliente(id)
);
CREATE TABLE Finanzas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    total_servicios DECIMAL(10, 2)
);
CREATE TABLE Solicitudes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    fecha DATE,
    descripcion TEXT,
    estado VARCHAR(50),
    FOREIGN KEY (cliente_id) REFERENCES Cliente(id)
);
CREATE TABLE SolicitudServicio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    zona VARCHAR(50),
    delegacion VARCHAR(50),
    hora TIME,
    fecha DATE,
    estado VARCHAR(50),
    FOREIGN KEY (cliente_id) REFERENCES Cliente(id)
);
CREATE TABLE ContratacionServicio (
    id INT AUTO_INCREMENT PRIMARY KEY,
    solicitud_id INT,
    servicio_id INT,
    cantidad INT,
    precio_unitario DECIMAL(10, 2),
    total DECIMAL(10, 2),
    FOREIGN KEY (solicitud_id) REFERENCES SolicitudServicio(id),
    FOREIGN KEY (servicio_id) REFERENCES Servicio(id)
);
CREATE TABLE Pago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    solicitud_id INT,
    numero_tarjeta VARCHAR(20),
    vencimiento DATE,
    cvv VARCHAR(5),
    pais VARCHAR(50),
    codigo_postal VARCHAR(10),
    total DECIMAL(10, 2),
    fecha_pago DATE,
    FOREIGN KEY (solicitud_id) REFERENCES SolicitudServicio(id)
);
INSERT INTO SolicitudServicio (cliente_id, zona, delegacion, hora, fecha, estado)
VALUES (1, 'Noreste de CDMX', 'Álvaro Obregón', '11:00:00', '2024-06-19', 'pendiente');
INSERT INTO ContratacionServicio (solicitud_id, servicio_id, cantidad, precio_unitario, total)
VALUES (1, 1, 1, 1000.00, 1000.00);
INSERT INTO Pago (solicitud_id, numero_tarjeta, vencimiento, cvv, pais, codigo_postal, total, fecha_pago)
VALUES (1, '1234 1234 1234 1234', '2025-12-31', '123', 'México', '12345', 1000.00, '2024-06-19');
