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
      return strtoupper($input["originalDetectIntentRequest"]["source"]); //lo transformamos todo en mayúscula
  }else {
    if(isset($input['originalDetectIntentRequest']['payload']['userId'])) {
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
function calificacion_1(){
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
                  "¿Como estuvimos hoy?"
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
                  "text": "5",
                  "image": {
                    "src": {
                      "rawUrl": "https://mhconcepts.ml/assets/images/face1.png"
                    }
                  }
                },
                {
                  "text": "4",
                  "image": {
                    "src": {
                      "rawUrl": "https://mhconcepts.ml/assets/images/face2.png"
                    }
                  }
                },
                {
                  "text": "3",
                  "image": {
                    "src": {
                      "rawUrl": "https://mhconcepts.ml/assets/images/face3.png"
                    }
                  }
                },
                {
                  "text": "2",
                  "image": {
                    "src": {
                      "rawUrl": "https://mhconcepts.ml/assets/images/face4.png"
                    }
                  }
                },
                {
                  "text": "1",
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

//ok
function maquinasControl($totems){
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
            "text": " '.$user.', tienes '.count($totems).' maquinas asignadas. Elige una para controlarla",
            "reply_markup": {
                "inline_keyboard": [';
                  $str="";
                  foreach ($totems as $totem) {
                    $str = $str . '[
                      {
                        "callback_data": "'.$totem['0'].'",
                        "text": "'.$totem['0'].'"
                      }
                    ],';
                  }
                  echo rtrim($str,',');

            echo ']
              }
          }
        },
        "platform": "'.$plataforma.'"
      }
      ],
        "outputContexts": [
        {
          "name": "'.$session.'/contexts/controles",
          "lifespanCount": 5,
          "parameters": {
            "idPersonal": "'.$idPersonal.'",
            "idGroup": "'.$idGroup.'"
          }
        }
      ]
    }'. PHP_EOL;

  } elseif ($plataforma=='WHATSAPP') {
    enviar_texto("Aun no puedo controlar Las maquinas de publicidad mediante esta plataforma ($plataforma). Pero estamos trabajando para lograrlo.");
  }else{

    echo '{"fulfillmentMessages":[';
      echo '{"payload":{
        "richContent": [
          [';
          echo '{
                  "type": "info",
                  "title": "Control",
                  "subtitle": "Me has escrito desde el Dasboard del '.$totems['0']['4'].'. Elige un Totem:"
                },';
            echo '
            {
              "type": "chips",
              "options": [';
              $str="";
              foreach ($totems as $totem) {
              $str=$str. ' {
                  "text": "'.$totem['0'].'"
                },';
              }
            echo rtrim($str,',');
        echo']
            }
          ]
          ]
        }}';

        echo ' ],
          "outputContexts": [
          {
            "name": "'.$session.'/contexts/controles",
            "lifespanCount": 5,
            "parameters": {
              "info": "'.$input['originalDetectIntentRequest']['payload']['userId'].'"
            }
          }
        ]
      }'. PHP_EOL;
  }

}

