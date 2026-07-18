<?php
include "proteger_paciente.php";
include "conexion.php";

$titulo_pagina = "Servicios de prevencion";

include "encabezado_paciente.php";
$resultado = mysqli_query($conexion, "SELECT * FROM servicios WHERE categoria = 'prevencion'");
?>
<div class="contenido">

    <h2>&#129463; Servicios de prevencion</h2>

    <p>Estos tratamientos evitan que aparezcan problemas en tus dientes.</p>

    <?php
    while ($servicio = mysqli_fetch_assoc($resultado)) {
    ?>
        <div class="tarjeta">
            <h3><?php echo $servicio['nombre_servicio']; ?></h3>
            <p><?php echo $servicio['descripcion']; ?></p>
            <p><strong>Precio aproximado:</strong> $<?php echo $servicio['precio']; ?></p>
        </div>
    <?php
    }
    ?>
    <a class="boton" href="servicios.php">Regresar</a>

</div>

<?php
include "pie.php";
?>
