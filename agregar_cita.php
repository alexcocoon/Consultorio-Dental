<?php
include "proteger_doctor.php";

include "conexion.php";

$titulo_pagina = "Registrar cita";

if (isset($_POST['guardar'])) {

    $id_paciente   = mysqli_real_escape_string($conexion, $_POST['id_paciente']);
    $fecha         = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $hora          = mysqli_real_escape_string($conexion, $_POST['hora']);
    $motivo        = mysqli_real_escape_string($conexion, $_POST['motivo']);
    $observaciones = mysqli_real_escape_string($conexion, $_POST['observaciones']);

    if (isset($_POST['confirmada'])) {
        $confirmada = 1;
    } else {
        $confirmada = 0;
    }

    $consulta = "INSERT INTO citas (id_paciente, fecha, hora, motivo, observaciones, confirmada)
                 VALUES ($id_paciente, '$fecha', '$hora', '$motivo', '$observaciones', $confirmada)";

    mysqli_query($conexion, $consulta);

    header("Location: citas.php?mensaje=La cita se registro correctamente.");
    exit();
}

$resultado_pacientes = mysqli_query($conexion, "SELECT * FROM pacientes ORDER BY nombre ASC");

$resultado_servicios = mysqli_query($conexion, "SELECT * FROM servicios ORDER BY nombre_servicio ASC");

include "encabezado_doctor.php";
?>

<div class="contenido">

    <h2>Registrar cita nueva</h2>

    <form method="POST" action="agregar_cita.php">

        <label for="id_paciente">Paciente:</label>
        <select name="id_paciente" id="id_paciente" required>
            <option value="">-- Selecciona un paciente --</option>
            <?php
            while ($paciente = mysqli_fetch_assoc($resultado_pacientes)) {
            ?>
                <option value="<?php echo $paciente['id_paciente']; ?>">
                    <?php echo $paciente['nombre'] . " " . $paciente['apellido']; ?>
                </option>
            <?php
            }
            ?>
        </select>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" required>

        <label for="hora">Hora:</label>
        <input type="time" name="hora" id="hora" required>

        <label for="motivo">Motivo:</label>
        <select name="motivo" id="motivo" required>
            <option value="">-- Selecciona un motivo --</option>
            <?php
            while ($servicio = mysqli_fetch_assoc($resultado_servicios)) {
            ?>
                <option value="<?php echo $servicio['nombre_servicio']; ?>">
                    <?php echo $servicio['nombre_servicio']; ?>
                </option>
            <?php
            }
            ?>
            <option value="Consulta general">Consulta general</option>
            <option value="Urgencia">Urgencia</option>
        </select>

        <label for="observaciones">Observaciones:</label>
        <textarea name="observaciones" id="observaciones"></textarea>

        <label>
            <input type="checkbox" name="confirmada" value="1">
            La cita ya esta confirmada con el paciente
        </label>

        <br>
        <input class="boton" type="submit" name="guardar" value="Guardar cita">
        <a class="boton" href="citas.php">Regresar</a>

    </form>

</div>

<?php
include "pie.php";
?>
