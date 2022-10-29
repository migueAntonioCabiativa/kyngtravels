<?php
$usuario_recibido   = $_SERVER['PHP_AUTH_USER'];
$pass_recibido      = $_SERVER['PHP_AUTH_PW'];
$inputJSON          = file_get_contents('php://input');
$input              = json_decode($inputJSON, TRUE);
$respuesta          = "";
$respuesta_texto    = "";
$respuesta_cards[]  = array();
$respuesta_images[] = array();
header('Content-Type: application/json;charset=utf-8');

/*
_______  _______  _______ _________ ______  _________ _______
(  ____ )(  ____ \(  ____ \\__   __/(  ___ \ \__   __/(  ____ )
| (    )|| (    \/| (    \/   ) (   | (   ) )   ) (   | (    )|
| (____)|| (__    | |         | |   | (__/ /    | |   | (____)|
|     __)|  __)   | |         | |   |  __ (     | |   |     __)
| (\ (   | (      | |         | |   | (  \ \    | |   | (\ (
| ) \ \__| (____/\| (____/\___) (___| )___) )___) (___| ) \ \__
|/   \__/(_______/(_______/\_______/|/ \___/ \_______/|/   \__/
*/

function credenciales($usuario, $pass){
    global $usuario_recibido;
    global $pass_recibido;
    if (($usuario != $usuario_recibido) OR ($pass != $pass_recibido)) {
        echo "Acceso no autorizado";
        die();
    }
}

function debug(){
    global $input;
    $json_string = json_encode($input, JSON_PRETTY_PRINT);
    file_put_contents('json.js', $json_string);
    file_put_contents('credenciales_recibidas.js', "Usuario: " . $_SERVER['PHP_AUTH_USER'] . " Pass: " . $_SERVER['PHP_AUTH_PW']);
    file_put_contents('array.php', "<?php " . print_r($input, TRUE));
}

function debug_variable($variable){
    file_put_contents('debug_variable.js', $variable);
}

function intent_recibido($nombre){
    global $input;
    if ($input["queryResult"]["intent"]["displayName"] == $nombre) {
        return true;
    } else {
        return false;
    }
}

function recibir_variables($nombre){
    global $input;
    if ($input["queryResult"]["intent"]["displayName"] == $nombre) {
        return true;
    } else {
        return false;
    }
}

function responseId(){
    global $input;
    return $input["responseId"];
}

function requeridosPresentes(){
    global $input;
    return $input["queryResult"]["allRequiredParamsPresent"];
}

function obtener_session(){
    global $input;
    return $input["session"];
}

function origen(){
  global $input;
  if (isset($input["originalDetectIntentRequest"]["source"])) {
      return strtoupper($input["originalDetectIntentRequest"]["source"]);
  }else {
    if(isset($input['originalDetectIntentRequest']['payload']['userId'])){
      $str=$input['originalDetectIntentRequest']['payload']['userId'];
      $msg=explode(",",$str);
      return $msg['0'];
    }else{
      if (strpos($input['session'],"+57")!='') {
        return "WHATSAPP";
      }else {
        return "noPage";
      }
    }
  }
}

function whatsappNumber(){
  global $input;
  if (isset($input['session'])) {
      $init=strpos($input['session'],"+57");
      if ($init!='') {return substr($input['session'],$init);}else {return "None";}
  }else {return "noPage";}
}

function first_name(){
    global $input;
    return $input['originalDetectIntentRequest']['payload']['data']['from']['first_name'];
}

function last_name(){
    global $input;
    return $input['originalDetectIntentRequest']['payload']['data']['from']['last_name'];
}

function TelegramIdPersonal(){
    global $input;
    if(isset($input['originalDetectIntentRequest']['payload']['data']['from']['id'])) {
      return $input['originalDetectIntentRequest']['payload']['data']['from']['id'];
    }elseif (isset($input["queryResult"]["parameters"]['idPersonal'])) {
      return $input["queryResult"]["parameters"]['idPersonal'];
    }else{
      return "NoNumber";
    }
}

function TelegramIdGroup(){
  global $input;
    if(isset($input['originalDetectIntentRequest']['payload']['data']['chat']['id'])) {
      return $input['originalDetectIntentRequest']['payload']['data']['chat']['id'];
    }elseif (isset($input["queryResult"]["parameters"]['idGroup'])) {
      return $input["queryResult"]["parameters"]['idGroup'];
    }else{
      return "NoNumber";
    }
}


function getInfoPage(){
  global $input;
  if(isset($input['originalDetectIntentRequest']['payload']['userId'])) {
    $str=$input['originalDetectIntentRequest']['payload']['userId'];
    $msg=explode(",",$str);
    return $msg;
  }if (isset($input["queryResult"]["parameters"]['userId'])) {
    $str=$input["queryResult"]["parameters"]['userId'];
    $msg=explode(",",$str);
    return $msg;
  } else {
    return "NoInfo";
  }
}



function obtener_texto(){
    global $input;
    if (isset($input["queryResult"]["queryText"])) {
        return $input["queryResult"]["queryText"];
    } else {
        return "";
    }
}

