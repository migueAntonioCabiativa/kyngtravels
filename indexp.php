<?php
  // -----------------------------------------------------------------------
  // ------ Documento logico  --------
  // -----------------------------------------------------------------------
  include("objects/DAO.php");$CON = new DAO();
  //include("objects/ESO.php");$EMAIL = new ESO();

  $carruselInfo = $CON->getCarruselInfo();

//  $EMAIL->Correo();

  $titulo =   $carruselInfo['1']['0'];

  require 'views/index.view.php';

?>
