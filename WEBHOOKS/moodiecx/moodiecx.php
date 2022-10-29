<?php
// -----------------------------------------------------------------------
// ------ Declaro los archivos y las librerias que deseo utilizar --------
// -----------------------------------------------------------------------

include_once "layouts/comunicacion.php";credenciales('mhconcepts','miguel090120');
include("objects/DAO.php");$CON = new DAO();include("objects/ESO.php");$mail = new ESO();include("objects/RMO.php");$PDF = new RMO();include("objects/MQTTO.php");$MQTT = new MQTTO();

$DAYto = array('Monday'=>'Lunes','Tuesday'=>'Martes','Wednesday'=>'Miercoles','Thursday'=>'Jueves',
            'Friday'=>'Viernes','Saturday'=>'Sabado','Sunday'=>'Domingo','Lunes'=>'Monday',
            'Martes'=>'Tuesday','Miercoles'=>'Wednesday','Jueves'=>'Thursday','Viernes'=>'Friday',
            'Sabado'=>'Saturday','Domingo'=>'Sunday','1'=>'Lunes','2'=>'Martes','3'=>'Miercoles','4'=>'Jueves',
            '5'=>'Viernes','6'=>'Sabado','7'=>'Domingo');
$MONTHto = array('January'=>'Enero','February'=>'Febrero','March'=>'Marzo','April'=>'Abril','May'=>'Mayo',
            'June'=>'Junio','July'=>'Julio','August'=>'Agosto','September'=>'Septiembre','October'=>'Octubre',
            'November'=>'Noviembre','December'=>'Diciembre','1'=>'Enero','2'=>'Febrero','3'=>'Marzo',
            '4'=>'Abril','5'=>'Mayo','6'=>'Junio','7'=>'Julio','8'=>'Agosto','9'=>'Septiembre',
            '10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre');

$dt1=new DateTime(date("Y-m-d H:i:s P"));
$dt1->modify("-5 hours");
$fecha=$dt1->format('Y-m-d');









// -------------------------------------- Identifiacion de donde proviene -----------------------------------
$P=0;
$userPersonal="";
$userGroup="";
$plataforma = origen();

if ($plataforma == "TELEGRAM") {
  $info_group = $CON->getInfoTelegram(TelegramIdGroup(),false);
  $info_user= $CON->getInfoTelegram(TelegramIdPersonal(),true);
  if ($info_user!='None') {
    $userPersonal = $info_user['user'];
    $user_Email = $info_user['email'];
    $P=1;
  }

  if ($info_group!='None') {
    $userGroup = $info_group['user'];
    $user_Email = $info_group['email'];
    $P=1;
  }
  if ($info_group=='None' AND $info_user=='None'){
    $user_Email = "None";
  }


}elseif ($plataforma == "DIALOGFLOW_CONSOLE") {
  $info_user = $CON->getInfoPage("data_calima","1");
  if ($info_user!='None') {
    $userGroup = $info_user['user'];
    $user_Email = $info_user['email'];
    $P = $info_user['auth'];
  }else {
    $user_Email = "None";
  }
  $P=1;

  enviar_texto("Info ".$userGroup);
}elseif ($plataforma == "FACEBOOK") {
  enviar_texto("Aun no tenemos habilitada la plataforma FACEBOOK");


}elseif ($plataforma == "WHATSAPP") {
  $info_user = $CON->getInfoWhatsapp(whatsappNumber());
  if ($info_user!='None') {
    $userGroup = $info_user['user'];
    $user_Email = $info_user['email'];
    $P = $info_user['auth'];
  }else {
    $user_Email = "None";
  }
  $P=1;



}elseif ($plataforma != "noPage") {
  $info=getInfoPage();
  $Table = $info['1'];
  $user_id = $info['2'];
  $info_user= $CON->getInfoPage($Table,$user_id);
  if ($info_user!='None') {
    $userGroup = $info_user['user'];
    $user_Email = $info_user['email'];
    $P = $info_user['auth'];
  }else {
    $user_Email = "None";
  }


}else {
  $user_Email="None";
}


