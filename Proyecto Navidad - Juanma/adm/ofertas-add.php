<?php

require_once "../_com/comunes-app.php";

require "../_com/info-sesion.php";

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
    <form action="ofertas-add-ejecutar.php">
    <h2>Añadir una nueva oferta:</h2>
    Puesto<br>
    <input type="text" name="puesto" required><br><br>
    Descripción<br>
    <textarea name="descripcion" cols="40" rows="5" required></textarea><br><br>
    Salario<br>
    <input type="number" min="0" step="any" name="salario" required><br><br>
    <input type="submit">
    </form><br>
<a href="ofertas-listado.php">Volver a listado</a>


</body>
</html>