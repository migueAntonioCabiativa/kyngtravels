<?php
  if(file_exists('../ESO.php'){include('../ESO.php');}else{die( 'Unable to load the "ESO" Library!');}
  if( file_exists('../DAO.php') {
    include('../DAO.php');
  } else {
    die( 'Unable to load the "DAO" Library!');
  }

  $email = new ESO();
  $CON = new DAO();
  $name = strip_tags($_POST['name']);
  $mail = strip_tags($_POST['email']);
  $subject = strip_tags($_POST['subject']);
  $message = strip_tags($_POST['message']);

  $Email_state  = $CON->EmailCheck_CMB($mail);

  if ($Email_state == 0){
    $email->subscribe_comingsoon($mail);
    $CON->EmailSubscribe_IMX($mail);
  }
  $email->subscribe_comingsoon($name,$mail);

  $responseArray = array('message' => "OK");
   echo $responseArray['message'];
?>
