<?php
  include("./objects/DAO.php");$CON = new DAO();

  $Personas = $CON->getPersonData(NULL);
  
  require './views/Equipo.view.php';
?>
