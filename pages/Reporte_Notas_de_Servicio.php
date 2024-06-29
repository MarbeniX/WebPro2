<?php
session_start();

function cargarDatosXML($xmlFile) {
    return simplexml_load_file($xmlFile);
}

$clienteId = $_GET['cliente_id'] ?? null;
$empleadoLogueadoId = $_SESSION['id'] ?? null;

$clientes = cargarDatosXML('../DatosXML/cliente.xml');
$empleados = cargarDatosXML('../DatosXML/empleado.xml');

$clienteSeleccionado = null;
$empleadoSeleccionado = null;

if ($clienteId) {
    foreach ($clientes->Cliente as $cliente) {
        if ((string)$cliente->id === $clienteId) {
            $clienteSeleccionado = $cliente;
            break;
        }
    }
}

if ($empleadoLogueadoId) {
    foreach ($empleados->Empleado as $empleado) {
        if ((string)$empleado->id === $empleadoLogueadoId) {
            $empleadoSeleccionado = $empleado;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte Notas de Servicio</title>
    <link rel="stylesheet" href="../styles/Reporte_Notas_de_Servicio.css" type="text/css">
    <script src="../javascript/Reporte_Notas_de_Servicio.js"></script>
</head>
<body>
    <div class="container">
        <div class="header">
            <img src="../images/aquafixlogo.png" alt="AquaFix" width="50">
            <span>Reporte Notas de Servicio</span>
        </div>

        <form onsubmit="submitForm(event)">
            <div class="section">
                <h3>Datos de Cliente</h3>
                <p><strong>Cliente:</strong> <input type="text" name="cliente" value="<?php echo htmlspecialchars($clienteSeleccionado->nombre ?? ''); ?>" required></p>
                <p><strong>Dirección:</strong> <input type="text" name="direccion" value="<?php echo htmlspecialchars($clienteSeleccionado->direccion ?? ''); ?>" required></p>
                <p><strong>Teléfono:</strong> <input type="tel" name="telefono" value="<?php echo htmlspecialchars($clienteSeleccionado->telefono ?? ''); ?>" required></p>
                <p><strong>Email:</strong> <input type="email" name="email" value="<?php echo htmlspecialchars($clienteSeleccionado->email ?? ''); ?>" required></p>
            </div>

            <div class="section">
                <h3>Datos de Orden de Servicio</h3>
                <p><strong>Empleado:</strong> <input type="text" name="empleado" value="<?php echo htmlspecialchars($empleadoSeleccionado->nombre ?? ''); ?>" required></p>
            </div>

            <div class="section">
                <h3>Descripción de la Falla</h3>
                <textarea name="descripcion_falla" rows="4" cols="50"></textarea>
            </div>

            <table>
                <tr>
                    <th>Cantidad</th>
                    <th>Descripción</th>
                    <th>Precio Unitario</th>
                    <th>Total</th>
                </tr>
                <tr>
                    <td><input type="number" name="cantidad" required></td>
                    <td><input type="text" name="descripcion" required></td>
                    <td><input type="number" step="0.01" name="precio_unitario" required></td>
                    <td><input type="number" step="0.01" name="total" required></td>
                </tr>
                
                <tr>
                    <td colspan="3" class="total">TOTAL</td>
                    <td><input type="number" step="0.01" name="total_general" required></td>
                </tr>
            </table>

            <button type="submit" class="confirm-btn">Imprimir Reporte</button>
            <button type="button" class="confirm-btn" onclick="location.href='detalles_servicio.php'">Seguir Proceso</button>
        </form>

        <div class="footer">
            <img src="worker.png" alt="Worker" width="150">
        </div>
    </div>
</body>
</html>
