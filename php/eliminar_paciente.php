<?php
include "proteger_doctor.php";

include "conexion.php";

$titulo_pagina = "Eliminar paciente";

if (isset($_POST['eliminar'])) {

    $id_paciente = mysqli_real_escape_string($conexion, $_POST['id_paciente']);

    mysqli_query($conexion, "DELETE FROM citas WHERE id_paciente = $id_paciente");

    mysqli_query($conexion, "DELETE FROM historial WHERE id_paciente = $id_paciente");

    mysqli_query($conexion, "DELETE FROM usuarios WHERE id_paciente = $id_paciente");

    mysqli_query($conexion, "DELETE FROM pacientes WHERE id_paciente = $id_paciente");

    header("Location: pacientes.php?mensaje=El paciente se elimino correctamente.");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: pacientes.php");
    exit();
}

$id = mysqli_real_escape_string($conexion, $_GET['id']);

$resultado = mysqli_query($conexion, "SELECT * FROM pacientes WHERE id_paciente = $id");
$paciente = mysqli_fetch_assoc($resultado);

if (!$paciente) {
    header("Location: pacientes.php?mensaje=El paciente no existe.");
    exit();
}

include "encabezado_doctor.php";
?>

<div class="contenido">

    <h2>Eliminar paciente</h2>

    <div class="error">
        <p>Vas a eliminar al siguiente paciente. Esta accion no se puede deshacer.</p>
        <p>Tambien se borraran sus citas, su historial medico y su cuenta de acceso.</p>
    </div>

    <div class="tarjeta">
        <p><strong>Nombre:</strong> <?php echo $paciente['nombre'] . " " . $paciente['apellido']; ?></p>
        <p><strong>Telefono:</strong> <?php echo $paciente['telefono']; ?></p>
        <p><strong>Correo:</strong> <?php echo $paciente['correo']; ?></p>
    </div>

    <form method="POST" action="eliminar_paciente.php">
        <input type="hidden" name="id_paciente" value="<?php echo $paciente['id_paciente']; ?>">
        <input class="boton" type="submit" name="eliminar" value="Si, eliminar paciente">
        <a class="boton" href="pacientes.php">No, regresar</a>
    </form>

</div>

<?php
include "pie.php";
?>
