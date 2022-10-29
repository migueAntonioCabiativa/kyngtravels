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
    M   ->  devices_md
    U   ->  users_md
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
    private $DB="data_calima";
    /*  Promedio_dia_CDN
        El siguiente metodo recibe un parametro 'dia'(Un dia de la semana en español), y con este dato realiza
        una consulta en la Base de Datos de todas las botaciones que han ocurrido en ese dia y retorna
        el promedio del dia.
        El metodo retorna un numero, que representa el promedio de las votaciones existentes en las bases de Datos
        correspondientes al parametro 'dia'. */

// --------------------------------------   Consultas para confirmacion de calificacion -----------------------------------




public function GetInfoDevice($device_topic){
  $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
  if ($conn==false){
    echo "Hubo un problema al conectarse a DB";
    die();
  }
  $sql="SELECT * FROM devices_md WHERE devices_topic LIKE '$device_topic'";
  $result = $conn->query($sql);
  $result = $result->fetch_assoc();
  if ($result!=0) {
    return $result;
  }else{
    return "None";
  }
}


// la siguiente funcion inserta los datos de posicion de un moodie y la calificacion que recibio en una tabla variables
// de la base de datos admin_mhconcepts.
      public function calificacion_IXN($user,$database_md,$value){
          $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
          if ($conn==false){die();}
          $sql ="INSERT INTO admin_mhconcepts.$database_md (data_location,data_value) VALUES ('$user', '$value')";
          if (!(mysqli_query($conn, $sql))) {echo "Error: " . $sql . "<br>" . mysqli_error($conn);}
          mysqli_close($conn);
          $conn=null;
        }
//    ------------------------------    CONSULTAS PARA REPORTES -----------------------
}

?>
