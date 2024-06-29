<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
    <link rel="stylesheet" href="../styles/Registro.css" type="text/css">
</head>
<body>
    <header>
        <div id="searchBar">
            <img id="aquafixlogo" src="../images/aquafixlogo.png" alt="AquaFixLogo" height="254.1" width="227.35">
            <div id="mediaBar">
                <div id="about">
                    <div class="dropdown">
                        <button id="conocenos-boton" class="dropbtn"><a href="../pages/quienessomos.html">Conocenos</a></button>
                        <img class="imgFlecha" src="../images/flechaBotonDrop.png" alt="flechaBotonDrop">
                    </div>
                    <div class="dropdown">
                        <button id="servicios-boton" class="dropbtn"><a href="../pages/servicios.html">Servicios</a></button>
                        <img class="imgFlecha" src="../images/flechaBotonDrop.png" alt="flechaBotonDrop">
                    </div>
                    <div class="dropdown">
                        <button id="login-cliente" class="dropbtn"><a href="../index.php">Iniciar sesión</a></button>
                        <img class="imgFlecha" src="../images/flechaBotonDrop.png" alt="flechaBotonDrop">
                    </div>
                </div>
                <div id="socialLinks">
                    <div class="socialIcon" id="igLogo">
                        <img src="../images/iglogo.png" alt="instagram logo" height="17.07" width="17.07">
                    </div>
                    <div class="socialIcon" id="sportLogo">
                        <img src="../images/sportlogo.png" alt="sports logo" height="17.07" width="17.07">
                    </div>
                    <div class="socialIcon" id="twitterLogo">
                        <img src="../images/twitterlogo.png" alt="twitter logo" height="17.07" width="17.07">
                    </div>
                    <div class="socialIcon" id="youtubeLogo">
                        <img src="../images/youtubelogo.png" alt="youtube logo" height="17.07" width="17.07">
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
    <section class="register-section">
            <h1>Registrate</h1>
            <form action="../pages/proceso_Registro.php" method="POST">
                <div class="input-container">
                    <input type="text" name="nombre" placeholder="Nombre (máximo 15 caracteres)" maxlength="15" required>
                </div>
                <div class="input-container">
                    <input type="email" name="email" placeholder="Correo (debe terminar en @cliente.com)" maxlength="30" required pattern="[a-zA-Z0-9._%+-]+@cliente\.com$">
                </div>
                <div class="input-container">
                    <input type="password" name="password" placeholder="Contraseña (máximo 15 caracteres)" maxlength="15" required>
                </div>
                <div id="ingresar-button">
                    <button><a href="../pages/Registro2.php">Ingresar</a></button>
                </div>
                <div>
                <?php
                session_start();
                if (isset($_SESSION['error'])): ?>
                    <p style="color:red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
                <?php endif; ?>
                </div>
            </form>
        </section>
    </main>
    <div>
        <img id="fotter" src="../images/fotter.png" alt="fotter">
    </div>
</body>
</html>