//ok
function controlEspecifico($totems){
  $session=obtener_session();
  $plataforma=origen();
  if ($plataforma=='TELEGRAM'){
    $idPersonal=TelegramIdPersonal();
    $idGroup=TelegramIdGroup();
    echo '{"fulfillmentMessages":[';
      echo '{"payload":
        {
          "telegram": {';
            if ($totems['0']['2']=='Online') {
              echo '
              "text": "Control para '.$totems['0']['0'].'",
              "reply_markup": {
                  "inline_keyboard": [
                      [
                        {';
                          if ($totems['0']['3']=='TV/ON') {
                            echo '"callback_data": "Apagar TV",
                            "text": "🖥️ 🔴 Apagar TV"';
                          }elseif ($totems['0']['3']=='TV/OFF') {
                            echo '"callback_data": "Encender TV",
                            "text": "🖥️ 🟢 Encender TV"';
                          }else {
                            echo '"callback_data": "None",
                            "text": "🖥️ ⚪ Desactivado"';
                          }
                    echo  '}
                      ],
                      [
                        {
                            "callback_data": "Reiniciar",
                            "text": "Reiniciar"
                        },
                        {
                            "callback_data": "Apagar Maquina",
                            "text": "🔴 Apagar Maquina"
                          }
                      ],
                      [
                        {
                            "callback_data": "Sincronizar multimedia",
                            "text": "🔄 Sincronizar multimedia"
                          }
                      ]

                    ]
                }';
            } elseif ($totems['0']['2']=='Offline') {
              echo '  "text": "El totem \"'.$totems['0']['0'].'\" está desconectado de internet o apagado. Por favor, revise la conexión.",
                      "parse_mode": "Markdown"';
            }else {
              echo '  "text": "No existe informacion sobre este totem",
                      "parse_mode": "Markdown"';
            }
      echo '
          }
        },
        "platform": "'.$plataforma.'"
      }';

      echo ' ],
        "outputContexts": [
        {
          "name": "'.$session.'/contexts/controles",
          "lifespanCount": 5,
          "parameters": {
            "idPersonal": "'.$idPersonal.'",
            "idGroup": "'.$idGroup.'"
          }
        }
      ]}'. PHP_EOL;

  }else{
    echo '{"fulfillmentMessages":[';
      echo '{"payload":{

        "richContent": [
          [
            {
               "type": "info",
               "title": "'.$totems['0']['0'].'",';
               $SET=0;
               if ($totems['0']['2']=='Offline') {
               echo ' "subtitle": "El totem está '.$totems['0']['2'].'. No se puede generar ninguna opcion sobre este."';
             }elseif ($totems['0']['2']=='Online') {
               echo ' "subtitle": "El totem esta '.$totems['0']['2'].' Selecciona la accion que deseas que se realice"';
               $SET=1;
               }else {
               echo ' "subtitle": "No existe informacion sobre este totem"';
               }
        echo '
      }'; if ($SET==1){echo  ',
            {
              "type": "chips",
              "options": [
              {';
                if ($totems['0']['3']=='TV/OFF') {
                echo '"text": "Encender TV",
                      "image": {
                        "src": {
                          "rawUrl": "https://mhconcepts.ml/assets/images/face1.png"
                        }
                      }';
                }elseif ($totems['0']['3']=='TV/ON') {
                echo '"text": "Apagar TV",
                      "image": {
                        "src": {
                          "rawUrl": "https://mhconcepts.ml/assets/images/face5.png"
                        }
                      }';
                }else {
                echo '  "text": "Desactivado"';
                }
            echo '
              },
            {
              "text": "Reiniciar",
                    "image": {
                      "src": {
                        "rawUrl": "https://mhconcepts.ml/assets/images/face3.png"
                      }
                    }
              },
              {
                "text": "Apagar Maquina",
                      "image": {
                        "src": {
                          "rawUrl": "https://mhconcepts.ml/assets/images/face5.png"
                        }
                      }
                },
                {
                  "text": "🔄 Sincronizar multimedia"
                  }
             ]
           }';
            }
          echo '
          ]
          ]
        }}';

        echo ' ]}'. PHP_EOL;
  }

}

