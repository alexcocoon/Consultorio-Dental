<?php
include "proteger_doctor.php";
include "conexion.php";
$titulo_pagina = "Agregar historial";
if (isset($_POST['guardar'])) {

    $id_paciente           = mysqli_real_escape_string($conexion, $_POST['id_paciente']);
    $fecha                 = mysqli_real_escape_string($conexion, $_POST['fecha']);
    $diagnostico           = mysqli_real_escape_string($conexion, $_POST['diagnostico']);
    $tratamiento           = mysqli_real_escape_string($conexion, $_POST['tratamiento']);
    $observaciones         = mysqli_real_escape_string($conexion, $_POST['observaciones']);
    $proxima_recomendacion = mysqli_real_escape_string($conexion, $_POST['proxima_recomendacion']);

    $consulta = "INSERT INTO historial (id_paciente, fecha, diagnostico, tratamiento, observaciones, proxima_recomendacion)
                 VALUES ($id_paciente, '$fecha', '$diagnostico', '$tratamiento', '$observaciones', '$proxima_recomendacion')";

    mysqli_query($conexion, $consulta);

    header("Location: historial.php?id=$id_paciente&mensaje=El registro se agrego al historial.");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: historial.php");
    exit();
}

$id = mysqli_real_escape_string($conexion, $_GET['id']);

$resultado = mysqli_query($conexion, "SELECT * FROM pacientes WHERE id_paciente = $id");
$paciente = mysqli_fetch_assoc($resultado);

if (!$paciente) {
    header("Location: historial.php?mensaje=El paciente no existe.");
    exit();
}

include "encabezado_doctor.php";
?>

<div class="contenido">

    <h2>Agregar registro al historial</h2>

    <div class="tarjeta">
        <p><strong>Paciente:</strong> <?php echo $paciente['nombre'] . " " . $paciente['apellido']; ?></p>
    </div>

    <form method="POST" action="agregar_historial.php">

        <!-- Campo escondido con el numero del paciente -->
        <input type="hidden" name="id_paciente" value="<?php echo $paciente['id_paciente']; ?>">

        <label for="fecha">Fecha de la consulta:</label>
        <input type="date" name="fecha" id="fecha" required>

        <label for="diagnostico">Diagnostico:</label>
        <textarea name="diagnostico" id="diagnostico"></textarea>

        <label for="tratamiento">Tratamiento realizado:</label>
        <textarea name="tratamiento" id="tratamiento"></textarea>

        <label for="observaciones">Observaciones:</label>
        <textarea name="observaciones" id="observaciones"></textarea>

        <label for="proxima_recomendacion">Proxima recomendacion:</label>
        <textarea name="proxima_recomendacion" id="proxima_recomendacion"></textarea>

        <br>
        <input class="boton" type="submit" name="guardar" value="Guardar registro">
        <a class="boton" href="historial.php?id=<?php echo $paciente['id_paciente']; ?>">Regresar</a>

    </form>

</div>

<?php
include "pie.php";
?>
