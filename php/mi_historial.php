<?php
include "proteger_paciente.php";

include "conexion.php";

$titulo_pagina = "Mi historial medico";

include "encabezado_paciente.php";

$id_paciente = $_SESSION['id_paciente'];
$consulta = "SELECT * FROM historial
             WHERE id_paciente = $id_paciente
             ORDER BY fecha DESC";

$resultado = mysqli_query($conexion, $consulta);
?>

<div class="contenido">

    <h2>Mi historial medico</h2>

    <p>Aqui puedes ver lo que el doctor registro en cada una de tus consultas.</p>

    <table>
        <tr>
            <th>Fecha</th>
            <th>Diagnostico</th>
            <th>Tratamiento realizado</th>
            <th>Observaciones</th>
            <th>Proxima recomendacion</th>
        </tr>

        <?php
        while ($registro = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr>
                <td><?php echo $registro['fecha']; ?></td>
                <td><?php echo $registro['diagnostico']; ?></td>
                <td><?php echo $registro['tratamiento']; ?></td>
                <td><?php echo $registro['observaciones']; ?></td>
                <td><?php echo $registro['proxima_recomendacion']; ?></td>
            </tr>
        <?php
        }

        if (mysqli_num_rows($resultado) == 0) {
        ?>
            <tr>
                <td colspan="5">Todavia no tienes registros en tu historial medico.</td>
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
