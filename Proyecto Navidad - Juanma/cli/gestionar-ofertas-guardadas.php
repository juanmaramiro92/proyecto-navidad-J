<?php

require_once "../_com/comunes-app.php";

if (isset($_REQUEST['agregar']))
{
    $carrito = DAO::obtenerListadoOfertasGuardadasParaCliente($_SESSION["id"]);
    $variacionUnidades=1;
    if ($_REQUEST["variacionUnidades"])
    {
        $variacionUnidades = $_REQUEST["variacionUnidades"];
    }
    if (!$carrito)
    {
        $carrito = DAO::crearListadoOfertasGuardadasCliente($_SESSION["id"]);
    }
    foreach ($carrito->getLineas() as $linea)
    {
        if ($linea->getOfertaId() == $_REQUEST['ofertaId'])
        {
            DAO::listadoVariarUnidades($_SESSION["id"], $_REQUEST['ofertaId'], $variacionUnidades);
            redireccionar("ofertas-listado.php");
        }
    }
    DAO::agregarOfertaListadoOfertasGuardadas($_SESSION["id"],$_REQUEST['ofertaId'], $variacionUnidades);
    redireccionar("ofertas-listado.php");
}

if (isset($_REQUEST['eliminar']))
{
    $pedidoId = DAO::listadoVariarUnidades($_SESSION["id"], $_REQUEST["ofertaId"], 0);
    redireccionar("ofertas-guardadas.php");
}

