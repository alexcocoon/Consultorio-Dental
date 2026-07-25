<?php
include "proteger_doctor.php";

include "conexion.php";

$titulo_pagina = "Modificar cita";

if (isset($_POST['guardar'])) {

    $id_cita       = mysqli_real_escape_string($conexion, $_POST['id_cita']);
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

    // Actualizar la cita
    $consulta = "UPDATE citas SET
                    id_paciente = $id_paciente,
                    fecha = '$fecha',
                    hora = '$hora',
                    motivo = '$motivo',
                    observaciones = '$observaciones',
                    confirmada = $confirmada
                 WHERE id_cita = $id_cita";

    mysqli_query($conexion, $consulta);

    header("Location: citas.php?mensaje=La cita se modifico correctamente.");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: citas.php");
    exit();
}

$id = mysqli_real_escape_string($conexion, $_GET['id']);

$resultado = mysqli_query($conexion, "SELECT * FROM citas WHERE id_cita = $id");
$cita = mysqli_fetch_assoc($resultado);

if (!$cita) {
    header("Location: citas.php?mensaje=La cita no existe.");
    exit();
}

$resultado_pacientes = mysqli_query($conexion, "SELECT * FROM pacientes ORDER BY nombre ASC");

include "encabezado_doctor.php";
?>

<div class="contenido">

    <h2>Modificar cita</h2>

    <form method="POST" action="editar_cita.php">

        <input type="hidden" name="id_cita" value="<?php echo $cita['id_cita']; ?>">

        <label for="id_paciente">Paciente:</label>
        <select name="id_paciente" id="id_paciente" required>
            <?php
            while ($paciente = mysqli_fetch_assoc($resultado_pacientes)) {
            ?>
                <option value="<?php echo $paciente['id_paciente']; ?>"
                    <?php
                    if ($paciente['id_paciente'] == $cita['id_paciente']) {
                        echo "selected";
                    }
                    ?>
                >
                    <?php echo $paciente['nombre'] . " " . $paciente['apellido']; ?>
                </option>
            <?php
            }
            ?>
        </select>

        <label for="fecha">Fecha:</label>
        <input type="date" name="fecha" id="fecha" value="<?php echo $cita['fecha']; ?>" required>

        <label for="hora">Hora:</label>
        <input type="time" name="hora" id="hora" value="<?php echo $cita['hora']; ?>" required>

        <label for="motivo">Motivo:</label>
        <input type="text" name="motivo" id="motivo" value="<?php echo $cita['motivo']; ?>" required>

        <label for="observaciones">Observaciones:</label>
        <textarea name="observaciones" id="observaciones"><?php echo $cita['observaciones']; ?></textarea>

        <label>
            <input type="checkbox" name="confirmada" value="1"
                <?php
                if ($cita['confirmada'] == 1) {
                    echo "checked";
                }
                ?>
            >
        </label>

        <br>
        <input class="boton" type="submit" name="guardar" value="Guardar cambios">
        <a class="boton" href="citas.php">Regresar</a>

    </form>

</div>

<?php
include "pie.php";
?>
