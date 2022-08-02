<?php
  // -----------------------------------------------------------------------
  // ------ Documento logico  --------
  // -----------------------------------------------------------------------
  include("objects/DAO.php");$CON = new DAO();

  $carruselInfo = $CON->getCarruselInfo();

  $titulo =   $carruselInfo['1']['0'];

  require 'views/index.view.php';

?>
