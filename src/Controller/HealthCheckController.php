<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController
{
    /**
     * @Route("/", name="health_check", methods={"GET"})
     */
    public function index(): Response
    {
        return new Response('OK', Response::HTTP_OK);
    }
}
