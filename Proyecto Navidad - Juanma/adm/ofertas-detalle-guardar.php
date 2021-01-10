<?php

require_once "../_com/comunes-app.php";

$id = $_REQUEST["ofertaId"];
$oferta = DAO::ofertaObtenerPorId($id);
$nuevoPuesto = $_REQUEST["puesto"];
$nuevaDescripcion = $_REQUEST["descripcion"];
$nuevoSalario = $_REQUEST["salario"];

DAO::ofertaActualizar($id,$nuevoPuesto,$nuevaDescripcion,$nuevoSalario);
?>



<html>
<body>
<p>Se ha actualizado correctamente la Oferta
</p><br><a href='ofertas-listado.php'>Volver a la lista</a>
</body>
</html>

