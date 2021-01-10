<?php

require_once "../_com/comunes-app.php";

$id = $_SESSION["id"];

$cliente = DAO::clienteObtenerPorId($id);

require "../_com/info-sesion.php";

?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
</head>

<style>
    .boton {
        padding: 4px 25px;
        background: #DCDCDC;
        border: 1px solid #000000;
        color: #000000;
        border-radius: 4px;
        text-decoration:none;
        font-weight: bold;
    }

    .boton:hover {
        padding: 4px 25px;
        background: #D3D3D3;
        border: 1px solid #000000;
        color: #000000;
        border-radius: 4px;
        text-decoration:none;
    }

</style>

<body>
<p>Nombre: <?=$cliente->getNombre()?></p>
<p>Email: <?=$cliente->getEmail()?></p>
<p>Telefono: <?=$cliente->getTelefono()?></p>

<br>

<a href="cliente-baja-confirmar.php" class="boton">Darme de baja</a>
<a href="ofertas-listado.php" class="boton">Volver al listado</a>
</body>

</html>