<?php

namespace App\Controller;

use App\Service\OrdersService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class OrdersController
{
    private $ordersService;

    public function __construct(OrdersService $ordersService)
    {
        $this->ordersService = $ordersService;
    }

    #[Route('/orders', name: "get_orders")]
    public function getOrders(): Response
    {
        return new JsonResponse($this->ordersService->getOrders()
            ->getResults()->toArray());
    }
}
