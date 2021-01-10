<?php

require_once "dao.php";
require_once "clases.php";
require_once "utilidades.php";

function sessionStartSiNoLoEsta()
{
    if (!isset($_SESSION)) {
        session_start();
    }
}

// Comprueba si hay sesión-usuario iniciada en la sesión-RAM.
function haySesionRamIniciada()
{
    sessionStartSiNoLoEsta();
    return isset($_SESSION['sesionIniciada']);
}

function vieneFormularioDeInicioDeSesion()
{
    return isset($_REQUEST['email']);
}

function vieneCookieRecuerdame()
{
    return isset($_COOKIE["email"]);
}

function garantizarSesion()
{
    sessionStartSiNoLoEsta();

    if (haySesionRamIniciada()) {
        // Si hay cookie de "recuérdame", la renovamos.
        if (vieneCookieRecuerdame()) {
            establecerCookieRecuerdame($_COOKIE["email"], $_COOKIE["codigoCookie"]);
        }

        // >>> NO HACEMOS NADA MÁS. DEJAMOS QUE SE CONTINÚE EJECUTANDO EL PHP QUE NOS LLAMÓ... >>>
    } else { // NO hay sesión iniciada.
        if (vieneFormularioDeInicioDeSesion()) { // SÍ hay formulario enviado. Lo comprobaremos contra la BD.
            $cliente = DAO::clienteObtenerPorEmailYContrasenna($_REQUEST['email'], $_REQUEST['contrasenna']);

            if ($cliente) { // Si viene un cliente es que el inicio de sesión ha sido exitoso.
                anotarDatosSesionRam($cliente);

                if (isset($_REQUEST["recuerdame"])) { // Si han marcado el checkbox de recordar:
                    generarCookieRecuerdame($cliente);
                }
                // >>> Y DEJAMOS QUE SE CONTINÚE EJECUTANDO EL PHP QUE NOS LLAMÓ... >>>
            } else { // Si cliente es null, o no existe ese cliente o la contraseña no coincide.
                redireccionar("../cli/sesion-inicio.php?incorrecto=true");
            }
        } else if (vieneCookieRecuerdame()) {
            $cliente = DAO::clienteObtenerPorEmailYCodigoCookie($_COOKIE["email"], $_COOKIE["codigoCookie"]); // TODO Hacer esto con DAO.

            if ($cliente) { // Si viene un cliente es que existe el cliente y coincide el código cookie. Daremos por iniciada la sesión.
                // Recuperar los datos adicionales del usuario que acaba de iniciar sesión.
                anotarDatosSesionRam($cliente);

                // Renovar la cookie (código y caducidad).
                generarCookieRecuerdame($cliente);
            } else { // Parecía que venía una cookie válida pero... No es válida o pasa algo raro.
                // Borrar la cookie mala que nos están enviando (si no, la enviarán otra vez, y otra, y otra...)
                borrarCookieRecuerdame($cliente->getEmail());

                // REDIRIGIR A INICIAR SESIÓN PARA IMPEDIR QUE ESTE USUARIO VISUALICE CONTENIDO PRIVADO.
                redireccionar("../cli/sesion-inicio.php");
            }
        } else { // NO hay ni sesión, ni cookie, ni formulario enviado.
            // REDIRIGIMOS PARA QUE NO SE VISUALICE CONTENIDO PRIVADO:
            redireccionar("../cli/sesion-inicio.php");
        }
    }
}

function establecerCookieRecuerdame($email, $codigoCookie)
{
    // Enviamos el código cookie al cliente, junto con su identificador.
    setcookie("email", $email, time() + 24*60*60); // Un mes sería: +30*24*60*60
    setcookie("codigoCookie", $codigoCookie, time() + 24*60*60); // Un mes sería: +30*24*60*60
}


function generarCookieRecuerdame($cliente)
{
    // Creamos un código cookie muy complejo (no necesariamente único).
    $codigoCookie = generarCadenaAleatoria(32); // Random...
    DAO::clienteGuardarCodigoCookie($cliente->getEmail(), $codigoCookie);

    // TODO Para una seguridad óptima convendriá anotar en la BD la fecha de caducidad de la cookie y no aceptar ninguna cookie pasada dicha fecha.

    establecerCookieRecuerdame($cliente->getEmail(), $codigoCookie);
}

function borrarCookieRecuerdame($email)
{
    // Eliminamos el código cookie de nuestra BD.
    DAO::clienteGuardarCodigoCookie($email, null);

    setcookie("email", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.
    setcookie("codigoCookie", "", time() - 3600); // Tiempo en el pasado, para (pedir) borrar la cookie.
}

function anotarDatosSesionRam($cliente)
{
    $_SESSION["sesionIniciada"] = "";
    $_SESSION["id"] = $cliente->getId();
    $_SESSION["email"] = $cliente->getEmail();
    $_SESSION["nombre"] = $cliente->getNombre();
    // TODO: Para implementar una superclase Usuario para Cliente y Administrador, aquí habría que añadir algo como esto: $_SESSION["tipoUsuario"] = "ADM" / "CLI";
}

function destruirSesionYCookies($email)
{
    session_destroy();

    borrarCookieRecuerdame($email);
}