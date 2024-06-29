<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el correo termina en @cliente.com y no contiene más de un "@"
    if (preg_match("/^[a-zA-Z0-9._%+-]+@cliente\.com$/", $email) && substr_count($email, '@') == 1) {
        $_SESSION['nombre'] = $nombre;
        $_SESSION['email'] = $email;
        $_SESSION['password'] = $password;

        header('Location: Registro2.php');
        exit();
    } else {
        // Establecer mensaje de error
        $_SESSION['error'] = "Correo no válido, debe terminar en @cliente.com";
        header('Location: ../pages/Registro.php');
        exit();
    }
}
?>
