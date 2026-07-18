<?php


include "conexion.php";

$titulo_pagina = "Servicios de reparacion";

include "encabezado_paciente.php";

$resultado = mysqli_query($conexion, "SELECT * FROM servicios WHERE categoria = 'reparacion'");
?>

<div class="contenido">

    <h2>&#129463; Servicios de reparacion</h2>

    <p>Estos tratamientos reparan los dientes danados por caries o golpes.</p>

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
