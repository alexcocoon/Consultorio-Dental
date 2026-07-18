<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['tipo_usuario'])) {
    header("Location: ../index.html");
    exit();
}

if ($_SESSION['tipo_usuario'] != "paciente") {
    header("Location: inicio_doctor.php");
    exit();
}
?>
