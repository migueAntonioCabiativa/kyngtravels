<?php
if( isset( $_COOKIE['QR']) )
{
echo 'La COOKIE ya existe en este dispositivo';
}
else
{
  setcookie('QR', 1234, time() + 60*60*24);
  echo 'Se ha creado COOKIE';
}
 ?>
