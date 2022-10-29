<?php
//------            DAO (Data Access Object) Objeto de Acceso de Datos                  ------------
/*
DAO es un objeto que nos va a permitir generar la interaccion con la base datos (DB).

En este caso especifico, este Objeto solo tiene metodos (funciones) que van a permitir consultar,
actualizar e insertar Datos de nuestra DB.

Asi se podra tener separada la logica del programa con las acciones de acceso de datos o conexiones.

Cada metodo (ó Funcion) tendra un breve comentario antes de cada uno y llevara cierta nomenclatura que se
describe a continuacion:


Existiran diferentes tipos de metodos.

1.  Metodo general
    Generalmente recibe informacion a procesar, y esta se encarga se organizarla y de llamar algunos metodos
    especificos. el metodo general, puede llegar a llamar muchos metodos especificos.

    la nomenclatura de los metodos generales consta de un nombre que identifica la accion seguido por un guion
    y finalmente un digito que identifia el archivo al cual genera la accion.
        ejemplo:
        NombreDeAccion_W

    Los digitos para cada archivo son los siguientes:
    C   ->  control de acceso
    D   ->  Datos usuario
    L   ->  Login



2.  Metodo especifico
    Es una funcion que genera una tarea determinada, la cual hace una accion sobre la base de datos, ya sea
    llamar los datos de una tabla, actualizarlos o insertar los datos. En la mayoria de los casos retorna un
    dato especificado.

    la nomenclatura de los metodos especificos consta de un nombre que identifica la accion seguido por un
    guion y finalmente 3 digitos que resaltan las especifiaciones del metodo:
        ejemplo:
        NombreDeAccion_COA

El primer digito despues del guion bajo, del nombre identifica la accion del metodo:
    C   ->  Consulta Datos
    A   ->  Actualiza Datos
    I   ->  Inserta Datos
    _   ->  se iniciara con un guion bajo si el metodo no realiza ninfuna de las acciones anteriores.
            sin embargo, en los comentarios del metodo debe especificarse su funcion.

El segundo digito va a ser una letra si solo se afecta una tabla poniendose la inicial de esta, pero
si afecta mas de una tabla se pone el numero de tablas que afecta y se especifican en los comentarios y
si no afecta ninguna tabla se pone un _.
    D   ->  data_calima
    X   ->  La tabla es variable.
    _   ->  No afecta ninguna tabla.

El tercer digito identifica el tipo de dato que va a retornar:
    N   ->  Number
    B   ->  BARCHAR
    A   ->  ARRAY
    O   ->  OBJECT
    X   ->  No retorna nada

*/



class DAO{
    private $host= "18.229.81.216";
    private $user= "admin_mhconcepts";
    private $password= "Nickisito1";
    private $database= "admin_mhconcepts";
    private $Table="";

// -----------   ------------  AUTENTICACION  ----------------   ---------------------



   public function getInfoPage($Table,$user_id){
     $this->Table = $Table;
     $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
     if ($conn==false){
       echo "Hubo un problema al conectarse a DB";
       die();
     }
     $sql="SELECT DISTINCT users_email AS email, users_name AS name, auth AS auth, user AS user FROM users_md WHERE users_database='$this->Table' AND users_id='$user_id'";
     $result = $conn->query($sql);
     $result = $result->fetch_assoc();
     if ($result!=0) {
       return $result;
     }else{
       return "None";
     }
   }


   public function getInfoWhatsapp($number){
    $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
    if ($conn==false){
      echo "Hubo un problema al conectarse a DB";
      die();}
    /*
    SELECT users_md.USER, users_md.users_email, devices_sm.devices_name
    FROM users_md
    left join devices_sm on devices_sm.Owner like CONCAT('%',users_md.USER,'%')
    */
    $result = $conn->query("SELECT DISTINCT users_email AS email, users_database AS tabla, user AS user, auth AS auth FROM users_md WHERE users_cellphone='$number'");
    $result = $result->fetch_assoc();
    if($result!=0) {
      $this->Table=$result['tabla'];
      return $result;
    }else {
      $result = $conn->query("SELECT DISTINCT users_email AS email, user AS user, auth AS auth FROM users_sm WHERE users_cellphone='$number'");
      $result = $result->fetch_assoc();
      if ($result!=0) {
        return $result;
      }else {
        $result = $conn->query("SELECT DISTINCT users_email AS email, user AS user FROM users_mh WHERE users_cellphone='$number'");
        $result = $result->fetch_assoc();
        if ($result!=0) {
          return $result;
        }else{
          return "None";
        }
      }
    }
  }


