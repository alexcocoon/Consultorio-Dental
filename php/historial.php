<?php
include "proteger_doctor.php";

include "conexion.php";

$titulo_pagina = "Historial medico";

include "encabezado_doctor.php";

if (isset($_GET['id'])) {
    $id_paciente = mysqli_real_escape_string($conexion, $_GET['id']);
} else {
    $id_paciente = "";
}

$resultado_pacientes = mysqli_query($conexion, "SELECT * FROM pacientes ORDER BY nombre ASC");
?>

<div class="contenido">

    <h2>Historial medico</h2>

    <?php
    if (isset($_GET['mensaje'])) {
        echo "<div class='mensaje'>" . $_GET['mensaje'] . "</div>";
    }
    ?>
    <div class="buscador">
        <form method="GET" action="historial.php">
            <label for="id">Selecciona un paciente:</label>
            <select name="id" id="id">
                <option value="">-- Selecciona un paciente --</option>
                <?php
                while ($paciente = mysqli_fetch_assoc($resultado_pacientes)) {
                ?>
                    <option value="<?php echo $paciente['id_paciente']; ?>"
                        <?php
                        if ($paciente['id_paciente'] == $id_paciente) {
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
            <input class="boton" type="submit" value="Ver historial">
        </form>
    </div>

    <?php
    if ($id_paciente != "") {

        $resultado_paciente = mysqli_query($conexion, "SELECT * FROM pacientes WHERE id_paciente = $id_paciente");
        $paciente_elegido = mysqli_fetch_assoc($resultado_paciente);

        if ($paciente_elegido) {

            $consulta_historial = "SELECT * FROM historial
                                   WHERE id_paciente = $id_paciente
                                   ORDER BY fecha DESC";
            $resultado_historial = mysqli_query($conexion, $consulta_historial);
    ?>

            <div class="tarjeta">
                <h3>Paciente: <?php echo $paciente_elegido['nombre'] . " " . $paciente_elegido['apellido']; ?></h3>
                <p><strong>Telefono:</strong> <?php echo $paciente_elegido['telefono']; ?></p>
                <p><strong>Correo:</strong> <?php echo $paciente_elegido['correo']; ?></p>
            </div>

            <a class="boton" href="agregar_historial.php?id=<?php echo $id_paciente; ?>">
                Agregar registro al historial
            </a>

            <table>
                <tr>
                    <th>Fecha</th>
                    <th>Diagnostico</th>
                    <th>Tratamiento realizado</th>
                    <th>Observaciones</th>
                    <th>Proxima recomendacion</th>
                    <th>Acciones</th>
                </tr>

                <?php
                while ($registro = mysqli_fetch_assoc($resultado_historial)) {
                ?>
                    <tr>
                        <td><?php echo $registro['fecha']; ?></td>
                        <td><?php echo $registro['diagnostico']; ?></td>
                        <td><?php echo $registro['tratamiento']; ?></td>
                        <td><?php echo $registro['observaciones']; ?></td>
                        <td><?php echo $registro['proxima_recomendacion']; ?></td>
                        <td>
                            <a href="editar_historial.php?id=<?php echo $registro['id_historial']; ?>">Modificar</a>
                        </td>
                    </tr>
                <?php
                }

                if (mysqli_num_rows($resultado_historial) == 0) {
                ?>
                    <tr>
                        <td colspan="6">Este paciente todavia no tiene registros en su historial.</td>
                    </tr>
                <?php
                }
                ?>
            </table>

    <?php
        }
    }
    ?>

</div>

<?php
include "pie.php";
?>
