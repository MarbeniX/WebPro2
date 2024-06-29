<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AguaFix</title>
    <link rel="stylesheet" href="../styles/soli_serv.css">
    <script>
        function updateTotal() {
            const servicios = {
                "Reparación de fuga de gas": 1000,
                "Limpieza de tinacos": 1200,
                "Cambio de filtro de tinaco": 800
            };

            let total = 0;
            document.querySelectorAll('input[name="servicios[]"]:checked').forEach(checkbox => {
                total += servicios[checkbox.value];
            });

            document.getElementById('totalAmount').innerText = `$${total} mx`;
            document.getElementById('confirmarSolicitud').disabled = total === 0;
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateTotal();
        });
    </script>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    // Verifica si el usuario está autenticado
    if (!isset($_SESSION['email'])) {
        header('Location: ../index.php');
        exit();
    }

    $emailCliente = $_SESSION['email'];

    // Ruta del archivo XML de clientes
    $archivoClienteXML = '../DatosXML/cliente.xml';

    // Cargar el archivo XML de clientes
    $xmlCliente = simplexml_load_file($archivoClienteXML);

    // Encontrar el cliente en el archivo XML
    $cliente = null;
    foreach ($xmlCliente->Cliente as $c) {
        if ((string)$c->email === $emailCliente) {
            $cliente = $c;
            break;
        }
    }

    if ($cliente === null) {
        die('Cliente no encontrado.');
    }

    // Ruta del archivo XML de solicitudes de servicio
    $archivoSolicitudXML = '../DatosXML/solicitudServicio.xml';
    if (file_exists($archivoSolicitudXML)) {
        $xmlSolicitud = simplexml_load_file($archivoSolicitudXML);
    } else {
        $xmlSolicitud = new SimpleXMLElement('<SolicitudServicio></SolicitudServicio>');
    }

    $servicios = [
        "Reparación de fuga de gas" => 1000,
        "Limpieza de tinacos" => 1200,
        "Cambio de filtro de tinaco" => 800
    ];

    $seleccionados = $_POST['servicios'] ?? [];
    $total = 0;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (empty($seleccionados)) {
            $error = "Selecciona algún servicio.";
        } else {
            foreach ($seleccionados as $servicio) {
                if (isset($servicios[$servicio])) {
                    $total += $servicios[$servicio];
                }
            }

            // Determinar el nuevo ID
            $ultimoId = 0;
            foreach ($xmlSolicitud->SolicitudesServicio as $solicitudExistente) {
                $ultimoId = max($ultimoId, (int)$solicitudExistente->id);
            }
            $nuevoId = $ultimoId + 1;

            // Crear una nueva solicitud de servicio
            $solicitud = $xmlSolicitud->addChild('SolicitudesServicio');
            $solicitud->addChild('id', $nuevoId);
            $solicitud->addChild('cliente_id', (string)$cliente->id);
            $solicitud->addChild('zona', htmlspecialchars((string)$cliente->zona_id, ENT_XML1 | ENT_QUOTES, 'UTF-8'));
            $solicitud->addChild('codigo_postal', htmlspecialchars((string)$cliente->CP, ENT_XML1 | ENT_QUOTES, 'UTF-8'));
            $solicitud->addChild('delegacion', htmlspecialchars((string)$cliente->Delegacion, ENT_XML1 | ENT_QUOTES, 'UTF-8'));
            $solicitud->addChild('direccion', htmlspecialchars((string)$cliente->direccion, ENT_XML1 | ENT_QUOTES, 'UTF-8'));
            $solicitud->addChild('hora', ''); // Se llenará en la siguiente vista
            $solicitud->addChild('fecha', date('Y-m-d', strtotime('+1 day')));

            foreach ($seleccionados as $servicio) {
                $servicioNode = $solicitud->addChild('Servicio');
                $servicioNode->addChild('id', ''); // Generar un ID único para el servicio si es necesario
                $servicioNode->addChild('nombre', htmlspecialchars($servicio, ENT_XML1 | ENT_QUOTES, 'UTF-8'));
                $servicioNode->addChild('descripcion', htmlspecialchars($servicio, ENT_XML1 | ENT_QUOTES, 'UTF-8'));
                $servicioNode->addChild('precio', $servicios[$servicio]);
            }

            $solicitud->addChild('total', $total);

            // Guardar el archivo XML
            $xmlSolicitud->asXML($archivoSolicitudXML);

            $_SESSION['servicios'] = $seleccionados;
            $_SESSION['total'] = $total;
            header('Location: Mapa.php');
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
            <section id="secc_servicios">
                <h2>Servicios</h2>
                <div class="elemServicios">
                    <article class="servicio">
                        <h3>Reparación de fuga de gas</h3>
                        <br>
                        <p>$1000 mx</p>
                        <br><br><br><br>
                        <input type="checkbox" name="servicios[]" value="Reparación de fuga de gas" onclick="updateTotal()"> Seleccionar
                    </article>
                    <article class="servicio">
                        <h3>Limpieza de tinacos</h3>
                        <br><br>
                        <p>$1200 mx</p>
                        <br><br><br><br>
                        <input type="checkbox" name="servicios[]" value="Limpieza de tinacos" onclick="updateTotal()"> Seleccionar
                    </article>
                    <article class="servicio">
                        <h3>Cambio de filtro de tinaco</h3>
                        <br>
                        <p>$800 mx</p>
                        <br><br><br><br>
                        <input type="checkbox" name="servicios[]" value="Cambio de filtro de tinaco" onclick="updateTotal()"> Seleccionar
                    </article>
                </div>
            </section>
            <aside id="detalle_solicitud">
                <h2>Detalle de solicitud</h2>
                <div class="detalle_item">
                    <?php if (!empty($seleccionados)): ?>
                        <?php foreach ($seleccionados as $servicio): ?>
                            <p><?= htmlspecialchars($servicio) ?> - $<?= $servicios[$servicio] ?> mx</p>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div id="total">
                    <p><b>TOTAL</b> <span id="totalAmount">$0 mx</span></p>
                </div>
                <button type="submit" id="confirmarSolicitud" disabled>Continuar Solicitud</button>
                <?php if (isset($error)): ?>
                    <p style="color: red;"><?= $error ?></p>
                <?php endif; ?>
            </aside>
        </form>
    </main>
</body>
</html>
