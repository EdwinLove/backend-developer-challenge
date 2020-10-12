<?php
use MongoDB\Client as MongoClient;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Psr7\Response as SlimReponse;
use Slim\Factory\AppFactory;

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
    $client = new MongoClient(
        $config['mongo']["url"],
        [
            'username' => $config['mongo']["username"],
            'password' => $config['mongo']["password"]
        ]
    );

    return json_encode(iterator_to_array($client->simpleweb->car_parks->find(
        getFilter($request),
        [
            'projection' =>['_id' => 0],
            'limit' => getIntQueryParam($request, 'perPage', 20), 
            'skip' => getIntQueryParam($request, 'page', 1)
        ]
    )));

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

function getIntQueryParam(Request $request, string $param, int $default)
{
    $params = $request->getQueryParams();
    return intval($params[$param] ?? $default);
}
