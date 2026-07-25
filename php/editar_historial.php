<?php
include "proteger_doctor.php";

include "conexion.php";

$titulo_pagina = "Modificar historial";

if (isset($_POST['guardar'])) {

    $id_historial          = mysqli_real_escape_string($conexion, $_POST['id_historial']);
    $id_paciente           = mysqli_real_escape_string($conexion, $_POST['id_paciente']);
    $fecha                 = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $diagnostico           = mysqli_real_escape_string($conexion, $_POST['diagnostico']);
    $tratamiento           = mysqli_real_escape_string($conexion, $_POST['tratamiento']);
    $observaciones         = mysqli_real_escape_string($conexion, $_POST['observaciones']);
    $proxima_recomendacion = mysqli_real_escape_string($conexion, $_POST['proxima_recomendacion']);

    $consulta = "UPDATE historial SET
                    fecha = '$fecha',
                    diagnostico = '$diagnostico',
                    tratamiento = '$tratamiento',
                    observaciones = '$observaciones',
                    proxima_recomendacion = '$proxima_recomendacion'
                 WHERE id_historial = $id_historial";

    mysqli_query($conexion, $consulta);

    header("Location: historial.php?id=$id_paciente&mensaje=El registro del historial se modifico.");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: historial.php");
    exit();
}

$id = mysqli_real_escape_string($conexion, $_GET['id']);

$consulta_registro = "SELECT historial.*, pacientes.nombre, pacientes.apellido
                      FROM historial
                      INNER JOIN pacientes ON historial.id_paciente = pacientes.id_paciente
                      WHERE historial.id_historial = $id";

$resultado = mysqli_query($conexion, $consulta_registro);
$registro = mysqli_fetch_assoc($resultado);

if (!$registro) {
    header("Location: historial.php?mensaje=El registro no existe.");
    exit();
}

include "encabezado_doctor.php";
?>

<div class="contenido">

    <h2>Modificar registro del historial</h2>

    <div class="tarjeta">
        <p><strong>Paciente:</strong> <?php echo $registro['nombre'] . " " . $registro['apellido']; ?></p>
    </div>

    <form method="POST" action="editar_historial.php">

        <input type="hidden" name="id_historial" value="<?php echo $registro['id_historial']; ?>">
        <input type="hidden" name="id_paciente" value="<?php echo $registro['id_paciente']; ?>">

        <label for="fecha">Fecha de la consulta:</label>
        <input type="date" name="fecha" id="fecha" value="<?php echo $registro['fecha']; ?>" required>

        <label for="diagnostico">Diagnostico:</label>
        <textarea name="diagnostico" id="diagnostico"><?php echo $registro['diagnostico']; ?></textarea>

        <label for="tratamiento">Tratamiento realizado:</label>
        <textarea name="tratamiento" id="tratamiento"><?php echo $registro['tratamiento']; ?></textarea>

        <label for="observaciones">Observaciones:</label>
        <textarea name="observaciones" id="observaciones"><?php echo $registro['observaciones']; ?></textarea>

        <label for="proxima_recomendacion">Proxima recomendacion:</label>
        <textarea name="proxima_recomendacion" id="proxima_recomendacion"><?php echo $registro['proxima_recomendacion']; ?></textarea>

        <br>
        <input class="boton" type="submit" name="guardar" value="Guardar cambios">
        <a class="boton" href="historial.php?id=<?php echo $registro['id_paciente']; ?>">Regresar</a>

    </form>

</div>

<?php
include "pie.php";
?>
