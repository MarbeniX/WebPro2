<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaFix - Solicitar Servicio</title>
    <link rel="stylesheet" href="../styles/Mapa.css" type="text/css">

    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    session_start();

    if (!isset($_SESSION['email'])) {
        header('Location: ../index.php');
        exit();
    }

    $emailCliente = $_SESSION['email'];
    $archivoXML = '../DatosXML/cliente.xml';
    $xml = simplexml_load_file($archivoXML);

    $cliente = null;
    foreach ($xml->Cliente as $c) {
        if ((string)$c->email === $emailCliente) {
            $cliente = $c;
            break;
        }
    }

    if ($cliente === null) {
        die('Cliente no encontrado.');
    }

    $archivoSolicitudXML = '../DatosXML/solicitudServicio.xml';
    if (file_exists($archivoSolicitudXML)) {
        $xmlSolicitud = simplexml_load_file($archivoSolicitudXML);
    } else {
        die('Archivo de solicitud de servicio no encontrado.');
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $zone = $_POST['zone'];
        $delegation = $_POST['delegation'];
        $cp = $_POST['cp'];
        $direccion = $_POST['direccion'];
        $time = $_POST['time'];

        if (empty($zone) || empty($delegation) || empty($cp) || empty($direccion) || empty($time)) {
            echo "<script>alert('Debe llenar todos los campos');</script>";
        } else {
            $ultimoId = 0;
            foreach ($xmlSolicitud->SolicitudesServicio as $solicitud) {
                $ultimoId = max($ultimoId, (int)$solicitud->id);
            }
            $nuevoId = $ultimoId + 1;

            $nuevaSolicitud = $xmlSolicitud->addChild('SolicitudesServicio');
            $nuevaSolicitud->addChild('id', $nuevoId);
            $nuevaSolicitud->addChild('cliente_id', (string)$cliente->id);
            $nuevaSolicitud->addChild('zona', htmlspecialchars($zone));
            $nuevaSolicitud->addChild('codigo_postal', htmlspecialchars($cp));
            $nuevaSolicitud->addChild('delegacion', htmlspecialchars($delegation));
            $nuevaSolicitud->addChild('direccion', htmlspecialchars($direccion));
            $nuevaSolicitud->addChild('hora', htmlspecialchars($time));
            $nuevaSolicitud->addChild('fecha', date('Y-m-d', strtotime('+1 day')));

            $total = 1000; // Ajusta según la lógica para calcular el total real
            $nuevaSolicitud->addChild('total', $total);

            $xmlSolicitud->asXML($archivoSolicitudXML);
            header('Location: ./simulacion_pago.php');
            exit();
        }
    }
    ?>

</head>
<body>
    <header>
        <div id="searchBar">
            <img id="aquafixlogo" src="../images/aquafixlogo.png" alt="AquaFixLogo" height="254.1" width="227.35">
            <div id="titulo">
                <h1>Contratación de servicios</h1>
            </div>
        </div>
    </header>

    <main>
        <form method="POST" action="">
            <div class="selection">
                <div class="map-image">
                    <img src="../images/Mapa.jpg" alt="Mapa de delegaciones">
                </div>
                <div class="zone-selection">
                    <h2>Zona:</h2>
                    <input type="text" name="zone" value="<?= htmlspecialchars($cliente->zona_id) ?>" readonly>
                </div>
                <div class="cp-selection">
                    <h2>Código Postal:</h2>
                    <input type="text" name="cp" value="<?= htmlspecialchars($cliente->CP) ?>" readonly>
                </div>
                <div class="delegation-selection">
                    <h2>Delegación:</h2>
                    <input type="text" name="delegation" value="<?= htmlspecialchars($cliente->Delegacion) ?>" readonly>
                </div>
                <div class="direccion-selection">
                    <h2>Dirección:</h2>
                    <input type="text" name="direccion" value="<?= htmlspecialchars($cliente->direccion) ?>" readonly>
                </div>
                <div class="time-selection">
                    <h2>¿En qué hora quiere obtener el servicio?</h2>
                    <select name="time">
                        <option value="11:00am-12:00pm">11:00am-12:00pm</option>
                        <option value="12:00pm-1:00pm">12:00pm-1:00pm</option>
                        <option value="1:00pm-2:00pm">1:00pm-2:00pm</option>
                        <option value="2:00pm-3:00pm">2:00pm-3:00pm</option>
                        <option value="3:00pm-4:00pm">3:00pm-4:00pm</option>
                        <option value="4:00pm-5:00pm">4:00pm-5:00pm</option>
                        <option value="5:00pm-6:00pm">5:00pm-6:00pm</option>
                        <option value="6:00pm-7:00pm">6:00pm-7:00pm</option>
                    </select>
                </div>
                <button id="pagar-boton" type="submit" class="submit-btn">Pagar</button>
            </div>
        </form>
    </main>
</body>
</html>
