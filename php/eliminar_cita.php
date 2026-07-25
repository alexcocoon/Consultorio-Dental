<?php
include "proteger_doctor.php";

include "conexion.php";

$titulo_pagina = "Eliminar cita";

if (isset($_POST['eliminar'])) {

    $id_cita = mysqli_real_escape_string($conexion, $_POST['id_cita']);

    mysqli_query($conexion, "DELETE FROM citas WHERE id_cita = $id_cita");

    header("Location: citas.php?mensaje=La cita se elimino correctamente.");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: citas.php");
    exit();
}

$id = mysqli_real_escape_string($conexion, $_GET['id']);

$consulta = "SELECT citas.*, pacientes.nombre, pacientes.apellido
             FROM citas
             INNER JOIN pacientes ON citas.id_paciente = pacientes.id_paciente
             WHERE citas.id_cita = $id";

$resultado = mysqli_query($conexion, $consulta);
$cita = mysqli_fetch_assoc($resultado);

if (!$cita) {
    header("Location: citas.php?mensaje=La cita no existe.");
    exit();
}

include "encabezado_doctor.php";
?>

<div class="contenido">

    <h2>Eliminar cita</h2>

    <div class="error">
        <p>Vas a eliminar la siguiente cita. Esta accion no se puede deshacer.</p>
    </div>

    <div class="tarjeta">
        <p><strong>Paciente:</strong> <?php echo $cita['nombre'] . " " . $cita['apellido']; ?></p>
        <p><strong>Fecha:</strong> <?php echo $cita['fecha']; ?></p>
        <p><strong>Hora:</strong> <?php echo $cita['hora']; ?></p>
        <p><strong>Motivo:</strong> <?php echo $cita['motivo']; ?></p>
    </div>

    <form method="POST" action="eliminar_cita.php">
        <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">
        <input class="boton" type="submit" name="eliminar" value="Si, eliminar cita">
        <a class="boton" href="citas.php">No, regresar</a>
    </form>

</div>

<?php
include "pie.php";
?>