if ($user_Email=='None') {
  enviar_texto("No estas autorizado para realizarme esta clase de consultas");
}





// --------------------------------------  CONTROL TOTEMS -----------------------------------

if (intent_recibido("xian.greetings.hello")){
  enviar_texto("Informacion hola del grupo: ".TelegramIdGroup()."\n Informacion personal: " .TelegramIdPersonal());
  }


if (intent_recibido("xian_moodie_controlesTotems")){

  if ($CON->info_totems($userPersonal,$userGroup)!= "None") {
    maquinasControl($CON->info_totems($userPersonal,$userGroup));
  }else {
    enviar_texto("No tienes totems asignados");
  }

}
if (intent_recibido("xian_moodie_controlesTotems_options")){
  controlEspecifico($CON->info_totems($userPersonal,$userGroup,obtener_variables()['totem']));
}
if (intent_recibido("xian_moodie_controlesTotems_options-TV")){
  $totem = obtener_variables()['totem'];
  $state = obtener_variables()['estados'];
  $totems = $CON->info_totems($userPersonal,$userGroup,$totem);
  if ($totems['0']['2']=='Online') {
    if ($totems['0']['3']=='TV/OFF' AND $state=='on') {$text = $MQTT->TV($state,$totems['0']['1']);enviar_texto($text);}
    elseif ($totems['0']['3']=='TV/OFF' AND $state=='off') {enviar_texto("La pantalla del Totem ya esta apagada");}
    elseif ($totems['0']['3']=='TV/ON' AND $state=='on') {enviar_texto("La pantalla del Totem ya esta Encendida");}
    elseif ($totems['0']['3']=='TV/ON' AND $state=='off') {$text = $MQTT->TV($state,$totems['0']['1']);enviar_texto($text);}
    else {enviar_texto("No he podido saber el estado del TV del totem: $totem");}
  }
  elseif ($totems['0']['2']=='Offline') {enviar_texto("Este totem esta offline");}
  else {enviar_texto("No tengo la informacion necesaria para generar una accion en el TV");}
}
if (intent_recibido("xian_moodie_controlesTotems_options_apagar")){
  $totem = obtener_variables()['totem'];
  $totems = $CON->info_totems($userPersonal,$userGroup,$totem);
  if ($totems['0']['2']=='Online') {$text = $MQTT->send_topic($totems['0']['1'],'4');enviar_texto($text);}
  elseif ($totems['0']['2']=='Offline') {enviar_texto("Este totem esta offline");}
  else {enviar_texto("No tengo la informacion necesaria para apagar el totem");}
}
if (intent_recibido("xian_moodie_controlesTotems_options_sincronizar")){
  $totem = obtener_variables()['totem'];
  $totems = $CON->info_totems($userPersonal,$userGroup,$totem);
  if ($totems['0']['2']=='Online') {$text = $MQTT->send_topic($totems['0']['1'],'1');enviar_texto($text);}
  elseif ($totems['0']['2']=='Offline') {enviar_texto("Este totem esta offline");}
  else {enviar_texto("No tengo la informacion necesaria para Sincronizar el totem");}
}
if (intent_recibido("xian_moodie_controlesTotems_options-restart")){
  $totem = obtener_variables()['totem'];
  $totems = $CON->info_totems($userPersonal,$userGroup,$totem);
  if ($totems['0']['2']=='Online') {$text = $MQTT->send_topic($totems['0']['1'],'3');enviar_texto($text);}
  elseif ($totems['0']['2']=='Offline') {enviar_texto("Este totem esta offline");}
  else {enviar_texto("No tengo la informacion necesaria para Reiniciarlo el totem");}
}



