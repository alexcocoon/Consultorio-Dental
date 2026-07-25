<?php
include "proteger_paciente.php";

include "conexion.php";

$titulo_pagina = "Mis citas";

include "encabezado_paciente.php";

$id_paciente = $_SESSION['id_paciente'];

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
} else {
    $buscar = "";
}

$buscar = mysqli_real_escape_string($conexion, $buscar);

$consulta_proxima = "SELECT * FROM citas
                     WHERE id_paciente = $id_paciente AND fecha >= CURDATE()
                     ORDER BY fecha ASC, hora ASC
                     LIMIT 1";
$resultado_proxima = mysqli_query($conexion, $consulta_proxima);
$proxima_cita = mysqli_fetch_assoc($resultado_proxima);

if ($buscar != "") {
    $consulta_citas = "SELECT * FROM citas
                       WHERE id_paciente = $id_paciente
                         AND (motivo LIKE '%$buscar%' OR fecha LIKE '%$buscar%')
                       ORDER BY fecha DESC, hora DESC";
} else {
    $consulta_citas = "SELECT * FROM citas
                       WHERE id_paciente = $id_paciente
                       ORDER BY fecha DESC, hora DESC";
}

$resultado_citas = mysqli_query($conexion, $consulta_citas);
?>

<div class="contenido">

    <h2>Mi proxima cita</h2>

    <div class="tarjeta">
        <?php
        if ($proxima_cita) {
        ?>
            <p><strong>Fecha:</strong> <?php echo $proxima_cita['fecha']; ?></p>
            <p><strong>Hora:</strong> <?php echo $proxima_cita['hora']; ?></p>
            <p><strong>Motivo:</strong> <?php echo $proxima_cita['motivo']; ?></p>
            <p><strong>Observaciones:</strong> <?php echo $proxima_cita['observaciones']; ?></p>
            <p>
                <strong>Confirmada:</strong>
                <?php
                if ($proxima_cita['confirmada'] == 1) {
                    echo "Si";
                } else {
                    echo "No, comunicate al consultorio para confirmarla.";
                }
                ?>
            </p>
        <?php
        } else {
            echo "<p>No tienes citas proximas.</p>";
        }
        ?>
    </div>

    <h2>Historial de mis citas</h2>

    <div class="buscador">
        <form method="GET" action="mis_citas.php">
            <label for="buscar">Buscar por motivo o fecha:</label>
            <input type="text" name="buscar" id="buscar" value="<?php echo $buscar; ?>">
            <input class="boton" type="submit" value="Buscar">
            <a class="boton" href="mis_citas.php">Ver todas</a>
        </form>
    </div>

    <table>
        <tr>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Motivo</th>
            <th>Observaciones</th>
            <th>Confirmada</th>
        </tr>

        <?php
        while ($cita = mysqli_fetch_assoc($resultado_citas)) {
        ?>
            <tr>
                <td><?php echo $cita['fecha']; ?></td>
                <td><?php echo $cita['hora']; ?></td>
                <td><?php echo $cita['motivo']; ?></td>
                <td><?php echo $cita['observaciones']; ?></td>
                <td>
                    <?php
                    if ($cita['confirmada'] == 1) {
                        echo "Si";
                    } else {
                        echo "No";
                    }
                    ?>
                </td>
            </tr>
        <?php
        }

        if (mysqli_num_rows($resultado_citas) == 0) {
        ?>
            <tr>
                <td colspan="5">No se encontraron citas.</td>
            </tr>
        <?php
        }
        ?>
    </table>

    <a class="boton" href="inicio_paciente.php">Regresar</a>

</div>

<?php
include "pie.php";
?>
