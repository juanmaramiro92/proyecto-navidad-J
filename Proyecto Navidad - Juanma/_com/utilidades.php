<?php

// Esta función redirige a otra página y deja de ejecutar el PHP que la llamó:
function redireccionar($url)
{
    header("Location: $url");
    exit();
}

function generarCadenaAleatoria($longitud) : string
{
    for ($s = '', $i = 0, $z = strlen($a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')-1; $i != $longitud; $x = rand(0,$z), $s .= $a[$x], $i++);
    return $s;
}
