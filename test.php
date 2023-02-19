<?php
if( isset( $_COOKIE['QR']) )
{
  if ($_COOKIE['QR']==1234) {
    $mensaje = '¡Hola ' . htmlspecialchars($_GET["QR"]) . '!';
  }


}else {
  $mensaje = 'No tienes acceso';
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <h1><?php echo $mensaje; ?></h1>
  </body>
</html>
