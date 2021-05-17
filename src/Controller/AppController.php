<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Psr\Log\LoggerInterface;
use FOS\RestBundle\Controller\Annotations\Get;

class AppController
{
    /**
     * @Get("/joke/random", name="get_random_joke")
     */
    public function number(LoggerInterface $logger): JsonResponse
    {
		$logger->info('test');
        return new JsonResponse(['success'=>true], Response::HTTP_OK);
    }
}
