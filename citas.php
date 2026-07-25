<?php
include "proteger_doctor.php";

include "conexion.php";

$titulo_pagina = "Citas";

include "encabezado_doctor.php";

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
} else {
    $buscar = "";
}

$buscar = mysqli_real_escape_string($conexion, $buscar);

if ($buscar != "") {
    $consulta = "SELECT citas.*, pacientes.nombre, pacientes.apellido
                 FROM citas
                 INNER JOIN pacientes ON citas.id_paciente = pacientes.id_paciente
                 WHERE pacientes.nombre LIKE '%$buscar%'
                    OR pacientes.apellido LIKE '%$buscar%'
                    OR citas.motivo LIKE '%$buscar%'
                    OR citas.fecha LIKE '%$buscar%'
                 ORDER BY citas.fecha DESC, citas.hora DESC";
} else {
    $consulta = "SELECT citas.*, pacientes.nombre, pacientes.apellido
                 FROM citas
                 INNER JOIN pacientes ON citas.id_paciente = pacientes.id_paciente
                 ORDER BY citas.fecha DESC, citas.hora DESC";
}

$resultado = mysqli_query($conexion, $consulta);
?>

<div class="contenido">

    <h2>Listado de citas</h2>

    <?php
    if (isset($_GET['mensaje'])) {
        echo "<div class='mensaje'>" . $_GET['mensaje'] . "</div>";
    }
    ?>

    <!-- Barra de busqueda -->
    <div class="buscador">
        <form method="GET" action="citas.php">
            <label for="buscar">Buscar cita (paciente, motivo o fecha):</label>
            <input type="text" name="buscar" id="buscar" value="<?php echo $buscar; ?>">
            <input class="boton" type="submit" value="Buscar">
            <a class="boton" href="citas.php">Ver todas</a>
        </form>
    </div>

    <a class="boton" href="agregar_cita.php">Registrar cita nueva</a>

    <table>
        <tr>
            <th>Numero</th>
            <th>Paciente</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Motivo</th>
            <th>Observaciones</th>
            <th>Confirmada</th>
            <th>Acciones</th>
        </tr>

        <?php
        while ($fila = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr>
                <td><?php echo $fila['id_cita']; ?></td>
                <td><?php echo $fila['nombre'] . " " . $fila['apellido']; ?></td>
                <td><?php echo $fila['fecha']; ?></td>
                <td><?php echo $fila['hora']; ?></td>
                <td><?php echo $fila['motivo']; ?></td>
                <td><?php echo $fila['observaciones']; ?></td>
                <td>
                    <?php
                    if ($fila['confirmada'] == 1) {
                        echo "Si";
                    } else {
                        echo "No";
                    }
                    ?>
                </td>
                <td>
                    <a href="editar_cita.php?id=<?php echo $fila['id_cita']; ?>">Modificar</a>
                    |
                    <a href="eliminar_cita.php?id=<?php echo $fila['id_cita']; ?>">Eliminar</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>

    <?php
    if (mysqli_num_rows($resultado) == 0) {
        echo "<div class='mensaje'>No se encontraron citas con esa busqueda.</div>";
    }
    ?>

</div>

<?php
include "pie.php";
?>
