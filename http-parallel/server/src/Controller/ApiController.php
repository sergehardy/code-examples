<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

class ApiController extends AbstractController
{
    #[Route('/')]
    public function index(
        #[MapQueryParameter] int $from = 1,
        #[MapQueryParameter] int $to = 10,
        int                      $max = 666
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
            return new Response(null, 404);
        }
        $data = ['from' => $from,
            'to' => $to,
            'clock' => (new \DateTime())->format('H:i:s'),
            'items' => $items,
        ];

        return new JsonResponse($data);
    }
}