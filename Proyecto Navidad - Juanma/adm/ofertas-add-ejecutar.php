<?php

require_once "../_com/comunes-app.php";

$puesto = $_REQUEST["puesto"];
$descripcion = $_REQUEST["descripcion"];
$salario = $_REQUEST["salario"];
$producto = new Oferta( NULL,$puesto, $descripcion, $salario);
?>


<html>
<body>
<h2>Oferta añadida correctamente</h2><br>
<a href='ofertas-listado.php'>Volver al listado</a>
</body>
</html>