   public function getInfoTelegram($telegramId,$personal){

    if ($personal) {
      $cod = " WHERE TelegramIdPersonal='$telegramId' ";
    } else {
      $cod = " WHERE TelegramIdGroup='$telegramId' ";
    }

    $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
    if ($conn==false){
      echo "Hubo un problema al conectarse a DB";
      die();}
    /*
    SELECT users_md.USER, users_md.users_email, devices_sm.devices_name
    FROM users_md
    left join devices_sm on devices_sm.Owner like CONCAT('%',users_md.USER,'%')
    */
    $result = $conn->query("SELECT DISTINCT users_email AS email, users_database AS tabla, user AS user, auth AS auth FROM users_md $cod");
    $result = $result->fetch_assoc();
    if($result!=0) {
      $this->Table=$result['tabla'];
      return $result;
    }else {
      $result = $conn->query("SELECT DISTINCT users_email AS email, user AS user, auth AS auth FROM users_sm $cod");
      $result = $result->fetch_assoc();
      if ($result!=0) {
        return $result;
      }else {
        $result = $conn->query("SELECT DISTINCT users_email AS email, user AS user FROM users_mh $cod");
        $result = $result->fetch_assoc();
        if ($result!=0) {
          return $result;
        }else{
          return "None";
        }
      }
    }
  }


// --------------------------------------   Consultas para Control de Maquinas -----------------------------------

    public function info_totems($userPersonal='',$userGroup='',$totem=''){

      $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
      if ($conn==false){
        echo "Hubo un problema al conectarse a DB";
        die();}


        if ($userPersonal!='' AND $userGroup!='') {
          $cod = " WHERE (Owner LIKE '%$userPersonal%' OR Owner LIKE '%$userGroup%') ";
        } elseif ($userPersonal!='' AND $userGroup=='') {
          $cod = " WHERE (Owner LIKE '%$userPersonal%') ";
        } elseif ($userPersonal=='' AND $userGroup!=''){
          $cod = " WHERE (Owner LIKE '%$userGroup%') ";
        }

        if ($totem!='') {
          $cod = $cod . " AND devices_name = '$totem'";
        }

           //
      $sql = "SELECT devices_name, devices_topic, devices_state, devices_screen, devices_location FROM devices_sm $cod";
      $totems = $conn->query($sql);
      $totems = $totems->fetch_all(MYSQLI_NUM);
      $conn=null;
      if(count($totems)!=0) {
        return $totems;
      }else {
        return "None";
      }
    }

// --------------------------------------   Consultas para DialogFlow -----------------------------------


  public function prueba($telegram_id){
    $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
    if ($conn==false){
      echo "Hubo un problema al conectarse a DB";
      die();}
    $result = $conn->query("SELECT DISTINCT users_email AS email, users_name AS name, users_database AS tabla, auth AS auth FROM users_md WHERE Telegram_Group='$telegram_id'");
    $result = $result->fetch_assoc();
    if($result!=0) {
      $this->Table=$result['tabla'];
      return $result;
    }else {
      $result = $conn->query("SELECT DISTINCT users_email AS email, users_name AS name, auth AS auth FROM users_sm WHERE Telegram_Group='$telegram_id'");
      $result = $result->fetch_assoc();
      if ($result!=0) {
        return $result;
      }else {
        return "None";
      }

    }
  }

  /*****************************************************************************
  ****************************** Conclusiones **********************************
  ******************************************************************************/
  public function BestWorstDM_CDA($conclusiones,$orden){
      $result=0;
      $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
      if ($conn==false){
        echo "Hubo un problema al conectarse a DB";
        die();
      }
      if ($conclusiones=="punto") {
        //SELECT data_location AS locacion, ROUND((AVG(data_value)*2*10),2) AS Promedio, (SELECT devices_name FROM devices_md WHERE devices_topic=data_calima.data_location) AS moodie FROM data_calima GROUP BY locacion ORDER BY promedio DESC LIMIT 1
        $sql = "SELECT (SELECT devices_name FROM devices_md WHERE devices_topic=$this->Table.data_location) AS moodie, ROUND((AVG(data_value)*2*10),1) AS promedio, data_location as LOCATION FROM $this->Table GROUP BY LOCATION ORDER BY PROMEDIO $orden LIMIT 1";
      }elseif($conclusiones=="hora"){
        $sql = "SELECT HOUR(data_time) AS Hora, ROUND((AVG(data_value)*2*10),2) AS Promedio, SUM(data_value) AS cuenta FROM $this->Table  WHERE HOUR(data_time) BETWEEN 5 AND 23  GROUP BY Hora ORDER BY cuenta $orden LIMIT 1;";
      }elseif($conclusiones=="dia"){
        $sql = "SELECT DAYNAME(data_time) as DIA, ROUND((AVG(data_value)*2*10),1) AS promedio FROM $this->Table GROUP BY DIA ORDER BY promedio $orden;";
      }elseif ($conclusiones=="mes") {
        $sql = "SELECT MONTHNAME(data_time) as MES, ROUND((AVG(data_value)*2*10),1) AS promedio FROM $this->Table GROUP BY MES ORDER BY promedio $orden;";
      }elseif ($conclusiones=="año") {
        $sql = "SELECT YEAR(data_time) as YEAR, ROUND((AVG(data_value)*2*10),1) AS promedio FROM $this->Table GROUP BY YEAR ORDER BY promedio $orden;";
      }
      $mejor_dia_semana = $conn->query($sql);
      $conn=null;
      $mejor_dia_semana = $mejor_dia_semana->fetch_all(MYSQLI_NUM);
      if(count($mejor_dia_semana)!=0){
        $result=$mejor_dia_semana;
      }
      return $result;}





