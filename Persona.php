<?php
  // -----------------------------------------------------------------------
  // ------ Documento logico  --------
  // -----------------------------------------------------------------------
  include("./objects/DAO.php");$CON = new DAO();

  if( isset( $_GET["User"]))
  {
    $persona = htmlspecialchars($_GET["User"]);
  }else {
    header("Location: Equipo");
    die();
  }

  $home = $CON->getPersonData($persona);
  if (!$home) {
    header("Location: Equipo");
    die();
  }
  $Services = true;
  $experiance = true;
  $about = true;
  $reviews = true;
  $blog = true;
  $contact = true;


  require './views/Persona.view.php';

?>
