<?php
// hacer las peticiones
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';
require '../src/config/db.php';


// creamos un objeto. Indicamos donde vamos a meterlo
$app = new \Slim\App;
/*
// lo que obtenemos. La clase es app
$app->get('/', function (Request $request, Response $response, array $args) {
    //$name = $args['name'];
    $response->getBody()->write("Página de gestión de API REST de la aplicación de Merce");

    return $response; // devuelve las respuestas
});*/
// creamos las rutas para los empleados
require '../src/rutas/empleados.php';
$app->run();
?>