function obtener_variables(){
    global $input;
    if (isset($input["queryResult"]["parameters"])) {
        return $input["queryResult"]["parameters"];
    } else {
        return "";
    }
}


/*
_______  _                _________ _______  _______
(  ____ \( (    /||\     /|\__   __/(  ___  )(  ____ )
| (    \/|  \  ( || )   ( |   ) (   | (   ) || (    )|
| (__    |   \ | || |   | |   | |   | (___) || (____)|
|  __)   | (\ \) |( (   ) )   | |   |  ___  ||     __)
| (      | | \   | \ \_/ /    | |   | (   ) || (\ (
| (____/\| )  \  |  \   /  ___) (___| )   ( || ) \ \__
(_______/|/    )_)   \_/   \_______/|/     \||/   \__/
*/

//ok
function calificacion($pregunta){
  global $input;
  $plataforma=origen();
  $session=obtener_session();
  if ($plataforma=='TELEGRAM'){
    $idPersonal=TelegramIdPersonal();
    $idGroup=TelegramIdGroup();
    $user=first_name();
    echo '{"fulfillmentMessages":[';
      echo '{"payload":
        {
          "telegram": {
            "text": "😊 '.$user.' ¿Como estuvimos hoy?",
            "reply_markup": {
                "inline_keyboard": [
                  [
                    {
                      "callback_data": "5",
                      "text": "😍"
                    }
                  ],
                  [
                    {
                      "text": "😊",
                      "callback_data": "4"
                    }
                  ],
                  [
                    {
                      "callback_data": "3",
                      "text": "😳"
                    }
                  ],
                  [
                    {
                      "text": "😒",
                      "callback_data": "2"
                    }
                  ],
                  [
                    {
                      "callback_data": "1",
                      "text": "😡"
                    }
                  ]
                ]
              }
          }
        },
        "platform": "'.$plataforma.'"
      }';

      echo ' ],
        "outputContexts": [
        {
          "name": "'.$session.'/contexts/calificaciones",
          "lifespanCount": 5,
          "parameters": {
            "idPersonal": "'.$idPersonal.'",
            "idGroup": "'.$idGroup.'"
          }
        }
      ]
    }'. PHP_EOL;

  }elseif ($plataforma=='WHATSAPP') {
    enviar_texto("Aun no tengo programada esa funcion. Por favor, consultame otra cosa.");
  }else{
    $info=getInfoPage();
    echo '{"fulfillmentMessages":[';
      echo '{
              "text": {
                "text": [
                  "'.$pregunta.'"
                ]
              }
            },';
      echo '{"payload":{

        "richContent": [
          [
            {
              "type": "chips",
              "options": [
                {
                  "text": ". Muy insatisfecho .",
                  "image": {
                    "src": {
                      "rawUrl": "https://mhconcepts.ml/assets/images/face5.png"
                    }
                  }
                },
                {
                  "text": ". . Insatisfecho . .",
                  "image": {
                    "src": {
                      "rawUrl": "https://mhconcepts.ml/assets/images/face4.png"
                    }
                  }
                },
                {
                  "text": ". . . Neutral . . .",
                  "image": {
                    "src": {
                      "rawUrl": "https://mhconcepts.ml/assets/images/face3.png"
                    }
                  }
                },
                {
                  "text": ". . Satisfecho . .",
                  "image": {
                    "src": {
                      "rawUrl": "https://mhconcepts.ml/assets/images/face2.png"
                    }
                  }
                },
                {
                  "text": ". Muy satisfecho .",
                  "image": {
                    "src": {
                      "rawUrl": "https://mhconcepts.ml/assets/images/face1.png"
                    }
                  }
                }
              ]
            }
          ]
          ]
        }}';

        echo ' ],
          "outputContexts": [
          {
            "name": "'.$session.'/contexts/calificaciones",
            "lifespanCount": 5,
            "parameters": {
              "info": "'.$input['originalDetectIntentRequest']['payload']['userId'].'"
            }
          }
        ]
      }'. PHP_EOL;
  }


}

function enviar_texto_y_siono($texto, $link){
  echo '{"fulfillmentText": "' . $texto . '",
  "fulfillmentMessages": [
    {
      "text": {
        "text": [
          "' . $texto . '"
        ]
      }
    },';
echo '{"payload":{

  "richContent": [
    [
      {
        "type": "chips",
        "options": [
          {
            "text": "Si",
            "image": {
              "src": {
                "rawUrl": "https://mhconcepts.ml/assets/images/face1.png"
              }
            },
            "link": "' . $link . '"
          },
          {
            "text": "No",
            "image": {
              "src": {
                "rawUrl": "https://mhconcepts.ml/assets/images/face5.png"
              }
            }
          }
        ]
      }
    ]
    ]
  }}';
  echo ' ]}' . PHP_EOL;
}

function enviar_texto($texto){
    echo '{"fulfillmentText": "' . $texto . '",
    "fulfillmentMessages": [
      {
        "text": {
          "text": [
            "' . $texto . '"
          ]
        }
      }
    ]}' . PHP_EOL;
}