//ok
function tipoInformeGE(){
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
            "text": " '.$user.', deseas un reporte:",
            "reply_markup": {
                "inline_keyboard": [';

                    echo '[
                      {
                        "callback_data": "General",
                        "text": "General"
                      }
                    ],
                    [
                      {
                        "callback_data": "Especifico",
                        "text": "Especifico"
                      }
                    ]';


            echo ']
              }
          }
        },
        "platform": "'.$plataforma.'"
      }
      ],
        "outputContexts": [
        {
          "name": "'.$session.'/contexts/informe",
          "lifespanCount": 5,
          "parameters": {
            "idPersonal": "'.$idPersonal.'",
            "idGroup": "'.$idGroup.'"
          }
        }
      ]
    }'. PHP_EOL;

  }else{

    echo '{"fulfillmentMessages":[';
      echo '{"payload":{
        "richContent": [
          [
                {
                  "type": "info",
                  "title": "Informe",
                  "subtitle": "Deseas un informe:"
                },
                {
                "type": "chips",
                "options": [
                    {
                      "text": "General"
                    },
                    {
                      "text": "Especifico"
                    }
                  ]
                }
              ]
          ]
        }}';


        echo ' ],
          "outputContexts": [
          {
            "name": "'.$session.'/contexts/informe",
            "lifespanCount": 5,
            "parameters": {
              "info": "'.$input['originalDetectIntentRequest']['payload']['userId'].'"
            }
          }
        ]
      }'. PHP_EOL;
  }
}
//ok
function tipoInformeTime(){
  global $input;
  $plataforma=origen();
  $session=obtener_session();
  if ($plataforma=='TELEGRAM'){
    $idPersonal=TelegramIdPersonal();
    $idGroup=TelegramIdGroup();
    echo '{"fulfillmentMessages":[';
      echo '{"payload":
        {
          "telegram": {
            "text": "Indica el tiempo:",
            "reply_markup": {
                "inline_keyboard": [';

                    echo '[
                      {
                        "callback_data": "Hoy",
                        "text": "Hoy"
                      }
                    ],
                    [
                      {
                        "callback_data": "Diario",
                        "text": "Diario"
                      }
                    ],
                    [
                      {
                        "callback_data": "Mes",
                        "text": "Mes"
                      }
                    ],
                    [
                      {
                        "callback_data": "Año",
                        "text": "Año"
                      }
                    ]';
            echo ']
              }
          }
        },
        "platform": "'.$plataforma.'"
      }
      ],
        "outputContexts": [
        {
          "name": "'.$session.'/contexts/informe",
          "lifespanCount": 5,
          "parameters": {
            "idPersonal": "'.$idPersonal.'",
            "idGroup": "'.$idGroup.'"
          }
        }
      ]
    }'. PHP_EOL;

  }else{

    echo '{"fulfillmentMessages":[';
      echo '{"payload":{
        "richContent": [
          [
                {
                  "type": "info",
                  "subtitle": "Tiempo:"
                },
                {
                "type": "chips",
                "options": [
                    {
                      "text": "Hoy"
                    },
                    {
                      "text": "Diario"
                    },
                    {
                      "text": "Mes"
                    },
                    {
                      "text": "Año"
                    }
                  ]
                }
              ]
          ]
        }}';


        echo ' ],
          "outputContexts": [
          {
            "name": "'.$session.'/contexts/informe",
            "lifespanCount": 5,
            "parameters": {
              "info": "'.$input['originalDetectIntentRequest']['payload']['userId'].'"
            }
          }
        ]
      }'. PHP_EOL;
  }
}
//ok
function tipoInformeList($text,$puntos){
  global $input;
  $plataforma=origen();
  $session=obtener_session();
  if ($plataforma=='TELEGRAM'){
    $idPersonal=TelegramIdPersonal();
    $idGroup=TelegramIdGroup();
    echo '{"fulfillmentMessages":[';
      echo '{"payload":
        {
          "telegram": {
            "text": "'.$text.':",
            "reply_markup": {
                "inline_keyboard": [';
                    $str="";
                    foreach ($puntos as $punto) {
                      $str = $str . '[
                        {
                          "callback_data": "'.$punto['0'].'",
                          "text": "'.$punto['0'].'"
                        }
                      ],';
                    }
                    echo rtrim($str,',');
            echo ']
              }
          }
        },
        "platform": "'.$plataforma.'"
      }
      ],
        "outputContexts": [
        {
          "name": "'.$session.'/contexts/informe",
          "lifespanCount": 5,
          "parameters": {
            "idPersonal": "'.$idPersonal.'",
            "idGroup": "'.$idGroup.'"
          }
        }
      ]
    }'. PHP_EOL;

  }else{

    echo '{"fulfillmentMessages":[';
      echo '{"payload":{
        "richContent": [
          [
                {
                  "type": "info",
                  "subtitle": "'.$text.':"
                },
                {
                "type": "chips",
                "options": [';
                $str="";
                foreach ($puntos as $punto) {
                  $str = $str . '
                    {
                      "text": "'.$punto['0'].'"
                    },';
                }
                echo rtrim($str,',');

        echo '    ]
                }
              ]
          ]
        }}';

        echo ' ],
          "outputContexts": [
          {
            "name": "'.$session.'/contexts/informe",
            "lifespanCount": 5,
            "parameters": {
              "info": "'.$input['originalDetectIntentRequest']['payload']['userId'].'"
            }
          }
        ]
      }'. PHP_EOL;
  }
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
