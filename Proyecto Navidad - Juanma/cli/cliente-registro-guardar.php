<?php
require_once "../_com/requireonces-comunes.php";
if (isset($_REQUEST["email"]) && $_REQUEST["email"]!=""){
    $email=$_REQUEST["email"];
    $existeEmail=DAO::clienteObtenerPorEmail($email);
    if ($existeEmail==true){
        redireccionar("cliente-registro-formulario.php?existe");
    }
    $contrasenna=$_REQUEST["contrasenna"];
    $nombre=$_REQUEST["nombre"];
    $telefono=$_REQUEST["telefono"];
    DAO::clienteCrear($email, $contrasenna, $nombre, $telefono);
    redireccionar("sesion-inicio.php?registrado");
}
else{
    redireccionar("cliente-registro-formulario.php?error");
}