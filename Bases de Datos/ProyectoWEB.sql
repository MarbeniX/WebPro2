CREATE TABLE Cliente (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(20),
    apPaterno VARCHAR(20),
    apMaterno VARCHAR(20),
    direccion VARCHAR(50),
    CP VARCHAR(5),
    zona VARCHAR(16),
    telefono VARCHAR(10),
    email VARCHAR(50),
    Contraseña VARCHAR(20) -- Necesario para el inicio de sesión
);

CREATE TABLE Empleado (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(20),
    apPaterno VARCHAR(20),
    apMaterno VARCHAR(20),
    trabajo VARCHAR(10),
    zona VARCHAR(16),
    email VARCHAR(50),
    telefono VARCHAR(10),
    Contraseña VARCHAR(20), -- Necesario para el inicio de sesión
    trabajos_realizados INT
);

CREATE TABLE Servicio (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(50),
    descripcion TEXT,
    precio DECIMAL(10, 2)
);

CREATE TABLE ServiciosDelDia (
    id SERIAL PRIMARY KEY,
    codigo VARCHAR(3),
    cliente_id INT,
    trabajo VARCHAR(10),
    direccion VARCHAR(50),
    CP VARCHAR(5),
    telefono VARCHAR(10),
    completado BOOLEAN,
    FOREIGN KEY (cliente_id) REFERENCES Cliente(id)
);

CREATE TABLE ReporteNotasDeServicio (
    id SERIAL PRIMARY KEY,
    cliente_id INT,
    empleado_id INT,
    servicio_id INT,
    No_orden VARCHAR(10),
    codigo VARCHAR(3),
    descripcion_falla TEXT,
    cantidad INT,
    descripcion VARCHAR(255),
    precio_unitario DECIMAL(10, 2),
    total DECIMAL(10, 2),
    FOREIGN KEY (cliente_id) REFERENCES Cliente(id),
    FOREIGN KEY (empleado_id) REFERENCES Empleado(id),
    FOREIGN KEY (servicio_id) REFERENCES Servicio(id)
);

CREATE TABLE ControlE (
    id SERIAL PRIMARY KEY,
    fecha DATE,
    empleado_id INT,
    horas_laboradas INT,
    FOREIGN KEY (empleado_id) REFERENCES Empleado(id)
);

CREATE TABLE ReporteControlAlmacen (
    id SERIAL PRIMARY KEY,
    cliente_id INT,
    fecha_servicio DATE,
    tipo_servicio VARCHAR(50),
    costo_asociado DECIMAL(10, 2),
    material VARCHAR(255),
    cantidad INT,
    precio_unitario DECIMAL(10, 2),
    total DECIMAL(10, 2),
    FOREIGN KEY (cliente_id) REFERENCES Cliente(id)
);

CREATE TABLE Solicitudes (
    id SERIAL PRIMARY KEY,
    cliente_id INT,
    fecha DATE,
    descripcion TEXT,
    estado VARCHAR(20),
    FOREIGN KEY (cliente_id) REFERENCES Cliente(id)
);

CREATE TABLE SolicitudServicio (
    id SERIAL PRIMARY KEY,
    cliente_id INT,
    zona VARCHAR(16),
    delegacion VARCHAR(20),
    hora TIME,
    fecha DATE,
    estado VARCHAR(20),
    FOREIGN KEY (cliente_id) REFERENCES Cliente(id)
);

CREATE TABLE ContratacionServicio (
    id SERIAL PRIMARY KEY,
    solicitud_id INT,
    servicio_id INT,
    cantidad INT,
    precio_unitario DECIMAL(10, 2),
    total DECIMAL(10, 2),
    FOREIGN KEY (solicitud_id) REFERENCES SolicitudServicio(id),
    FOREIGN KEY (servicio_id) REFERENCES Servicio(id)
);

CREATE TABLE Pago (
    id SERIAL PRIMARY KEY,
    solicitud_id INT,
    numero_tarjeta VARCHAR(20),
    vencimiento DATE,
    cvv VARCHAR(3),
    pais VARCHAR(20),
    CP VARCHAR(5),
    total DECIMAL(10, 2),
    fecha_pago DATE,
    FOREIGN KEY (solicitud_id) REFERENCES SolicitudServicio(id)
);

CREATE TABLE Finanzas (
    id SERIAL PRIMARY KEY,
    total_servicios DECIMAL(10, 2),
    pago_id INT,
    contratacion_servicio_id INT,
    FOREIGN KEY (pago_id) REFERENCES Pago(id),
    FOREIGN KEY (contratacion_servicio_id) REFERENCES ContratacionServicio(id)
);

