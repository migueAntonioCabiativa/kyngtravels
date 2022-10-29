<?php
  if(file_exists('../objects/ESO.php')) {include('../objects/ESO.php');} else{die( 'Unable to load the "ESO" Library!');}
  if(file_exists('../objects/DAO.php')) {include('../objects/DAO.php');} else{die( 'Unable to load the "DAO" Library!');}

  $email = new ESO();
  $CON = new DAO();
  $mail = strip_tags($_POST['email']);
  if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {
    $Email_state  = $CON->EmailCheck_CMB($mail);

    if ($Email_state == 0){
      $email->subscribe_comingsoon($mail);
      $CON->EmailSubscribe_IMX($mail);
      $responseArray = array('message' => "OK");
    }
    if($Email_state > 0){
      $responseArray = array('message' => "DONE");
    }
  }
  else {
    $emailErr = "Invalid email format";
    $responseArray = array('message' => "EMAIL");
  }
   echo $responseArray['message'];

?>
