<?php
include "proteger_doctor.php";

include "conexion.php";

$titulo_pagina = "Panel del doctor";

include "encabezado_doctor.php";

$resultado_pacientes = mysqli_query($conexion, "SELECT * FROM pacientes");
$total_pacientes = mysqli_num_rows($resultado_pacientes);

$resultado_citas = mysqli_query($conexion, "SELECT * FROM citas");
$total_citas = mysqli_num_rows($resultado_citas);

$consulta_proximas = "SELECT citas.*, pacientes.nombre, pacientes.apellido
                      FROM citas
                      INNER JOIN pacientes ON citas.id_paciente = pacientes.id_paciente
                      WHERE citas.fecha >= CURDATE()
                      ORDER BY citas.fecha ASC, citas.hora ASC";
$resultado_proximas = mysqli_query($conexion, $consulta_proximas);
?>

<div class="contenido">

    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>
    <p>Este es el panel del doctor. Desde aqui puedes gestionar pacientes, citas e historiales.</p>

    <div class="caja-servicios">
        <div class="tarjeta">
            <h3>Pacientes registrados</h3>
            <p class="emoji-diente"><?php echo $total_pacientes; ?></p>
        </div>
        <div class="tarjeta">
            <h3>Citas registradas</h3>
            <p class="emoji-diente"><?php echo $total_citas; ?></p>
        </div>
        <div class="tarjeta">
            <h3>Acciones rapidas</h3>
            <p><a class="boton" href="../html/registrar_paciente.html">Registrar paciente</a></p>
            <p><a class="boton" href="agregar_cita.php">Registrar cita</a></p>
        </div>
    </div>

    <h2>Proximas citas</h2>

    <table>
        <tr>
            <th>Paciente</th>
            <th>Fecha</th>
            <th>Hora</th>
            <th>Motivo</th>
            <th>Confirmada</th>
        </tr>

        <?php
       
        while ($fila = mysqli_fetch_assoc($resultado_proximas)) {
        ?>
            <tr>
                <td><?php echo $fila['nombre'] . " " . $fila['apellido']; ?></td>
                <td><?php echo $fila['fecha']; ?></td>
                <td><?php echo $fila['hora']; ?></td>
                <td><?php echo $fila['motivo']; ?></td>
                <td>
                    <?php
                    if ($fila['confirmada'] == 1) {
                        echo "Si";
                    } else {
                        echo "No";
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </table>

</div>

<?php
include "pie.php";
?>
