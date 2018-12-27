<?php

//@proyecto_unlp_2018_g20_bot
require_once __DIR__. '/../vendor/autoload.php';
require_once __DIR__. '/../model/core/ApiInstituciones.php';


$returnArray = true;
$rawData = file_get_contents("php://input");
$response = json_decode($rawData, $returnArray);
$id_del_chat = $response['message']['chat']['id'];



// Obtener comando (y sus posibles parametros)
$regExp = '#^(\/[a-zA-Z0-9\/]+?)(\ .*?)$#i';


$tmp = preg_match($regExp, $response['message']['text'], $aResults);

if (isset($aResults[1])) {
    $cmd = trim($aResults[1]);
    $cmd_params = trim($aResults[2]);
} else {
    $cmd = trim($response['message']['text']);
    $cmd_params = '';
}

$msg = array();
$msg['chat_id'] = $response['message']['chat']['id'];
$msg['text'] = null;
$msg['disable_web_page_preview'] = true;
$msg['reply_to_message_id'] = $response['message']['message_id'];
$msg['reply_markup'] = null;


switch ($cmd) {
case '/start':
    $msg['text']  = 'Hola ' . $response['message']['from']['first_name']. '! ';
    $msg['text'] .= 'Los comandos disponibles son estos:' . PHP_EOL;
    $msg['text'] .= '/instituciones Muestra el listado completo de las instituciones' . PHP_EOL;
    $msg['text'] .= '/institucionesRegionSanitaria obtiene un listado con las instituciones a partir de una region sanitaria' . PHP_EOL;
    $msg['text'] .= '/ayuda Ayuda'. PHP_EOL;
    $msg['text'] .= ' ¿Como puedo ayudarte?' ;
    $msg['reply_to_message_id'] = null;
    break;

case '/ayuda':
    $msg['text'] = 'Los comandos disponibles son estos:' . PHP_EOL;
    $msg['text'] .= '/instituciones Muestra el listado completo de las instituciones' . PHP_EOL;
    $msg['text'] .= '/institucionesRegionSanitaria obtiene un listado con las instituciones a partir de una region sanitaria' . PHP_EOL;
    $msg['text'] .= '/ayuda Ayuda'. PHP_EOL;
    $msg['reply_to_message_id'] = null;
    break;

case '/instituciones':

    $instModel = new ApiInstituciones;
    
    $json = $instModel->ObtenerInstituciones();
    $data = json_decode($json);
    if(isset($data)){
        $msg['text'] = 'Instituciones disponibles:' . PHP_EOL;
        foreach ($data as $key => $value) {
            $msg['text']  .= '-'. $value->{'nombre'}. PHP_EOL;
        }
    }
    else{
        $msg['text'] = 'No hay instituciones disponibles' . PHP_EOL;
    }
    $msg['reply_to_message_id'] = null;
    break;

/*case '/regionesSanitarias':



        break;*/    

case '/institucionesRegionSanitaria':
    $parametros=explode(" ",$cmd_params);

    $regionId = $parametros[0];


    if (isset($regionId) && filter_var($regionId, FILTER_VALIDATE_INT)) {
        
        $instModel = new ApiInstituciones;
        $json = $instModel->ObtenerInstitucionesPorRegionSanitaria($regionId);
        $data = json_decode($json);
        
        if(isset($data)){
            $msg['text'] = 'Instituciones disponibles:' . PHP_EOL;
            foreach ($data as $key => $value) {
                $msg['text']  .= '-'. $value->{'nombre'}. PHP_EOL;
            }
        }
        else{
            $msg['text'] = 'No hay instituciones disponibles' . PHP_EOL;
        }


    }
    else{
        $msg['text'] = 'Indique una region sanitaria válida' . PHP_EOL;
    }



    $msg['reply_to_message_id'] = null;
    break;


default:
        $msg['text']  = 'Lo siento, no es un comando válido.' . PHP_EOL;
        $msg['text'] .= 'Prueba /ayuda para ver la lista de comandos disponibles';
    break;    
}

$url = 'https://api.telegram.org/bot738534182:AAH7VSOgMC2QYz1Oi4bxZscRAnwRTAeJmLA/sendMessage';

$options = array(
'http' => array(
    'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
    'method'  => 'POST',
    'content' => http_build_query($msg)
    )
);

$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
exit(0);


