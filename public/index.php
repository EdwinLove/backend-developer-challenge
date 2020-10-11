<?php
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Psr7\Response as SlimReponse;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Model\MongoCarPark;

require __DIR__ . '/../vendor/autoload.php';
$config = json_decode(file_get_contents("config.json"), true);

$app = AppFactory::create();
$app->add(function ($request, $handler) use ($config) {
    foreach ($request->getHeader("Api-key") as $header) {
        if (in_array($header, $config['api-keys'] ?? [])) {
            return $handler->handle($request);
        }
    }
    
    return new SlimReponse(401);
});

$app->get('/car_parks', function (Request $request, Response $response, $args) use ($config) {
    $response->getBody()->write(getCarparks($config, $request));
    return $response->withHeader('Content-Type', 'application/json');
});


$app->run();

function getCarparks(array $config, Request $request)
{
    $model = new MongoCarPark($config['mongo']);
    return $model->get(
        getFilter($request),
        getPageNo($request),
        getPerPage($request)
    );
}

function getFilter(Request $request)
{
    $params = $request->getQueryParams();
    $filter = [];
    if ($params['park_and_ride'] ?? false) {
        $filter['features.park_and_ride'] = true;
    }
    if ($params['electric_car_charge_point'] ?? false) {
        $filter['features.electric_car_charge_point'] = true;
    }
    return $filter;
}

function getPageNo(Request $request)
{
    $params = $request->getQueryParams();
    return intval($params['page'] ?? 0);
}

function getPerPage(Request $request)
{
    $params = $request->getQueryParams();
    return intval($params['perPage'] ?? 20);
}
