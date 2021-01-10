<?php

require_once "../_com/comunes-app.php";

$id = $_REQUEST["id"];

$oferta = DAO::ofertaObtenerPorId($id);

require "../_com/info-sesion.php";

?>



<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Modificar Oferta</title>
</head>
<body>
    <p>Puesto: <?=$oferta->getPuesto()?></p>
    <p>Descripción: <?=$oferta->getDescripcion()?></p>
    <p>Salario: <?=$oferta->getSalario()?> €</p>

    <hr>




    <?php //If (usuario==admin){?>
        <form action="ofertas-detalle-guardar.php">
            Realizar cambios en el producto:
            <input type="text" name="ofertaId" value="<?=$id?>" size="1" readonly><br><br>
            Nuevo puesto:<br> <input type="text" name="puesto"><br><br>
            Nueva descripción:<br> <textarea name="descripcion" cols="40" rows="5"></textarea><br><br>
            Nuevo salario:<br> <input type="number" name="salario"><br><br>
            <input type="submit">
        </form>
    <?php //}?>
    <br>
    <a href="ofertas-listado.php">Volver al listado</a>
</body>
</html>
