<?php

namespace App\Service;

use App\Client\RequestBuilder;

class OrdersService
{
    private $builder;

    public function __construct(RequestBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getOrders()
    {
        $apiRequestBuilder = $this->builder->getApiRequestBuilder();

        return $apiRequestBuilder->orders()
            ->get()
            ->execute();
    }
}
