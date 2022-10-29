<?php
  // -----------------------------------------------------------------------
  // ------ Documento logico  --------
  // -----------------------------------------------------------------------
  include("objects/DAO.php");$CON = new DAO();
  //include("objects/ESO.php");$EMAIL = new ESO();

  $carruselInfo = $CON->getCarruselInfo();

//  $EMAIL->Correo();


  require 'views/index.view.php';

?>
