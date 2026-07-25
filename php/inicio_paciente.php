<?php
include "proteger_paciente.php";

include "conexion.php";

$titulo_pagina = "Mi panel";

include "encabezado_paciente.php";

$id_paciente = $_SESSION['id_paciente'];

$resultado = mysqli_query($conexion, "SELECT * FROM pacientes WHERE id_paciente = $id_paciente");
$paciente = mysqli_fetch_assoc($resultado);

$consulta_proxima = "SELECT * FROM citas
                     WHERE id_paciente = $id_paciente AND fecha >= CURDATE()
                     ORDER BY fecha ASC, hora ASC
                     LIMIT 1";
$resultado_proxima = mysqli_query($conexion, $consulta_proxima);
$proxima_cita = mysqli_fetch_assoc($resultado_proxima);
?>

<div class="contenido">

    <h2>Hola, <?php echo $paciente['nombre'] . " " . $paciente['apellido']; ?></h2>
    <p>Bienvenido a tu panel. Aqui puedes revisar tus citas, tu historial medico y nuestros servicios.</p>

    <div class="tarjeta">
        <h3>Mis datos</h3>
        <p><strong>Telefono:</strong> <?php echo $paciente['telefono']; ?></p>
        <p><strong>Correo:</strong> <?php echo $paciente['correo']; ?></p>
        <p><strong>Fecha de nacimiento:</strong> <?php echo $paciente['fecha_nacimiento']; ?></p>
        <p><strong>Precauciones:</strong> <?php echo $paciente['Precauciones']; ?></p>
    </div>

    <div class="tarjeta">
        <h3>Mi proxima cita</h3>
        <?php
        if ($proxima_cita) {
        ?>
            <p><strong>Fecha:</strong> <?php echo $proxima_cita['fecha']; ?></p>
            <p><strong>Hora:</strong> <?php echo $proxima_cita['hora']; ?></p>
            <p><strong>Motivo:</strong> <?php echo $proxima_cita['motivo']; ?></p>
        <?php
        } else {
            echo "<p>No tienes citas proximas. Llama al consultorio para agendar una.</p>";
        }
        ?>
    </div>

    <p>
        <a class="boton" href="mis_citas.php">Mis citas</a>
        <a class="boton" href="mi_historial.php">Mi historial medico</a>
        <a class="boton" href="servicios.php">Servicios</a>
    </p>

</div>

<?php
include "pie.php";
?>
