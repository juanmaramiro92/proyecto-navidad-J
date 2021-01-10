
<html>

<head>
    <meta charset="UTF-8">
</head>

<body>
<?php
if (isset($_REQUEST["error"])){
    echo "<p>Introduzca correctamente los datos</p>";
}
if (isset($_REQUEST["existe"])){
    echo "<p>Este email ya existe. Por favor introduzca otro</p>";
}
?>
<form action="cliente-registro-guardar.php">
    <input type="email" name="email">Email<br>
    <input type="password" name="contrasenna">Contraseña<br>
    <input type="text" name="nombre">Nombre<br>
    <input type="text" name="telefono">Telefono<br>
    <input type="submit" name="submit">
</form>

</body>
</html>
