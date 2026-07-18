<?php

session_start();
include "conexion.php";

$usuario    = $_POST['usuario'];
$contraseña = $_POST['contraseña'];

$usuario    = mysqli_real_escape_string($conexion, $usuario);
$contraseña = mysqli_real_escape_string($conexion, $contraseña);

$consulta = "SELECT * FROM usuarios
             WHERE usuario = '$usuario' AND contraseña = '$contraseña'";

$resultado = mysqli_query($conexion, $consulta);

$cuantos = mysqli_num_rows($resultado);

if ($cuantos == 1) {

    $fila = mysqli_fetch_assoc($resultado);

    $_SESSION['id_usuario']   = $fila['id_usuario'];
    $_SESSION['usuario']      = $fila['usuario'];
    $_SESSION['tipo_usuario'] = $fila['tipo_usuario'];
    $_SESSION['id_paciente']  = $fila['id_paciente'];

    if ($fila['tipo_usuario'] == "administrador") {
        header("Location: inicio_doctor.php");
    } else {
        header("Location: inicio_paciente.php");
    }
    exit();

} else {

    ?>
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Error de inicio de sesion</title>
        <link rel="stylesheet" href="../css/index.css">
    </head>
    <body>
        <div class="caja-login">
            <div class="lado-formulario">
                <p class="diente-grande">&#129463;</p>
                <h2>Error</h2>
                <div class="error">El usuario o la contraseña no son correctos.</div>
                <a class="boton" href="../index.html">Regresar al inicio</a>
            </div>
            <div class="lado-imagen">
                <p class="diente-grande">&#129463;</p>
                <h2>Consultorio Dental<br>Sonrisa Sana</h2>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit();
}
?>
