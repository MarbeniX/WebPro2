<?php
session_start();

function cargarDatosXML($xmlFile) {
    return simplexml_load_file($xmlFile);
}

$empleadoLogueadoId = $_SESSION['id'] ?? 'N/A';
$empleadoLogueadoNombre = $_SESSION['empleado']['nombre'] ?? 'Trabajador';

if ($empleadoLogueadoId !== 'N/A') {
    $relaciones = cargarDatosXML('../DatosXML/relaciones.xml');
    $clientesRelacionados = [];

    foreach ($relaciones->Relacion as $relacion) {
        if ((string)$relacion->empleado_id === $empleadoLogueadoId) {
            $clientesRelacionados[] = (string)$relacion->cliente_id;
        }
    }

    $solicitudes = cargarDatosXML('../DatosXML/solicitudServicio.xml');
    $clientes = cargarDatosXML('../DatosXML/cliente.xml');

    $solicitudesRelacionadas = [];
    foreach ($solicitudes->SolicitudesServicio as $solicitud) {
        if (in_array((string)$solicitud->cliente_id, $clientesRelacionados)) {
            $solicitudesRelacionadas[] = $solicitud;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Success Page</title>
  <link rel="stylesheet" href="../styles/serviciosdia.css">
</head>
<body>
  <header>
    <div id="searchBar">
      <div id="titulo">Bienvenido (<?php echo htmlspecialchars($empleadoLogueadoNombre); ?>)</div>
      <img id="aquafixlogo" src="../images/aquafixlogo.png" alt="AquaFix Logo">
      <div>ID: <?php echo htmlspecialchars($empleadoLogueadoId); ?></div>
    </div>
  </header>
  <main id="success">
    <div class="container">
      <h1>Servicios del Día</h1>
      <table class="styled-table">
        <thead>
          <tr>
            <th>Número</th>
            <th>Código</th>
            <th>Cliente</th>
            <th>Dirección</th>
            <th>Teléfono</th>
            <th>Completado</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $numero = 1;
          foreach ($solicitudesRelacionadas as $solicitud) {
              $clienteId = (string)$solicitud->cliente_id;
              foreach ($clientes->Cliente as $cliente) {
                  if ((string)$cliente->id === $clienteId) {
                      echo "<tr>";
                      echo "<td>{$numero}</td>";
                      echo "<td>00{$numero}</td>";
                      echo "<td>" . htmlspecialchars($cliente->nombre) . "</td>";
                      echo "<td>" . htmlspecialchars("{$solicitud->direccion}, {$solicitud->delegacion}, {$solicitud->codigo_postal}") . "</td>";
                      echo "<td>" . htmlspecialchars($cliente->telefono) . "</td>";
                      echo "<td><button onclick=\"location.href='./Reporte_Notas_de_Servicio.php?cliente_id={$clienteId}'\">Completado</button></td>";
                      echo "</tr>";
                      $numero++;
                  }
              }
          }
          ?>
        </tbody>
      </table>
    </div>
  </main>
</body>
</html>
