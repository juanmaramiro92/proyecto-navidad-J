<?php

require_once "../_com/comunes-app.php";

$ofertasGuardadas = DAO::obtenerListadoOfertasGuardadasParaCliente($_SESSION["id"]);

require "../_com/info-sesion.php";

?>


<html>

<head>
  <meta charset="UTF-8">
  <title>Mis Ofertas</title>
</head>

<style>
    .boton {
        padding: 4px 25px;
        background: #DCDCDC;
        border: 1px solid #000000;
        color: #000000;
        border-radius: 4px;
        text-decoration:none;
        font-weight: bold;
    }

    .boton:hover {
        padding: 4px 25px;
        background: #D3D3D3;
        border: 1px solid #000000;
        color: #000000;
        border-radius: 4px;
        text-decoration:none;
    }

</style>

<body>

<h1 style="text-align: center">Mis Inscripciones</h1>

<table border="1" style="margin: 0 auto; border-collapse: collapse">
  <thead>
  <tr>
    <th style="width: 148px; padding: 2px; background: #B1A9FF">Puesto</th>
    <th style="width: 775px; padding: 2px; background: #B1A9FF">Descripción</th>
    <th style="width: 77px; padding: 2px; background: #B1A9FF">Salario</th>
    <th style="padding: 2px; background: #B1A9FF">Eliminar</th>
  </tr>
  </thead>
  <tbody>

  <?php

  if ($ofertasGuardadas) {
      foreach ($ofertasGuardadas->getLineas() as $linea) {
          $oferta = DAO::ofertaObtenerPorId($linea->getOfertaId());
          ?>
        <tr>
          <td style="padding: 5px; text-align: center; background: #EFEEF1"><?= $oferta->getPuesto() ?></td>
          <td class="text-center" style="padding: 5px; background: #EFEEF1"><?= $oferta->getDescripcion() ?></td>
          <td class="text-center" style="padding: 5px; text-align: center; background: #EFEEF1"><?= $oferta->generarPrecioFormateado() ?></td>
          <td class="text-center" style="text-align: center; background: #EFEEF1"><a
                href="gestionar-ofertas-guardadas.php?ofertaId=<?= $oferta->getId() ?>&eliminar=true">X</a>
          </td>
        </tr>
          <?php
      }
  }
  ?>
  </tbody>
</table>
<br>
<div style="text-align: center"><a href="ofertas-listado.php" class="boton">Seguir mirando ofertas</a></div>


</body>

</html>