  /*  Promedio_dia_CDN
  El siguiente metodo recibe un parametro 'dia'(Un dia de la semana en español), y con este dato realiza
  una consulta en la Base de Datos de todas las botaciones que han ocurrido en ese dia y retorna
  el promedio del dia.
  El metodo retorna un numero, que representa el promedio de las votaciones existentes en las bases de Datos
  correspondientes al parametro 'dia'. */
  public function Promedio_dia_CDN($dia){
      $result=0;
      $DAY='';
      $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
      if ($conn==false){
        echo "Hubo un problema al conectarse a DB";
        die();
      }

      $dia_semana = $conn->query("SELECT DAYNAME(data_time) as DIA, ROUND((AVG(data_value)*2*10),1) AS promedio FROM $this->Table WHERE DAYNAME(data_time)='$dia' GROUP BY dia ORDER BY DIA DESC;");
      $conn=null;
      $dia_semana = $dia_semana->fetch_all(MYSQLI_NUM);
      if(count($dia_semana)!=0) {
        $result=$dia_semana['0']['1'];
      }
      return $result;}



/*  AllPoints_CPA
    El siguiente metodo.*/
    public function N_Puntos_CDA(){
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        if ($conn==false){
          echo "Hubo un problema al conectarse a DB";
          die();
        }
        $points = $conn->query("SELECT DISTINCT devices_md.devices_name AS Moodie FROM $this->Table, devices_md WHERE data_calima.data_location = devices_md.devices_topic;");
        $conn=null;
        $result = $points->fetch_all(MYSQLI_NUM);
        return $result;
      }

    //
    public function N_votos_punto($punto){
        $result=0;
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        if ($conn==false){
          echo "Hubo un problema al conectarse a DB";
          die();
        }
        $point_info = $conn->query("SELECT (SELECT devices_name FROM devices_md WHERE devices_topic=$this->Table.data_location) AS moodie , COUNT(*) as votos FROM $this->Table WHERE data_location LIKE '$punto' GROUP BY moodie");
        $conn=null;
        $point_info = $point_info->fetch_all(MYSQLI_NUM);
        return $point_info;
      }

    public function Porcentaje_Punto_CDA($punto){
        $result=0;
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        if ($conn==false){
          echo "Hubo un problema al conectarse a DB";
          die();}
        $punto = "salida1";
        $Best_point = $conn->query("SELECT data_location as LOCATION, ROUND((AVG(data_value)*2*10),1) AS promedio, (SELECT devices_name FROM devices_md WHERE devices_topic=$this->Table.data_location) AS moodie  FROM $this->Table WHERE data_location='$punto' GROUP BY LOCATION");
        $conn=null;
        $Best_point = $Best_point->fetch_all(MYSQLI_NUM);
        $result=$Best_point;
        return $result;
      }

// ok Base de Datos Limpia


//    ------------------------------    CONSULTAS PARA REPORTES -----------------------

    public function fecha_max_min($RP='',$year='',$month='',$day=''){
      $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
      if ($conn==false){
        echo "Hubo un problema al conectarse a DB";
        die();}
      $cod="";

      if ($RP!='') {
        $cod=$cod . " WHERE data_location='$RP' ";
      }

      if($year!=''){
        if ($RP!='') {
          $cod=$cod . " AND";
        }else {
          $cod=$cod . " WHERE";
        }
        $cod=$cod . " YEAR(data_time)=$year ";
        if ($month!='') {
          $cod=$cod . "AND MONTH(data_time)=$month ";
          if ($day!='') {
            $cod=$cod . "AND DAY(data_time)=$day ";
          }
        }
      }
      $VAR = array('ASC','DESC');
      $i=0;
      foreach ($VAR as $value) {
        $CONSULT = $conn->query("SELECT DISTINCT date(data_time) FROM $this->Table $cod ORDER BY date(data_time) $value;");
        $CONSULT = $CONSULT->fetch_all(MYSQLI_NUM);
        if(count($CONSULT)!=0){
          $DATE[$i]=$CONSULT['0']['0'];
          $i++;
        }else {
          $DATE = '';
        }
      }
      return $DATE;
    }


    public function grafica_hora(){
      $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
      if ($conn==false){
        echo "Hubo un problema al conectarse a DB";
        die();}
        foreach (range(5, 23) as $i) {
          $sql = "SELECT HOUR(data_time) AS Hora, ROUND((AVG(data_value)*2*10),2) AS Promedio, SUM(data_value) AS cuenta FROM $this->Table WHERE HOUR(data_time)=$i GROUP BY Hora;";
          $hora_grafica = $conn->query($sql);
          $hora_grafica = $hora_grafica->fetch_all(MYSQLI_NUM);
          $j=$i-5;
          $result_grafica[$j]['0'] =$i;
          if(count($hora_grafica)!= 0){
              $result_grafica[$j]['1'] =$hora_grafica['0']['2'];
          }else{
              $result_grafica[$j]['1'] = 0;
          }
        }
      return $result_grafica;
    }

}

?>
