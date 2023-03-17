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
    private $host= "localhost";
    private $user= "admin_kyng";
    private $password= "1082846392Kn";
    private $database= "admin_kyng";


// -----------   ------------  AUTENTICACION  ----------------   ---------------------


   public function getCarruselInfo(){
     $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
     if ($conn==false){
       echo "Hubo un problema al conectarse a DB";
       die();
     }
     $sql="SELECT Titulo, Tema, FrasePrincipal, DescripcionCorta, Logo, Background, ColorTitulo, ColorViaja, ColorTexto, ColorBoton FROM ToursInfomation";
     $result = $conn->query($sql);
     $result = $result->fetch_all(MYSQLI_NUM);
     if (count($result)!=0) {
       return $result;
     }else{
       ECHO "None";
     }
     /* liberar la serie de resultados */
    $result->free();

    /* cerrar la conexión */
    $conn->close();
   }

   public function EmailCheck_CMB($mail){
       $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
       if ($conn==false){
         echo "Hubo un problema al conectarse a DB";
         die();
       }
       $result = $conn->query("SELECT * FROM subscribed_emails WHERE Email like '$mail%'");
       $conn=null;
       $users = $result->fetch_all(MYSQLI_ASSOC);
       $count = count($users);
       return $count;
     }

   public function getPersonData($persona){
         $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
         if ($conn==false){
           echo "Hubo un problema al conectarse a DB";
           die();
         }
        if ($persona!=NULL) {
          $result = $conn->query("SELECT * FROM Personas_kyng WHERE User like '$persona'");
          $user = $result->fetch_array(MYSQLI_ASSOC);
          return $user;
        } else {
          $result = $conn->query("SELECT * FROM Personas_kyng");
          $users = $result->fetch_all(MYSQLI_NUM);
          return $users;
        }
         $result->free();
         /* cerrar la conexión */
         $conn->close();
       }


   public function EmailSubscribe_IMX($mail){
       $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
       if ($conn==false){
         echo "Hubo un problema al conectarse a DB";
         die();
       }
       $conn->query("INSERT INTO `subscribed_emails` (`id`, `Email`) VALUES (NULL, '".$mail."')");
       $conn=null;
   }



}

?>
