<?php
include "proteger_doctor.php";

include "conexion.php";

$titulo_pagina = "Pacientes";

include "encabezado_doctor.php";

if (isset($_GET['buscar'])) {
    $buscar = $_GET['buscar'];
} else {
    $buscar = "";
}

$buscar = mysqli_real_escape_string($conexion, $buscar);

if ($buscar != "") {
    $consulta = "SELECT * FROM pacientes
                 WHERE nombre LIKE '%$buscar%'
                    OR apellido LIKE '%$buscar%'
                    OR telefono LIKE '%$buscar%'
                    OR correo LIKE '%$buscar%'
                 ORDER BY id_paciente ASC";
} else {
    $consulta = "SELECT * FROM pacientes ORDER BY id_paciente ASC";
}

$resultado = mysqli_query($conexion, $consulta);
?>

<div class="contenido">

    <h2>Listado de pacientes</h2>

    <?php
    
    if (isset($_GET['mensaje'])) {
        echo "<div class='mensaje'>" . $_GET['mensaje'] . "</div>";
    }
    ?>

    <div class="buscador">
        <form method="GET" action="pacientes.php">
            <label for="buscar">Buscar paciente:</label>
            <input type="text" name="buscar" id="buscar" value="<?php echo $buscar; ?>">
            <input class="boton" type="submit" value="Buscar">
            <a class="boton" href="pacientes.php">Ver todos</a>
        </form>
    </div>

    <a class="boton" href="../html/registrar_paciente.html">Registrar paciente nuevo</a>

    <table>
        <tr>
            <th>Numero</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Telefono</th>
            <th>Correo</th>
            <th>Fecha de nacimiento</th>
            <th>Acciones</th>
        </tr>

        <?php
        while ($fila = mysqli_fetch_assoc($resultado)) {
        ?>
            <tr>
                <td><?php echo $fila['id_paciente']; ?></td>
                <td><?php echo $fila['nombre']; ?></td>
                <td><?php echo $fila['apellido']; ?></td>
                <td><?php echo $fila['telefono']; ?></td>
                <td><?php echo $fila['correo']; ?></td>
                <td><?php echo $fila['fecha_nacimiento']; ?></td>
                <td>
                    <a href="editar_paciente.php?id=<?php echo $fila['id_paciente']; ?>">Modificar</a>
                    |
                    <a href="eliminar_paciente.php?id=<?php echo $fila['id_paciente']; ?>">Eliminar</a>
                    |
                    <a href="historial.php?id=<?php echo $fila['id_paciente']; ?>">Historial</a>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>

    <?php
    if (mysqli_num_rows($resultado) == 0) {
        echo "<div class='mensaje'>No se encontraron pacientes con esa busqueda.</div>";
    }
    ?>

</div>

<?php
include "pie.php";
?>
