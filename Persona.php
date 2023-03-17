<?php
  // -----------------------------------------------------------------------
  // ------ Documento logico  --------
  // -----------------------------------------------------------------------
  include("./objects/DAO.php");$CON = new DAO();

  if( isset( $_GET["User"]) )
  {
    $persona = htmlspecialchars($_GET["User"]);
  }else {
    $persona = 'miguel.cabiativ';
  }

  $home = $CON->getPersonData($persona);
  $Services = true;
  $work = true;
  $about = true;
  $reviews = true;
  $blog = true;
  $contact = true;


  require './views/Persona.view.php';

?>
