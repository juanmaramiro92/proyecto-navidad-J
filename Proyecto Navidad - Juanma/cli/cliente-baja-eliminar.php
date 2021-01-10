<?php
require_once "../_com/comunes-app.php";

if (isset($_REQUEST["cancelar"])){
    redireccionar("cliente-detalle.php");
}
else{
DAO::clienteActualizar();
require_once "sesion-cerrar.php";
};