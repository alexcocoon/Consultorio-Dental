<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($titulo_pagina)) {
    $titulo_pagina = "Mi panel";
}

if (isset($_GET['modo'])) {
    if ($_GET['modo'] == "accesible") {
        $_SESSION['modo_accesible'] = "si";
    } else {
        $_SESSION['modo_accesible'] = "no";
    }
}

if (isset($_SESSION['modo_accesible']) && $_SESSION['modo_accesible'] == "si") {
    $hoja_de_estilos  = "paciente_accesible.css";
    $texto_boton_modo = "Modo normal";
    $valor_boton_modo = "normal";
} else {
    $hoja_de_estilos  = "paciente.css";
    $texto_boton_modo = "Modo accesible";
    $valor_boton_modo = "accesible";
}

$enlace_modo = $_SERVER['PHP_SELF'] . "?modo=" . $valor_boton_modo;

if (isset($_GET['id'])) {
    $enlace_modo = $enlace_modo . "&id=" . $_GET['id'];
}
if (isset($_GET['buscar'])) {
    $enlace_modo = $enlace_modo . "&buscar=" . $_GET['buscar'];
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $titulo_pagina; ?></title>
    <link rel="stylesheet" href="../css/paciente.css"<?php echo $hoja_de_estilos; ?>">
</head>
<body>

<div class="encabezado">

    <div class="logo">
        <img src="../img/logoF.png" alt="Logo del consultorio">
        <h1>Consultorio Dental Sonrisa Sana</h1>
    </div>

    <div class="menu">
        <?php include "menu_paciente.php"; ?>
        <a class="boton" href="<?php echo $enlace_modo; ?>"><?php echo $texto_boton_modo; ?></a>
    </div>

</div>
