<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidoPaterno = $_POST['apellidoPaterno'];
    $apellidoMaterno = $_POST['apellidoMaterno'];
    $direccion = $_POST['direccion'];
    $cp = $_POST['cp'];
    $delegacion = $_POST['delegacion'];
    $zona = $_POST['zona'];
    $telefono = $_POST['telefono'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

   // Validar que la contraseña coincida con la original
   if ($contrasena !== $_SESSION['password']) {
        // Establecer mensaje de error
        $_SESSION['error'] = "Las contraseñas no coinciden";
        header('Location: Registro2.php');
        exit();
    }

    // Cargar el archivo XML
    $xmlFile = '../DatosXML/cliente.xml';
    if (file_exists($xmlFile)) {
        $xml = simplexml_load_file($xmlFile);
    } else {
        $xml = new SimpleXMLElement('<Clientes/>');
    }

    // Crear un nuevo cliente
    $cliente = $xml->addChild('Cliente');
    $cliente->addChild('id', 'C' . (count($xml->Cliente) + 1));
    $cliente->addChild('nombre', $nombre);
    $cliente->addChild('apPaterno', $apellidoPaterno);
    $cliente->addChild('apMaterno', $apellidoMaterno);
    $cliente->addChild('direccion', $direccion);
    $cliente->addChild('CP', $cp);
    $cliente->addChild('Delegacion', $delegacion);
    $cliente->addChild('zona_id', $zona);
    $cliente->addChild('telefono', $telefono);
    $cliente->addChild('email', $correo);
    $cliente->addChild('Contraseña', $contrasena);

    // Guardar el archivo XML
    $xml->asXML($xmlFile);

    // Establecer el mensaje de éxito en la sesión
    $_SESSION['registro_exitoso'] = "Usuario registrado";

    // Redirigir a index.php
    header('Location: ../index.php');
    exit();
}
?>