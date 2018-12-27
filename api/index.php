<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once __DIR__. '/../vendor/autoload.php';
require_once __DIR__. '/../model/core/Institucion.php';

//require_once './controller/InstitucionController.php';

//$app = new \Slim\App;

$app = new Slim\App([

    'settings' => [
        'displayErrorDetails' => true,
        'debug'               => true,
        'whoops.editor'       => 'sublime',
    ]

]);




$app->get('/instituciones/{institucion-id}', function ($request, Response $response, array $args) {
    $id = $args['institucion-id'];

    if(!filter_var($id, FILTER_VALIDATE_INT)){
    	return $response->withJson("parametro incorrecto",400);
    }


    $inst = new Institucion;

 	$data = $inst->ObtenerInstitucion($id);

    return $response->withJson($data,200);
});


$app->get('/instituciones/region-sanitaria/{region-sanitaria}', function ($request, Response $response, array $args) {
    $regionId = $args['region-sanitaria'];

    if(!filter_var($regionId, FILTER_VALIDATE_INT)){
    	return $response->withJson("parametro incorrecto",400);
    }


    $inst = new Institucion;

 	$data = $inst->ObtenerInstitucionByRegion($regionId);

    return $response->withJson($data,200);
});



$app->get('/instituciones', function ($request, Response $response, array $args) {
    
    $inst = new Institucion;

 	$data = $inst->ObtenerInstituciones();

    //Return JSON data with a custom HTTP status code
    return  $response->withJson($data, 200);
});



$app->run();