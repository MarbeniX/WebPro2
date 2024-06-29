<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>AguaFix</title>
    <link rel="stylesheet" href="./styles/principal.css">

    <?php
session_start();

function leerClientesDesdeXML($archivo) {
    $clientes = [];
    if (file_exists($archivo)) {
        $xml = simplexml_load_file($archivo);
        foreach ($xml->Cliente as $cliente) {
            $clientes[] = [
                'email' => (string)$cliente->email,
                'password' => (string)$cliente->Contraseña,
                'tipo' => 'cliente'
            ];
        }
    }
    return $clientes;
}

function leerGerentesDesdeXML($archivo) {
    $gerentes = [];
    if (file_exists($archivo)) {
        $xml = simplexml_load_file($archivo);
        foreach ($xml->Gerente as $gerente) {
            $gerentes[] = [
                'email' => (string)$gerente->email,
                'password' => (string)$gerente->Contraseña,
                'tipo' => 'gerente'
            ];
        }
    }
    return $gerentes;
}

function leerEmpleadosDesdeXML($archivo) {
    $empleados = [];
    if (file_exists($archivo)) {
        $xml = simplexml_load_file($archivo);
        foreach ($xml->Empleado as $empleado) {
            $empleados[] = [
                'id' => (string)$empleado->id,
                'email' => (string)$empleado->email,
                'password' => (string)$empleado->Contraseña,
                'tipo' => 'empleado'
            ];
        }
    }
    return $empleados;
}

function verificarCredenciales($email, $password, $usuarios) {
    foreach ($usuarios as $usuario) {
        if ($usuario['email'] === $email && $usuario['password'] === $password) {
            return $usuario;
        }
    }
    return false;
}

$clientes = leerClientesDesdeXML('./DatosXML/cliente.xml');
$gerentes = leerGerentesDesdeXML('./DatosXML/gerente.xml');
$empleados = leerEmpleadosDesdeXML('./DatosXML/empleado.xml');

$usuarios = array_merge($clientes, $gerentes, $empleados);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['correoElectronico'];
    $password = $_POST['contraseña'];
    $usuario = verificarCredenciales($email, $password, $usuarios);

    if ($usuario) {
        $_SESSION['user'] = $usuario['tipo'];
        $_SESSION['email'] = $usuario['email'];
        if ($usuario['tipo'] === 'cliente') {
            header('Location: ./pages/PerfilCliente.php');
        } elseif ($usuario['tipo'] === 'empleado') {
            $_SESSION['id'] = $usuario['id']; // Agregar el ID a la sesión
            header('Location: ./pages/serviciosdia.php');
        } elseif ($usuario['tipo'] === 'gerente') {
            header('Location: ./pages/trabajadores.php');
        }
        exit();
    } else {
        $error = 'Correo o contraseña incorrectos';
    }
}
?>


</head>
<body>
    <div id="searchBar">
        <img id="aquafixlogo" src="./images/aquafixlogo.png" alt="AquaFixLogo" height="254.1" width="227.35">
        <div id="mediaBar">
            <div id="about">
                <div class="dropdown">
                    <button id="conocenos-boton" class="dropbtn"><a href="./pages/quienessomos.html">Conócenos</a></button>
                    <img class="imgFlecha" src="./images/flechaBotonDrop.png" alt="flechaBotonDrop">
                </div>
                <div class="dropdown">
                    <button id="servicios-boton" class="dropbtn"><a href="./pages/servicios.html">Servicios</a></button>
                    <img class="imgFlecha" src="./images/flechaBotonDrop.png" alt="flechaBotonDrop">
                </div>
                <div class="dropdown">
                    <button id="login-cliente" class="dropbtn"><a href="./index.php">Iniciar sesión</a></button>
                    <img class="imgFlecha" src="./images/flechaBotonDrop.png" alt="flechaBotonDrop">
                </div>
            </div>
            <div id="socialLinks">
                <div class="socialIcon" id="igLogo">
                    <img src="./images/iglogo.png" alt="instagram logo" height="17.07" width="17.07">
                </div>
                <div class="socialIcon" id="sportLogo">
                    <img src="./images/sportlogo.png" alt="sports logo" height="17.07" width="17.07">
                </div>
                <div class="socialIcon" id="twitterLogo">
                    <img src="./images/twitterlogo.png" alt="twitter logo" height="17.07" width="17.07">
                </div>
                <div class="socialIcon" id="youtubeLogo">
                    <img src="./images/youtubelogo.png" alt="youtube logo" height="17.07" width="17.07">
                </div>
            </div>
        </div>
    </div>
    <div>
    <?php
        if (isset($_SESSION['registro_exitoso'])) {
            echo '<p style="color: green; text-align: center;">' . $_SESSION['registro_exitoso'] . '</p>';
            unset($_SESSION['registro_exitoso']);
        }
        ?>
    </div>
    <div id="principal">
        <div id="containerMensajeIntro">
            <h1>Tu hogar en buenas manos, <br>con nuestros plomeros <br>expertos</h1>
        </div>
        <div id="sesion-cliente">
            <div id="register">
                <img src="./images/Plomero.jpg" alt="Rectangle">
                <p>¿No tienes una cuenta? Entonces <a href="./pages/Registro.php">Regístrate aquí</a></p>
            </div>
            <div id="login">
                <form method="POST" action="">
                    <div id="text-login">
                        <h3>Iniciar sesión</h3>
                    </div>
                    <div id="correo-Electronico-Info" class="login-container-info">
                        <img src="./images/male-user-shadow 1.png" alt="imagen de usuario">
                        <label for="correoElectronico"></label>
                        <input type="email" id="correoElectronico" name="correoElectronico" placeholder="correo electrónico" required>
                    </div>
                    <div id="contraseña-info" class="login-container-info">
                        <img src="./images/contrasena 1.png" alt="imagen de contraseña">
                        <label for="contraseña"></label>
                        <input type="password" id="contraseña" name="contraseña" placeholder="contraseña" required>
                    </div>
                    <?php if (isset($error)): ?>
                        <p id="error-message" class="error-message"><?= $error ?></p>
                    <?php endif; ?>
                    <div id="ingresar-button">
                        <button id="ingresar">Ingresar</button>
                    </div>
                </form>
            </div>
        </div>
    </div> 
</body>
</html>