-- Crear la tabla Zona
CREATE TABLE Zona (
    id SERIAL PRIMARY KEY,
    zonaCDMX VARCHAR(16),
    CP VARCHAR(5),
    delegacion VARCHAR(50)
);

-- Modificar la tabla Cliente
ALTER TABLE Cliente
ADD zona_id INT,
ADD FOREIGN KEY (zona_id) REFERENCES Zona(id);

-- Eliminar el atributo zona de la tabla Cliente
ALTER TABLE Cliente
DROP COLUMN zona;

-- Modificar la tabla Empleado
ALTER TABLE Empleado
ADD zona_id INT,
ADD FOREIGN KEY (zona_id) REFERENCES Zona(id);

-- Eliminar el atributo zona de la tabla Empleado
ALTER TABLE Empleado
DROP COLUMN zona;

-- Modificar la tabla SolicitudServicio
ALTER TABLE SolicitudServicio
ADD zona_id INT,
ADD FOREIGN KEY (zona_id) REFERENCES Zona(id);

-- Eliminar el atributo zona de la tabla SolicitudServicio
ALTER TABLE SolicitudServicio
DROP COLUMN zona;

-- Ejemplo de inserción de datos en la tabla Zona
INSERT INTO Zona (zonaCDMX, CP, delegacion) VALUES ('Norte', '02000', 'Azcapotzalco');

-- Actualizar datos de las tablas Cliente, Empleado y SolicitudServicio para referenciar la tabla Zona
-- Nota: Esto es solo un ejemplo. Debes actualizar con los valores correctos según tus datos.
UPDATE Cliente SET zona_id = 1 WHERE id = 1;
UPDATE Empleado SET zona_id = 1 WHERE id = 1;
UPDATE SolicitudServicio SET zona_id = 1 WHERE id = 1;


/*

-- Insertar cliente
INSERT INTO Cliente (nombre, apPaterno, apMaterno, direccion, telefono, email, password)
VALUES ('Juan', 'Pérez', 'Dominguez', 'Calle Falsa 123', '555-1234', 'juan@example.com', 'password123');

-- Insertar solicitud de servicio
INSERT INTO SolicitudServicio (cliente_id, zona, delegacion, hora, fecha, estado)
VALUES (1, 'Noreste de CDMX', 'Álvaro Obregón', '11:00:00', '2024-06-19', 'pendiente');

-- Insertar servicio (ejemplo)
INSERT INTO Servicio (nombre, descripcion, precio)
VALUES ('Reparación de fuga de gas', 'Reparación de fuga de gas en tubería principal', 1000.00);

-- Insertar contratación de servicio
INSERT INTO ContratacionServicio (solicitud_id, servicio_id, cantidad, precio_unitario, total)
VALUES (1, 1, 1, 1000.00, 1000.00);

-- Insertar pago
INSERT INTO Pago (solicitud_id, numero_tarjeta, vencimiento, cvv, pais, codigo_postal, total, fecha_pago)
VALUES (1, '1234 1234 1234 1234', '2025-12-31', '123', 'México', '12345', 1000.00, '2024-06-19');
*/
/*
Drop Table Cliente;
Drop Table Empleado;
Drop Table Servicio;
Drop Table ServiciosDelDia;

Drop Table ReporteNotasDeServicio;
Drop Table ControlE;
Drop Table ReporteControlAlmacen;
Drop Table Finanzas;

Drop Table Solicitudes;
Drop Table SolicitudServicio;
Drop Table ContratacionServicio;
Drop Table Pago;
*/
/*
-- Después de entrar a psql, ejecuta las sentencias:
SELECT * FROM Cliente;
SELECT * FROM SolicitudServicio;
SELECT * FROM Servicio;
SELECT * FROM ContratacionServicio;
SELECT * FROM Pago;
*/
/*
DROP TABLE IF EXISTS Cliente CASCADE;
DROP TABLE IF EXISTS Empleado CASCADE;
DROP TABLE IF EXISTS Servicio CASCADE;
DROP TABLE IF EXISTS ServiciosDelDia CASCADE;
DROP TABLE IF EXISTS ReporteNotasDeServicio CASCADE;
DROP TABLE IF EXISTS ControlE CASCADE;
DROP TABLE IF EXISTS ReporteControlAlmacen CASCADE;
DROP TABLE IF EXISTS Finanzas CASCADE;
DROP TABLE IF EXISTS Solicitudes CASCADE;
DROP TABLE IF EXISTS SolicitudServicio CASCADE;
DROP TABLE IF EXISTS ContratacionServicio CASCADE;
DROP TABLE IF EXISTS Pago CASCADE;
*/
