<?php

namespace Model;

use MongoDB\Client as MongoClient;

class MongoCarPark implements CarPark
{
    private $collection;

    public function __construct(array $mongoCredentials)
    {
        $client = new MongoClient(
            $mongoCredentials["url"],
            [
                'username' => $mongoCredentials["username"],
                'password' => $mongoCredentials["password"]
            ]
        );
       
        $this->collection = $client->simpleweb->car_parks;
    }

    public function get(array $filter, int $page = 0, int $perPage = 1)
    {
        return json_encode(iterator_to_array($this->collection->find(
            $filter,
            [
                'projection' =>['_id' => 0],
                'limit' => $perPage, 
                'skip' => $page
            ]
        )));
    }
}