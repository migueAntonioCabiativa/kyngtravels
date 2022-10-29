<?php //------            ESO (Email Send Object) Objeto de envio de Correo               ------------
require('layouts/mqtt/phpMQTT.php');
class MQTTO{
  private $server = 'xianbot.com';     // direccion donde se encuentra el broker
  private $port = 1883;                // Puerto por el cual se va a comunicar
  private $username = 'web_client';
  private $password = '123456789';
  private $client_id = 'Xianbot';
  private $connected = false;

  public function LED($state){
    $mqtt = new Bluerhinos\phpMQTT($this->server, $this->port, $this->client_id);
    if(!$mqtt->connect(true, NULL, $this->username, $this->password)) {$this->connected = false;}else {$this->connected = true;}
    if ($this->connected){
      if ($state=='on'){
        $mqtt->publish('led1', 'on', 0, true);
        $texto="El led ha sido encendido";
      }elseif ($state=='off'){
        $mqtt->publish('led1', 'off', 0, true);
        $texto="El led ha sido apagado";
      }else {
        $texto="no tengo informacion sobre el led";
      }
      $mqtt->close();
    }else {
      $texto="No me es posible conectarme con el dispositivo que prende el LED. Ya le envié un correo a soporte";
    }
    enviar_texto($texto);
  }
}
?>