// --------------------------------------  CONSULTA DB -----------------------------------
if (intent_recibido("xian_moodie_N-Puntos") and $P==1){
  $CC=obtener_variables()['Centro_Comercial'];
  $Puntos=$CON->N_Puntos_CDA();
  $NPuntos=count($Puntos);
  if($NPuntos!=0){
    enviar_texto("En el centro comercial Calima Armenia hay $NPuntos puntos de calificacion MOODIE. \n\n ¿Deseas saber cuales son?");
  }
}

if (intent_recibido("N_Puntos_confirmado") and $P==1){
  $CC=obtener_variables()['Centro_Comercial'];
  $Puntos=$CON->N_Puntos_CDA();
  $text = "Los puntos de calificacion son: \n\n";
  for ($i=0; $i < count($Puntos); $i++) {
    $n=$i+1;
    $text = $text . $n . ". ".$Puntos[$i]['0'].".\n";
  }
  enviar_texto($text);
}

if (intent_recibido("xian_moodie_promedio-dia")){
  $dia=obtener_variables()['day'];
  $porcentaje = $CON->Promedio_dia_CDN($DIA[$dia]);
  if($porcentaje!=0){
    enviar_texto("El puntaje promedio del $dia de acuerdo a la votación histórica es de $porcentaje%");
  }else {
    enviar_texto("El dia $dia no ha tenido un registro de Votos");
  }
}


// --------------------------------------  CONCLUSIONES -----------------------------------

if (intent_recibido("xian_moodie_mejor_peor-all") and $P==1){
  $conclucionesTipo=obtener_variables()['conclusiones_tipo'];
  $mejorPeor=obtener_variables()['mejor_peor'];
  if ($mejorPeor=='mejor') {$orden="DESC";}elseif($mejorPeor=='peor'){$orden="ASC";}
  $result = $CON->BestWorstDM_CDA($conclucionesTipo,$orden);
  if ($conclucionesTipo=='hora') {
    enviar_texto("La $mejorPeor $conclucionesTipo es las ".$result['0']['0'].":00 con un porcentaje historico del ".$result['0']['1']."%.");
  }elseif ($conclucionesTipo=='dia') {
    enviar_texto("El $mejorPeor $conclucionesTipo es el ".$DAYto[$result['0']['0']]." con un porcentahe historico del ".$result['0']['1']."%.");
  }elseif ($conclucionesTipo=='mes') {
    enviar_texto("El $mejorPeor $conclucionesTipo es el ".$MONTHto[$result['0']['0']]." con un porcentahe historico del ".$result['0']['1']."%.");
  }elseif ($conclucionesTipo=='año' OR $conclucionesTipo=='punto') {
    enviar_texto("El $mejorPeor $conclucionesTipo es el ".$result['0']['0']." con un porcentahe historico del ".$result['0']['1']."%.");
  }else {
    enviar_texto("No tengo la informacion suficiente para darte una respuesta, por favor vuelve a intentarlo.");
  }
}


