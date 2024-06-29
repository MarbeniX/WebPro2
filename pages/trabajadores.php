<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AquaFix - Trabajadores</title>
    <link rel="stylesheet" href="../styles/trabajadores.css">
    <link rel="stylesheet" href="../styles/trabajadoresTabla.css">
</head>
<body>
    <div id="selectionBar">
        <!-- Logo -->
        <div class="logo-container">
            <img src="../images/aquafixlogo.png" alt="Logo AquaFix">
        </div>

        <!-- Menú de selección vertical -->
        <div class="menu-option">
            <div class="menu-content">
                <img src="../images/person.png" alt="Icono Control">
                <span><a href="../pages/trabajadores.php">Control</a></span>
            </div>
        </div>
        <div class="menu-option">
            <div class="menu-content">
                <img src="../images/storage.png" alt="Icono Almacén">
                <span><a href="../pages/almacen.html">Almacén</a></span>
            </div>
        </div>
        <div class="menu-option">
            <div class="menu-content">
                <img src="../images/fin.png" alt="Icono Finanzas">
                <span><a href="../pages/finanza.html">Finanzas</a></span>
            </div>
        </div>
        <div class="menu-option">
            <div class="menu-content">
                <img src="../images/soli.png" alt="Icono Solicitudes">
                <span><a href="../pages/solicitudesGerente.php">Solicitudes</a></span>
            </div>
        </div>
    </div>

    <div id="main-container">
        <h1>Empleados</h1>
        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Zona</th>
                <th>E-mail</th>
                <th>Teléfono</th>
                <th>Trabajos Realizados</th>
            </tr>
            <?php
            $xml = simplexml_load_file('../DatosXML/empleado.xml') or die("Error: No se puede cargar el archivo XML");

            foreach ($xml->Empleado as $empleado) {
                echo "<tr>";
                echo "<td>" . $empleado->id . "</td>";
                echo "<td>" . $empleado->nombre . "</td>";
                echo "<td>" . $empleado->apPaterno . "</td>";
                echo "<td>" . $empleado->apMaterno . "</td>";
                echo "<td>" . $empleado->zona_id . "</td>";
                echo "<td>" . $empleado->email . "</td>";
                echo "<td>" . $empleado->telefono . "</td>";
                echo "<td>" . $empleado->trabajos_realizados . "</td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>
