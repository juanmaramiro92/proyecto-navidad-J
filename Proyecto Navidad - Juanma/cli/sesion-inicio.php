<?php

require_once "../_com/requireonces-comunes.php";

if (haySesionRamIniciada()) redireccionar("../cli/ofertas-listado.php");

?>



<html>

<head>
    <meta charset="UTF-8">
    <title>Iniciar Sesión</title>
</head>

<body>

<?php
if (isset($_REQUEST["incorrecto"])) {
    echo "<p>Usuario o contraseña incorrectos.</p>";
}
if (isset($_REQUEST["registrado"])) {
    echo "<p>Se ha registrado correctamente. Inicie sesion para acceder a la página.</p>";
}
if (isset($_REQUEST["sesionCerrada"])) {
    echo "<p>Ha salido correctamente. Su sesión está ahora cerrada.</p>";
}
?>

<h1>Iniciar sesión</h1>

<form action="ofertas-listado.php" method="POST">
    <label><b>Email: </b></label><input name="email" type="email" placeholder="Email"><br />
    <label><b>Contraseña: </b></label><input type="password" name="contrasenna" placeholder="Contraseña"/><br />
    <label><b>Recuérdame</b></label><input type="checkbox" name="recuerdame" /><br />
    <br />
    <input type="Submit" value="Iniciar sesión" />
</form>
<a href="cliente-registro-formulario.php">Registrarme</a>
</body>
</html>