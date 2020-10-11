<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Model\MongoCarPark;

require __DIR__ . '/../vendor/autoload.php';


$app = AppFactory::create();

$app->get('/car_parks', function (Request $request, Response $response, $args) {
    $response->getBody()->write(getCarparks($request));
    return $response->withHeader('Content-Type', 'application/json');
});


$app->run();

function getCarparks(Request $request)
{
    $config = json_decode(file_get_contents("config.json"), true);
    $model = new MongoCarPark($config['mongo']);
    return $model->get(
        getFilter($request),
        getPageNo($request),
        getPerPage($request)
    );
}

function getFilter(Request $request)
{
    return [];
}

function getPageNo(Request $request)
{
    return 1;
}

function getPerPage(Request $request)
{
    return 1;
}
