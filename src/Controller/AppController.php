<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use FOS\RestBundle\Controller\Annotations\Get;
use App\Service\AppService;
use App\Exception\VendorApiException;

class AppController
{
    /**
     * @Get("/joke/random", name="get_random_joke")
     */
    public function number(LoggerInterface $logger, AppService $service): JsonResponse
    {
		try {
			$data = $service->getJoke();
			return new JsonResponse(['success'=>true, 'data'=>$data], Response::HTTP_OK);
		}
		catch (VendorApiException | \Exception  $e) {
			$logger->error($e->getMessage());
			return new JsonResponse(['success'=>false, 'data'=>'Exception occured please contact server admin.'], Response::HTTP_INTERNAL_SERVER_ERROR);
		}
    }
}
