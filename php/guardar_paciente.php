<?php
include "proteger_doctor.php";

include "conexion.php";

$nombre           = mysqli_real_escape_string($conexion, $_POST['nombre']);
$apellido         = mysqli_real_escape_string($conexion, $_POST['apellido']);
$telefono         = mysqli_real_escape_string($conexion, $_POST['telefono']);
$correo           = mysqli_real_escape_string($conexion, $_POST['correo']);
$fecha_nacimiento = mysqli_real_escape_string($conexion, $_POST['fecha_nacimiento']);
$Precauciones        = mysqli_real_escape_string($conexion, $_POST['Precauciones']);

$consulta = "INSERT INTO pacientes (nombre, apellido, telefono, correo, fecha_nacimiento, Precauciones)
             VALUES ('$nombre', '$apellido', '$telefono', '$correo', '$fecha_nacimiento', '$Precauciones')";

mysqli_query($conexion, $consulta);

$id_paciente_nuevo = mysqli_insert_id($conexion);

if (isset($_POST['crear_cuenta'])) {

    $usuario_nuevo    = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $contrasena_nueva = mysqli_real_escape_string($conexion, $_POST['contrasena']);

    $revisar = mysqli_query($conexion, "SELECT * FROM usuarios WHERE usuario = '$usuario_nuevo'");

    if (mysqli_num_rows($revisar) == 0 && $usuario_nuevo != "") {
        $consulta_usuario = "INSERT INTO usuarios (usuario, contrasena, tipo_usuario, id_paciente)
                             VALUES ('$usuario_nuevo', '$contrasena_nueva', 'paciente', $id_paciente_nuevo)";
        mysqli_query($conexion, $consulta_usuario);
    } else {
        header("Location: pacientes.php?mensaje=El paciente se guardo, pero el usuario ya existia y no se creo la cuenta.");
        exit();
    }
}

header("Location: pacientes.php?mensaje=El paciente se registro correctamente.");
exit();
?>
