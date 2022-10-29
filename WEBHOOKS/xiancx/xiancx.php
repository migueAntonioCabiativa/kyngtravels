<?php
// -----------------------------------------------------------------------
// ------ Declaro los archivos y las librerias que deseo utilizar --------
// -----------------------------------------------------------------------
include_once "layouts/comunicacion.php";credenciales('xianbotcx','miguel090120');

// Importo el archivo DAO y  Creo el objeto llamado CON que proviene del archivo DAO
include("objects/DAO.php");$CON = new DAO();

// TRAMO DE CODIGO QUE DETECTA DESDE QUE PLATAFORMA SE ESTA ESCRIBIENDO Y DA PERMISOS DEPENDIENDO DE LA PLATAFORMA
$Plataforma = origen();
if($Plataforma=="TELEGRAM"){

}elseif ($Plataforma=="DIALOGFLOW_CONSOLE") {
  $device = $CON->GetInfoDevice('indexKyngtravels');
  enviar_texto($device['devices_topic']);
}elseif ($Plataforma=="FACEBOOK") {
  // code...
}elseif ($Plataforma=="WHATSAPP") {
  // code...
}elseif ($Plataforma=="NoPage") {
  enviar_texto("La plataforma desde la que me has escrito no la reconozco. Por favor, ponte en contacto con soporte.");
}else {
  $device = $CON->GetInfoDevice($Plataforma);
  if(count($device)!=0){
    $Calificador=1;
  }else {
    enviar_texto("El calificador $Plataforma, no esta registrado en MoodieCX. Por favor ponerse en contacto con Soporte o con su asesor.");
  }
}





function sendMessage($chatID, $messaggio, $token) {
    $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chatID;
    $url = $url . "&text=" . urlencode($messaggio);
    $ch = curl_init();
    $optArray = array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true
    );
    curl_setopt_array($ch, $optArray);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


// --------------------------------------  Envio de imagenes -----------------------------------

if (intent_recibido("imagen")){
  $imagenes[0]="https://definicionyque.es/wp-content/uploads/2018/10/IMAGEN-_PUBLICITARIA.jpg";
  $imagenes[1]="https://i.blogs.es/594843/chrome/450_1000.jpg";
  $plataforma="web";
  $text="hola";
  enviar_imagenes($text,$imagenes,$plataforma);
}

// ------------------------------------  Calificacion del servicio ----------------------------------





if (intent_recibido("Mensaje_inicial")){
  calificacion(utf8_encode($device['devices_pregunta']));
}

if (intent_recibido("select_number")){
  $calificacion=obtener_variables()['calificacion'];
  if($calificacion>='1' and $calificacion<='5'){
    $CON->calificacion_IXN($device['devices_topic'],$device['devices_database'],$calificacion);
  }
  // Token que conecta el webhook con un grupo de telegram
  $token='1835208847:AAGyNIT1kNaCv_T-jKR8l5E3Ds8XThxbrPs';
  if($calificacion=='1'){
    $telegram_text="Alerta❗️ Calificación Negativa 😡 en ".$device['devices_name']." ⚠️";
    sendMessage($device['devices_notifications'], $telegram_text, $token);
    $text=utf8_encode($device['devices_respuesta1']);
  }elseif ($calificacion=='2') {
    $telegram_text="Alerta❗️ Calificación Regular 😕 en ".$device['devices_name']." ⚠️";
    sendMessage($device['devices_notifications'], $telegram_text, $token);
    $text=utf8_encode($device['devices_respuesta2']);
  }elseif ($calificacion=='3') {
    $text=utf8_encode($device['devices_respuesta3']);
  }elseif ($calificacion=='4') {
    $text=utf8_encode($device['devices_respuesta4']);
  }elseif ($calificacion=='5') {
    $text=utf8_encode($device['devices_respuesta5']);
  }else {
    $text="Tu calificacion no fué valida";
  }
  $text = $text . "\n \n ¿Te gustaría dejar un comentario?";
  enviar_texto_y_siono($text,$device['devices_comentarios']);
}




if (intent_recibido("xiancx_user_origen")){
  $user=origen();
  if($user=='FACEBOOK' or $user=='TELEGRAM'){
    enviar_texto("Me estas escribiendo de la plataforma $user.");
  }else{
    enviar_texto("Me estas escribiendo de la pagina registrada como $user.");
  }
}


// --------------------------------------  Envio de imagenes -----------------------------------

if (intent_recibido("tarjeta")){
  $imagenes[0]="https://definicionyque.es/wp-content/uploads/2018/10/IMAGEN-_PUBLICITARIA.jpg";
  $imagenes[1]="https://i.blogs.es/594843/chrome/450_1000.jpg";
  $plataforma="web";
  $text="";
  enviar_imagenes($text,$imagenes,$plataforma);
}

// --------------------------------------  CONSULTA DB -----------------------------------
?>
