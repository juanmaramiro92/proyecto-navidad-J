<?php

require_once "../_com/comunes-app.php";

$ofertas = DAO::ofertaObtenerTodas();

require "../_com/info-sesion.php";

?>


<html>

<head>
    <meta charset="UTF-8">
    <title>Listado de Ofertas de Trabajo</title>
</head>

<body>
<h1 style="text-align: center">Listado de Ofertas</h1>

<table border="1" style="margin: 0 auto; border-collapse: collapse">

    <tr>
        <th style="width: 148px; padding: 2px; background: #C9FC98">Puesto</th>
        <th style="width: 148px; padding: 2px; background: #C9FC98">Descripción</th>
        <th style="width: 77px; padding: 2px; background: #C9FC98">Salario</th>
        <th style="padding: 2px; background: #C9FC98">Inscribirse</th>
    </tr>

    <?php foreach ($ofertas as $oferta) { ?>
        <tr>
            <td style="padding: 5px; text-align: center;"><?=$oferta->getPuesto()?></td>
            <td style="padding: 5px;"><?=$oferta->getDescripcion()?></td>
            <td style="padding: 5px; text-align: center;"><?=$oferta->generarPrecioFormateado()?></td>
            <td style="text-align: center; text-decoration: none; padding: 5px; text-align: center;">
                <a href='gestionar-ofertas-guardadas.php?ofertaId=<?=$oferta->getId()?>&agregar=true'><img src="../img/add.png" width="15px" height="15px"></a>
            </td>
        </tr>
    <?php } ?>

</table>

</body>

</html>