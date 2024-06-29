<?php
session_start();

function cargarDatosXML($xmlFile) {
    return simplexml_load_file($xmlFile);
}

$empleadoLogueadoId = $_SESSION['id'] ?? null;

$empleados = cargarDatosXML('../DatosXML/empleado.xml');

$empleadoSeleccionado = null;

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
<html>
<head>
    <meta charset="UTF-8">
    <title>AguaFix</title>
    <link rel="stylesheet" href="../styles/deta_servicio.css">
    <link rel="stylesheet" href="../styles/principal.css">
    <script src="" defer></script>
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
                        <button id="servicios-boton" class="dropbtn"><a href="../pages/solicitudes_servicios.html">Servicios</a></button>
                        <img class="imgFlecha" src="../images/flechaBotonDrop.png" alt="flechaBotonDrop">
                    </div>
                    
                    <div class="dropdown">
                        <button id="login-cliente" class="dropbtn"><a href="../index.html">Iniciar sesión</a></button>
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
        <section id="secc_cliente">
            <article class="tecnico">
                <img id="imagen_tecnico" src="../images/prueba_tecnico.jpg" alt="Imagen de tecnico contratado">
                <h2>Técnico</h2>
            </article>
            <article class="datosCliente">
                <div id="cliente"><p><b>Empleado: </b> <span><?php echo htmlspecialchars("{$empleadoSeleccionado->nombre} {$empleadoSeleccionado->apPaterno} {$empleadoSeleccionado->apMaterno}"); ?></span></p></div>
                <div id="direccion"><p><b>Zona: </b> <span><?php echo htmlspecialchars($empleadoSeleccionado->zona_id); ?></span></p></div>
                <div id="telefono"><p><b>Teléfono: </b> <span><?php echo htmlspecialchars($empleadoSeleccionado->telefono); ?></span></p></div>
                <div id="e-mail"><p><b>E-mail: </b> <span><?php echo htmlspecialchars($empleadoSeleccionado->email); ?></span></p></div>
            </article>
        </section>

        <aside id="detalles">
            <h2>Detalles de servicio</h2>
            <div id="orden_info">
                <p>Orden #<span>0000</span></p>
            </div>
            <div class="tabla_servicios">
                <table>
                    <thead>
                        <tr>
                            <th colspan="4">Servicios</th>
                        </tr>
                        <tr>
                            <th>#</th>
                            <th>NOMBRE</th>
                            <th>DESCRIPCION</th>
                            <th>PRECIO</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Reparación de tuberías</td>
                            <td>Material utilizado: Tubo de PVC</td>
                            <td>$500.00</td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Cambio de filtro</td>
                            <td>Material usado: Filtro de aire</td>
                            <td>$300.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="subir_imagen">
                <button onclick="alert('¡Botón presionado!')">
                    <img src="../images/upload_icon.png" alt="Botón de imagen">
                </button>
                <h3>Sube evidencia del trabajo realizado</h3>
            </div>
            <button id="cerrar"><a href="../pages/rel_cliente.html">Cerrar</a></button>
        </aside>
    </main>
</body>
</html>
