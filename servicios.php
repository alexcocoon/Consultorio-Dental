<?php

include "proteger_paciente.php";

$titulo_pagina = "Servicios";

include "encabezado_paciente.php";
?>

<div class="contenido">

    <h2>Conoce nuestros servicios</h2>

    <p>Da clic en el diente del servicio que quieras conocer.</p>

    <div class="caja-servicios">

        <a class="boton-diente" href="esteticos.php">
            <img src="../img/estetica.png" class="icono-diente" alt="Diente">
            <p><strong>Estéticos</strong></p>
        </a>

        <a class="boton-diente" href="reparacion.php">
            <img src="../img/reparacion.png" class="icono-diente" alt="Diente">
            <p><strong>Reparación</strong></p>
        </a>

        <a class="boton-diente" href="prevencion.php">
            <img src="../img/prevencion.png" class="icono-diente" alt="Diente">
            <p><strong>Prevención</strong></p>
        </a>

    </div>

    <a class="boton" href="inicio_paciente.php">Regresar</a>

</div>

<?php
include "pie.php";
?>
