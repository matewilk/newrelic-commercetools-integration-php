<?php

namespace App\Service;

use App\Client\RequestBuilder;

class ProductService
{
    private $builder;

    public function __construct(RequestBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getProducts()
    {
        $apiRequestBuilder = $this->builder->getApiRequestBuilder();

        return $apiRequestBuilder->products()
            ->get()
            ->execute();
    }
}
