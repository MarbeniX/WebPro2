<?php
// Función para cargar o crear el archivo XML de relaciones
function cargarRelaciones() {
    if (file_exists('../DatosXML/relaciones.xml')) {
        return simplexml_load_file('../DatosXML/relaciones.xml');
    } else {
        return new SimpleXMLElement('<Relaciones/>');
    }
}

// Si se presiona el botón, generar relaciones
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['generarRelaciones'])) {
    $solicitudXML = simplexml_load_file('../DatosXML/solicitudServicio.xml');
    $empleadoXML = simplexml_load_file('../DatosXML/empleado.xml');
    $relaciones = cargarRelaciones();

    $mensaje = 'Relaciones generadas: ';
    $idUnico = count($relaciones->Relacion) + 1;

    foreach ($solicitudXML->SolicitudesServicio as $solicitud) {
        $zonaSolicitud = (string)$solicitud->zona;
        $clienteId = (string)$solicitud->cliente_id;
        $existeRelacion = false;

        foreach ($relaciones->Relacion as $relacionExistente) {
            if ((string)$relacionExistente->cliente_id === $clienteId) {
                $existeRelacion = true;
                break;
            }
        }

        if (!$existeRelacion) {
            $empleadosZona = [];
            foreach ($empleadoXML->Empleado as $empleado) {
                if ((string)$empleado->zona_id === $zonaSolicitud) {
                    $empleadosZona[] = $empleado;
                }
            }

            if (count($empleadosZona) > 0) {
                $empleadoSeleccionado = $empleadosZona[array_rand($empleadosZona)];
                $empleadoId = (string)$empleadoSeleccionado->id;

                $relacion = $relaciones->addChild('Relacion');
                $relacion->addChild('id', 'R' . $idUnico++);
                $relacion->addChild('cliente_id', $clienteId);
                $relacion->addChild('empleado_id', $empleadoId);

                $mensaje .= "Cliente $clienteId con Empleado $empleadoId; ";
            }
        }
    }

    $relaciones->asXML('../DatosXML/relaciones.xml');
    echo "<script>alert('$mensaje');</script>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaFix - Trabajadores</title>
    <link rel="stylesheet" href="../styles/trabajadores.css">
    <link rel="stylesheet" href="../styles/solicitudesGerente.css">
</head>
<body>
    <div id="selectionBar">
        <!-- Logo -->
        <div class="logo-container">
            <img src="../images/aquafixlogo.png" alt="Logo AquaFix">
        </div>

        <!-- Menú de selección vertical -->
        <div class="menu-option">
            <div class="menu-content">
                <img src="../images/person.png" alt="Icono Control">
                <span><a href="../pages/trabajadores.php">Control</a></span>
            </div>
        </div>
        <div class="menu-option">
            <div class="menu-content">
                <img src="../images/storage.png" alt="Icono Almacén">
                <span><a href="../pages/almacen.html">Almacén</a></span>
            </div>
        </div>
        <div class="menu-option">
            <div class="menu-content">
                <img src="../images/fin.png" alt="Icono Finanzas">
                <span><a href="../pages/finanza.html">Finanzas</a></span>
            </div>
        </div>
        <div class="menu-option">
            <div class="menu-content">
                <img src="../images/soli.png" alt="Icono Solicitudes">
                <span><a href="../pages/solicitudesGerente.php/">Solicitudes</a></span>
            </div>
        </div>
    </div>

    <!-- Encabezado con la palabra "Administrador" y barra de búsqueda -->
    <div id="header">
        <div class="admin-info">
            <span>Administrador</span>
        </div>
        <div id="searchBar">
            <!-- Barra de búsqueda -->
            <div class="trabajador-icon">
                <div class="icon-placeholder"></div>
                <span>Trabajador</span>
            </div>
            <input type="text" id="searchInput" placeholder="Buscar trabajador...">
        </div>
    </div>

    <div id="main-container">
        <?php
        // Cargar archivos XML
        $solicitudXML = simplexml_load_file('../DatosXML/solicitudServicio.xml');
        $clienteXML = simplexml_load_file('../DatosXML/cliente.xml');
        $empleadoXML = simplexml_load_file('../DatosXML/empleado.xml');

        // Crear un array para mapear cliente_id a nombres de clientes
        $clientes = [];
        foreach ($clienteXML->Cliente as $cliente) {
            $clientes[(string)$cliente->id] = (string)$cliente->nombre;
        }

        // Array para controlar IDs de servicio ya mostrados
        $mostrarServicios = [];
        ?>

        <!-- Tabla de solicitudes de servicio -->
        <table border="1">
            <tr>
                <th>ID de Servicio</th>
                <th>ID de Cliente</th>
                <th>Nombre del Cliente</th>
                <th>Zona</th>
            </tr>
            <?php foreach ($solicitudXML->SolicitudesServicio as $solicitud): ?>
                <?php
                $solicitudId = (string)$solicitud->id;
                if ((int)$solicitud->id > 0 && !in_array($solicitudId, $mostrarServicios)): // Evitar ID 0 y duplicados
                    $mostrarServicios[] = $solicitudId; // Agregar ID al array de control
                ?>
                    <tr>
                        <td><?= htmlspecialchars($solicitud->id) ?></td>
                        <td><?= htmlspecialchars($solicitud->cliente_id) ?></td>
                        <td><?= isset($clientes[(string)$solicitud->cliente_id]) ? htmlspecialchars($clientes[(string)$solicitud->cliente_id]) : 'Desconocido' ?></td>
                        <td><?= htmlspecialchars($solicitud->zona) ?></td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </table>

        <!-- Tabla de empleados -->
        <table border="1">
            <tr>
                <th>ID de Empleado</th>
                <th>Nombre del Empleado</th>
                <th>Zona</th>
            </tr>
            <?php foreach ($empleadoXML->Empleado as $empleado): ?>
                <tr>
                    <td><?= htmlspecialchars($empleado->id) ?></td>
                    <td><?= htmlspecialchars($empleado->nombre) ?></td>
                    <td><?= htmlspecialchars($empleado->zona_id) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <!-- Formulario para generar relaciones -->
        <form method="POST">
            <button type="submit" name="generarRelaciones">Generar Relaciones</button>
        </form>
    </div>
</body>
</html>
