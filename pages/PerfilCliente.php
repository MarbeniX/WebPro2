<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Cliente</title>
    <link rel="stylesheet" href="../styles/PerfilCliente.css">

<?php
    session_start();

    if (!isset($_SESSION['email'])) {
        header('Location: ../index.php');
        exit();
    }

    $emailCliente = $_SESSION['email'];

    // Ruta del archivo XML
    $archivoXML = '../DatosXML/cliente.xml';

    // Cargar el archivo XML
    $xml = simplexml_load_file($archivoXML);

    // Encontrar el cliente en el archivo XML
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
?>

</head>
<body>
    <header>
        <div id="searchBar">
            <img id="aquafixlogo" src="../images/aquafixlogo.png" alt="AquaFixLogo">
            <div id="titulo">
                <h1>Perfil</h1>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="profile">
            <div class="profile-image">
                <img src="../images/prueba_tecnico.jpg" alt="Foto de Perfil">
                <p>ID: <?= htmlspecialchars($cliente->id) ?></p>
            </div>
            <div class="profile-details">
                <h2>Cliente</h2>
                <p><strong>Nombre:</strong> <?= htmlspecialchars($cliente->nombre) ?></p>
                <p><strong>Apellido Paterno:</strong> <?= htmlspecialchars($cliente->apPaterno) ?></p>
                <p><strong>Apellido Materno:</strong> <?= htmlspecialchars($cliente->apMaterno) ?></p>
                <p><strong>Dirección:</strong> <?= htmlspecialchars($cliente->direccion) ?></p>
                <p><strong>CP:</strong> <?= htmlspecialchars($cliente->CP) ?></p>
                <p><strong>Delegación:</strong> <?= htmlspecialchars($cliente->Delegacion) ?></p>
                <p><strong>Teléfono:</strong> <?= htmlspecialchars($cliente->telefono) ?></p>
                <p><strong>Email:</strong> <?= htmlspecialchars($cliente->email) ?></p>
            </div>
        </div>
        <div class="buttons">
            <button onclick="window.location.href='../index.php'">Cerrar sesión</button>
            <button onclick="window.location.href='../pages/solicitudes_servicios.php'">Contratar servicio</button>
        </div>
    </div>
    <div>
        <img id="fotter" src="../images/fotter.png" alt="fotter">
    </div>
</body>
</html>
