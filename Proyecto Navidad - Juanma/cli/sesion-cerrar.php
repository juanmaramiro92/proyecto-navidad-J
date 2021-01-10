<?php

require_once "../_com/comunes-app.php";

destruirSesionYCookies($_SESSION["email"]);

redireccionar("sesion-inicio.php");

?>