// --------------------------------- Generacion y Consulta de Reportes -----------------------------------
if ($P==1) {
  if (intent_recibido("xian_moodie_informe")){tipoInformeGE();}

  //   ------  Informe GENERAL  --------

  if (intent_recibido("xian_moodie_informe_tiempo")){tipoInformeTime();}

  if (intent_recibido("xian_moodie_informe_tiempo_result")){
      $OR = obtener_variables()['OR'];
      $OT = obtener_variables()['reportTime'];
      $RP = '';
      $fechas_max_min = $CON->fecha_max_min($RP);
      if ($OT=="Hoy") {
        enviar_texto("Te voy a enviar reporte $OR de Hoy $fecha");
      }elseif ($OT=="Diario" OR $OT=="Mes" OR $OT=="Año") {
        $text="Indica el año del reporte";
        $n=0;
        for ($i=intval(substr($fechas_max_min['0'],0,-6)); $i <= intval(substr($fechas_max_min['1'],0,-6)) ; $i++) {
          $years[$n] = [$i];
          $n++;
        }
        tipoInformeList($text,$years);
      }elseif ($OT=="Historico") {
        enviar_texto("Te voy a enviar reporte $OR Historico");
      }
  }

  if (intent_recibido("xian_moodie_informe_tiempo_month")){
      $OR = 'General';
      $OT = obtener_variables()['reportTime'];
      $RP = '';
      $year = obtener_variables()['year'];
      $fechas_max_min = $CON->fecha_max_min($RP,$year);
      if($fechas_max_min==''){
        enviar_texto("No tengo registros del año $year");
      }
      if ($OT=="Hoy" OR $OT=="Historico") {
        enviar_texto(" Preguntame por la cantidad de puntos moodie. ");
      }elseif ($OT=="Diario" OR $OT=="Mes") {
        $text="Indica el mes para el reporte";
        $n=0;
        for ($i=intval(substr($fechas_max_min['0'],5,-3)); $i <= intval(substr($fechas_max_min['1'],5,-3)) ; $i++) {
          $months[$n] = [$MONTHto[$i]];
          $n++;
        }
        tipoInformeList($text,$months);
      }elseif ($OT=="Año") {
        enviar_texto("Te voy a enviar reporte general del año $year");
      }
  }

  if (intent_recibido("xian_moodie_informe_tiempo_day")){
      $OR = 'General';
      $OT = obtener_variables()['reportTime'];
      $RP = '';
      $year = obtener_variables()['year'];
      $month = obtener_variables()['month'];
      $fechas_max_min = $CON->fecha_max_min($RP,$year,$month);
      if($fechas_max_min==''){
        enviar_texto("No tengo registros del mes ".$MONTHto[$month]." del año $year");
      }
      if ($OT=="Hoy" OR $OT=="Historico" OR $OT=="Año") {
        enviar_texto(" Preguntame por la cantidad de puntos moodie. ");
      }elseif ($OT=="Diario") {
        enviar_texto("Ingresa un dia del mes en el siguiente intervalo: \n [ ".substr($fechas_max_min['0'],8,10)." - ".substr($fechas_max_min['1'],8,10)." ]");
      }elseif ($OT=="Mes") {
        enviar_texto("Te voy a enviar reporte general para el mes ".$MONTHto[$month]." del año $year");
      }
  }

  if (intent_recibido("xian_moodie_informe_tiempo_send")){
      $OR = 'General';
      $OT = obtener_variables()['reportTime'];
      $RP = '';
      $year = obtener_variables()['year'];
      $month = obtener_variables()['month'];
      $day = obtener_variables()['day'];

      $fechas_max_min = $CON->fecha_max_min($RP,$year,$month,$day);
      if($fechas_max_min==''){
        enviar_texto("No tengo registros del dia $day del mes ".$MONTHto[$month]." del año $year");
      }
      if ($OT=="Hoy" OR $OT=="Historico" OR $OT=="Año" OR $OT=="Mes") {
        enviar_texto(" Preguntame por la cantidad de puntos moodie. ");
      }elseif ($OT=="Diario") {
        enviar_texto("Te voy a enviar reporte general para el dia $day del mes de ".$MONTHto[$month]." del año $year");
      }
  }


  //   ------  Informe ESPECIFICO  --------

  if (intent_recibido("xian_moodie_informe_especifico")){
    $text="Elige el punto para el informe";
    $puntos = $CON->N_Puntos_CDA();
    tipoInformeList($text,$puntos);
  }

  if (intent_recibido("xian_moodie_informe_especifico_tiempo")){
    tipoInformeTime();
  }

  if (intent_recibido("xian_moodie_informe_especifico_year")){
      $OR = "Especifico";
      $OT = obtener_variables()['reportTime'];
      $RP = obtener_variables()['puntos_calificacion'];;
      $fechas_max_min = $CON->fecha_max_min($RP);
      if ($OT=="Hoy") {
        enviar_texto("Te voy a enviar reporte $OR de Hoy $fecha del $RP");
      }elseif ($OT=="Diario" OR $OT=="Mes" OR $OT=="Año") {
        $text="Indica el año del reporte";
        $n=0;
        for ($i=intval(substr($fechas_max_min['0'],0,-6)); $i <= intval(substr($fechas_max_min['1'],0,-6)) ; $i++) {
          $years[$n] = [$i];
          $n++;
        }
        tipoInformeList($text,$years);
      }elseif ($OT=="Historico") {
        enviar_texto("Te voy a enviar reporte $OR Historico");
      }
  }

  if (intent_recibido("xian_moodie_informe_especifico_month")){
      $OT = obtener_variables()['reportTime'];
      $OR = obtener_variables()['OR'];
      $RP = obtener_variables()['puntos_calificacion'];
      $year = obtener_variables()['year'];
      $fechas_max_min = $CON->fecha_max_min($RP,$year);
      if($fechas_max_min==''){
        enviar_texto("No tengo registros del año $year");
      }
      if ($OT=="Hoy" OR $OT=="Historico") {
        enviar_texto(" Preguntame por la cantidad de puntos moodie. ");
      }elseif ($OT=="Diario" OR $OT=="Mes") {
        $text="Indica el mes para el reporte";
        $n=0;
        for ($i=intval(substr($fechas_max_min['0'],5,-3)); $i <= intval(substr($fechas_max_min['1'],5,-3)) ; $i++) {
          $months[$n] = [$MONTHto[$i]];
          $n++;
        }
        tipoInformeList($text,$months);
      }elseif ($OT=="Año") {
        enviar_texto("Te voy a enviar reporte $OR del año $year del $RP");
      }
  }

  if (intent_recibido("xian_moodie_informe_especifico_day")){
      $OR = obtener_variables()['OR'];
      $OT = obtener_variables()['reportTime'];
      $RP = obtener_variables()['puntos_calificacion'];
      $year = obtener_variables()['year'];
      $month = obtener_variables()['month'];
      $fechas_max_min = $CON->fecha_max_min($RP,$year,$month);
      if($fechas_max_min==''){
        enviar_texto("No tengo registros del mes ".$MONTHto[$month]." del año $year");
      }
      if ($OT=="Hoy" OR $OT=="Historico" OR $OT=="Año") {
        enviar_texto(" Preguntame por la cantidad de puntos moodie. ");
      }elseif ($OT=="Diario") {
        enviar_texto("Ingresa un dia del mes en el siguiente intervalo: \n [ ".substr($fechas_max_min['0'],8,10)." - ".substr($fechas_max_min['1'],8,10)." ]");
      }elseif ($OT=="Mes") {
        enviar_texto("Te voy a enviar reporte $OR para el mes ".$MONTHto[$month]." del año $year de $RP");
      }
  }

  if (intent_recibido("xian_moodie_informe_especifico_send")){
      $OR = obtener_variables()['OR'];
      $OT = obtener_variables()['reportTime'];
      $RP = obtener_variables()['puntos_calificacion'];
      $year = obtener_variables()['year'];
      $month = obtener_variables()['month'];
      $day = obtener_variables()['day'];

      $fechas_max_min = $CON->fecha_max_min($RP,$year,$month,$day);
      if($fechas_max_min==''){
        enviar_texto("No tengo registros del dia $day del mes ".$MONTHto[$month]." del año $year");
      }
      if ($OT=="Hoy" OR $OT=="Historico" OR $OT=="Año" OR $OT=="Mes") {
        enviar_texto(" Preguntame por la cantidad de puntos moodie. ");
      }elseif ($OT=="Diario") {
        enviar_texto("Te voy a enviar reporte $OR para el dia $day del mes de ".$MONTHto[$month]." del año $year de $RP");
      }
  }
}else {
  enviar_texto("No tienes autorizacion para generar reportes.");
}

?>
