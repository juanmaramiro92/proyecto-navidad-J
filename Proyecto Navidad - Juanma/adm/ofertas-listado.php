<?php

require_once "../_com/comunes-app.php";

$ofertas = DAO::ofertaObtenerTodas();

require "../_com/info-sesion.php";

?>



<html>

<head>
    <meta charset="UTF-8">
    <title>Listado de Ofertas de Trabajo - Admin</title>
</head>

<body>
<h1 style="text-align: center">Listado de Ofertas</h1>

<table border="1" style="margin: 0 auto">

    <tr>
        <th>Puesto</th>
        <th>Salario</th>
        <th>Modificar</th>
    </tr>

    <?php foreach ($ofertas as $oferta) { ?>
        <tr>
            <td>
                <a ><?=$oferta->getPuesto()?></a>
            </td>
            <td>
                <a ><?=$oferta->generarPrecioFormateado()?></a>
            </td>
            <td>
                <a href='ofertas-detalle.php?id=<?=$oferta->getId()?>'>Modificar</a>
            </td>
        </tr>
    <?php } ?>

</table><br>

<div style="text-align: center"><a href="ofertas-add.php">Añadir Oferta</a></div>

</body>

</html>