<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>AguaFix - Registro de Servicio</title>
    <link rel="stylesheet" href="../styles/Registro2.css">

<?php
    session_start();
    $nombre = isset($_SESSION['nombre']) ? $_SESSION['nombre'] : '';
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $password = isset($_SESSION['password']) ? $_SESSION['password'] : '';
?>

</head>
<body>
    <header>
        <div id="searchBar">
            <img id="aquafixlogo" src="../images/aquafixlogo.png" alt="AquaFixLogo">
            <div id="titulo">
                <h1>Registro</h1>
            </div>
        </div>
    </header>

    <div id="formularioServicio">
        <h1>Datos del Cliente</h1>
        <form id="servicioForm" method="POST" action="../pages/proceso_Registro2.php">
            <label for="nombre">Nombre:</label>
            <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>

            <label for="apellidoPaterno">Apellido Paterno:</label>
            <input type="text" id="apellidoPaterno" name="apellidoPaterno" required>

            <label for="apellidoMaterno">Apellido Materno:</label>
            <input type="text" id="apellidoMaterno" name="apellidoMaterno" required>

            <label for="direccion">Dirección:</label>
            <input type="text" id="direccion" name="direccion" required>

            <label for="cp">Código Postal:</label>
            <input type="text" id="cp" name="cp" maxlength="5" required oninput="autofillDelegacionZona()">

            <label for="delegacion">Delegación:</label>
            <input type="text" id="delegacion" name="delegacion" readonly>

            <label for="zona">Zona:</label>
            <input type="text" id="zona" name="zona" readonly>

            <label for="telefono">Teléfono:</label>
            <input type="tel" id="telefono" name="telefono" required>

            <label for="correo">Correo:</label>
            <input type="email" id="correo" name="correo" value="<?php echo htmlspecialchars($email); ?>" required>

            <label for="contrasena">Confirmar Contraseña:</label>
            <input type="password" id="contrasena" name="contrasena" required>

            <button type="submit">Completar Registro</button>
            
            <?php
            if (isset($_SESSION['error'])): ?>
                <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>

        </form>
    </div>
    
    <script src="../javascript/Registro2.js"></script>
</body>
</html>
