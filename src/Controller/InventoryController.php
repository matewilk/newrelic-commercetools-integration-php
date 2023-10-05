<?php

namespace App\Controller;

use App\Service\InventoryService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class InventoryController
{
    private $inventoryService;

    public function __construct(InventoryService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    #[Route('/inventory', name: "get_inventory")]
    public function getInventory(): Response
    {
        return new JsonResponse($this->inventoryService->getInventory()
            ->getResults()->toArray());
    }
}
