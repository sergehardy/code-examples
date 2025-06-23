<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/')]
    public function index(
        #[Autowire('%env(API_TOTAL_RESULTS)%')]
        int $max,
        #[MapQueryParameter]
        ?int $from = 1,
        #[MapQueryParameter]
        ?int $to = 7,
    ): Response
    {
        $items = [];
        for ($i = $from; $i <= $to; $i++) {
            if ($i > $max) {
                break;
            }
            $items[] = "item $i";
        }
        if (empty($items)) {
            return new Response("out of range request", 416);
        }
        $data = ['from' => $from,
            'to' => $to,
            'clock' => (new \DateTime())->format('H:i:s'),
            'items' => $items,
        ];
        usleep(100000);
        return new JsonResponse($data);
    }
}