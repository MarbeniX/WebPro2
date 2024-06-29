<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>AguaFix</title>
    <link rel="stylesheet" href="../styles/sim_pago.css">
    <script>
    function formatCardNumber(input) {
        input.value = input.value.replace(/\D/g, '').replace(/(\d{4})(?=\d)/g, '$1 ').trim();
    }

    function formatExpiry(input) {
        input.value = input.value.replace(/^(\d\d)(\d)$/g, '$1/$2').replace(/[^0-9\/]/g, '').replace(/(\d{2})\/(\d{2})/, '$1/$2');
    }

    document.addEventListener('DOMContentLoaded', () => {
        const cardNumberInput = document.getElementById('card_number');
        cardNumberInput.addEventListener('input', () => formatCardNumber(cardNumberInput));

        const expiryInput = document.getElementById('expiry');
        expiryInput.addEventListener('input', () => formatExpiry(expiryInput));
    });
    </script>
    <?php
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

// Ruta del archivo XML de pagos
$archivoPagoXML = '../DatosXML/pago.xml';
if (file_exists($archivoPagoXML)) {
    $xmlPago = simplexml_load_file($archivoPagoXML);
} else {
    $xmlPago = new SimpleXMLElement('<Pagos></Pagos>');
}

// Ruta del archivo XML de solicitudes de servicio
$archivoSolicitudXML = '../DatosXML/solicitudServicio.xml';
if (file_exists($archivoSolicitudXML)) {
    $xmlSolicitud = simplexml_load_file($archivoSolicitudXML);
} else {
    die('Archivo de solicitud de servicio no encontrado.');
}

// Obtener la última solicitud de servicio del cliente actual
$ultimaSolicitud = null;
foreach ($xmlSolicitud->SolicitudesServicio as $solicitud) {
    if ((string)$solicitud->cliente_id === (string)$cliente->id) {
        $ultimaSolicitud = $solicitud;
    }
}

if ($ultimaSolicitud === null) {
    die('No se encontró una solicitud de servicio para este cliente.');
}

$ordenId = (string)$ultimaSolicitud->id;
$totalPagar = (string)$ultimaSolicitud->total;

// Obtener el último pago realizado por el cliente
$ultimoPago = null;
foreach ($xmlPago->Pago as $pago) {
    if ((string)$pago->cliente_id === (string)$cliente->id) {
        $ultimoPago = $pago;
    }
}

// Obtener el último ID de pago y calcular el siguiente ID
$ultimoIdPago = 0;
foreach ($xmlPago->Pago as $pago) {
    $ultimoIdPago = max($ultimoIdPago, (int)$pago->id);
}
$nuevoIdPago = $ultimoIdPago + 1;

$errores = [];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_number = $_POST['card_number'];
    $expiry = $_POST['expiry'];
    $cvc = $_POST['cvc'];
    $country = $_POST['country'];
    $postal_code = $_POST['postal_code'];

    if (!preg_match('/^\d{4} \d{4} \d{4} \d{4}$/', $card_number)) {
        $errores[] = "Número de tarjeta inválido";
    }

    if (!preg_match('/^(0[1-9]|1[0-2])\/(2[4-9]|3[0])$/', $expiry)) {
        $errores[] = "Fecha de vencimiento inválida";
    }

    if (!preg_match('/^\d{3}$/', $cvc)) {
        $errores[] = "CVV inválido";
    }

    if ($country != "México") {
        $errores[] = "País inválido";
    }

    if (empty($errores)) {
        if ($ultimoPago && $ultimoPago->cvv != $cvc) {
            $errores[] = "CVV no coincide";
        } else {
            // Guardar los datos en el archivo XML de pago
            $pago = $xmlPago->addChild('Pago');
            $pago->addChild('id', $nuevoIdPago);
            $pago->addChild('cliente_id', (string)$cliente->id);
            $pago->addChild('solicitudServicio_id', $ordenId);
            $pago->addChild('numero_tarjeta', $card_number);
            $pago->addChild('vencimiento', $expiry);
            $pago->addChild('cvv', $cvc);
            $pago->addChild('pais', "México");
            $pago->addChild('CP', $postal_code);
            $pago->addChild('total', $totalPagar);
            $pago->addChild('fecha_pago', date('Y-m-d H:i:s'));

            $xmlPago->asXML($archivoPagoXML);

            header('Location: ../pages/PagoRealizado.php');
            exit();
        }
    }
}
?>
</head>
<body>
    <header>
        <div id="searchBar">
            <img id="aquafixlogo" src="../images/aquafixlogo.png" alt="AquaFixLogo" height="254.1" width="227.35">
            <div id="titulo">
                <h1>Pago</h1>
            </div>
        </div>
    </header>
    <main>
        <section id="pago_seccion">
            <div id="orden_info">
                <p>Orden #<span><?= $ordenId ?></span></p>
                <p>Total a pagar: $<span><?= $totalPagar ?></span> mx</p>
            </div>
            <form id="pago_form" method="POST" action="">
                <div class="form-group">
                    <label for="card_number">Número de tarjeta</label>
                    <input type="text" id="card_number" name="card_number" placeholder="1234 1234 1234 1234" maxlength="19" value="<?= isset($ultimoPago) ? htmlspecialchars($ultimoPago->numero_tarjeta) : '' ?>">
                </div>
                <div class="form-group form-group-inline">
                    <div>
                        <label for="expiry">Vencimiento</label>
                        <input type="text" id="expiry" name="expiry" placeholder="MM/YY" maxlength="5" value="<?= isset($ultimoPago) ? htmlspecialchars($ultimoPago->vencimiento) : '' ?>">
                    </div>
                    <div>
                        <label for="cvc">CVV</label>
                        <input type="text" id="cvc" name="cvc" placeholder="CVV" maxlength="3">
                    </div>
                </div>
                <div class="form-group form-group-inline">
                    <div>
                        <label for="country">País</label>
                        <input type="text" id="country" name="country" placeholder="México" value="México" readonly>
                    </div>
                    <div>
                        <label for="postal_code">Código Postal</label>
                        <input type="text" id="postal_code" name="postal_code" placeholder="12345" value="<?= htmlspecialchars($cliente->CP) ?>">
                    </div>
                </div>
                <button type="submit">Pagar</button>
                <?php if (!empty($errores)): ?>
                    <div class="error"><?= implode(", ", $errores) ?></div>
                <?php endif; ?>
            </form>
        </section>
    </main>
</body>
</html>
