<?php
include "proteger_doctor.php";

include "conexion.php";

$titulo_pagina = "Modificar paciente";

if (isset($_POST['guardar'])) {

    $id_paciente      = mysqli_real_escape_string($conexion, $_POST['id_paciente']);
    $nombre           = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellido         = mysqli_real_escape_string($conexion, $_POST['apellido']);
    $telefono         = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $correo           = mysqli_real_escape_string($conexion, $_POST['correo']);
    $fecha_nacimiento = mysqli_real_escape_string($conexion, $_POST['fecha_nacimiento']);
    $Precauciones        = mysqli_real_escape_string($conexion, $_POST['Precauciones']);

    $consulta = "UPDATE pacientes SET
                    nombre = '$nombre',
                    apellido = '$apellido',
                    telefono = '$telefono',
                    correo = '$correo',
                    fecha_nacimiento = '$fecha_nacimiento',
                    Precauciones = '$Precauciones'
                 WHERE id_paciente = $id_paciente";

    mysqli_query($conexion, $consulta);

    header("Location: pacientes.php?mensaje=Los datos del paciente se modificaron correctamente.");
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

    <h2>Modificar paciente</h2>

    <form method="POST" action="editar_paciente.php">

        <input type="hidden" name="id_paciente" value="<?php echo $paciente['id_paciente']; ?>">

        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre" value="<?php echo $paciente['nombre']; ?>" required>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" id="apellido" value="<?php echo $paciente['apellido']; ?>" required>

        <label for="telefono">Telefono:</label>
        <input type="text" name="telefono" id="telefono" value="<?php echo $paciente['telefono']; ?>">

        <label for="correo">Correo:</label>
        <input type="email" name="correo" id="correo" value="<?php echo $paciente['correo']; ?>">

        <label for="fecha_nacimiento">Fecha de nacimiento:</label>
        <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" value="<?php echo $paciente['fecha_nacimiento']; ?>">

        <label for="Precauciones">Precauciones:</label>
        <textarea name="Precauciones" id="Precauciones"><?php echo $paciente['Precauciones']; ?></textarea>

        <br>
        <input class="boton" type="submit" name="guardar" value="Guardar cambios">
        <a class="boton" href="pacientes.php">Regresar</a>

    </form>

</div>

<?php
include "pie.php";
?>
