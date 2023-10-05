<?php

namespace App\Service;

use App\Client\RequestBuilder;

class InventoryService
{
    private $builder;

    public function __construct(RequestBuilder $builder)
    {
        $this->builder = $builder;
    }

    public function getInventory()
    {
        $apiRequestBuilder = $this->builder->getApiRequestBuilder();

        return $apiRequestBuilder->inventory()
            ->get()
            ->execute();
    }
}
