<?php

namespace Model;

interface CarPark
{
    public function get(array $filter, int $page = 0, int $perPage = 1);
}