<?php //------            ESO (Email Send Object) Objeto de envio de Correo               ------------
require('layouts/mqtt/phpMQTT.php');


class MQTTO{
  private $server = '18.229.81.216';     // direccion donde se encuentra el broker
  private $port = 1883;                // Puerto por el cual se va a comunicar
  private $username = 'mhconcepts';
  private $password = '121212';
  private $client_id = 'bot';
  private $connected = false;

  public function TV($state,$topic){
    $mqtt = new Bluerhinos\phpMQTT($this->server, $this->port, $this->client_id);
    $i=0;
    while($i<10){
      if(!$mqtt->connect(true, NULL, $this->username, $this->password)) {$this->connected = false;$i++;}else {$this->connected = true;$i=11;}
    }
    if ($this->connected){
      if ($state=='on'){
        $mqtt->publish($topic, '2', 0, false);
        $texto="El TV ha sido encendido";
      }elseif ($state=='off'){
        $mqtt->publish($topic, '2', 0, false);
        $texto="El TV ha sido apagado";
      }else {
        $texto="No tengo informacion sobre el TV";
      }
      $mqtt->close();
    }else {
      $texto="No me fue posible conectarme al servidor. BROKER";
    }
    return $texto;
  }

  public function send_topic($topic,$value){
    $mqtt = new Bluerhinos\phpMQTT($this->server, $this->port, $this->client_id);
    $i=0;
    while($i<10){
      if(!$mqtt->connect(true, NULL, $this->username, $this->password)) {$this->connected = false;$i++;}else {$this->connected = true;$i=11;}
    }
    if ($this->connected){
      $mqtt->publish($topic, $value, 0, false);
      if ($value=='1') {
        $texto = "El programa comenzó a sincronizar.";
      }elseif ($value=='3') {
        $texto = "El servicio esta siendo reiniciado.";
      }elseif ($value=='4') {
        $texto = "La maquina se esta apagando.";
      }
      $mqtt->close();
    }else {
      $texto="No me fue posible conectarme con el dispositivo que actua sobre la maquina. Ya le envié un correo a soporte";
    }
    return $texto;
  }



}
?>
