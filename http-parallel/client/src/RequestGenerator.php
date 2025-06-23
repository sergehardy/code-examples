<?php

namespace App;

use Generator;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\ResponseInterface;

class RequestGenerator
{

    public function __construct(
        private     $client = new CurlHttpClient(),
        private int $batchRequestsSize = 100,

    )
    {
    }

    /**
     * @return Generator<ResponseInterface>
     */
    public function generate(string $baseUrl): Generator
    {
        $i = 0;

        $firstResponse = yield $this->client->request('GET', $baseUrl);
        $content = $firstResponse->getContent();
        $body = json_decode($content, true);
        $batchItemSize = (int)($body['to'] - $body['from']) + 1;

        $batchRequestsIndex = 0;
        $batchRequests = [];

        error_log("Generator / première requête reçue");


        while ($i <= 1000) {
            $from = $i * $batchItemSize + 1;
            $to = ($i + 1) * $batchItemSize;
            $url = sprintf('%s/?from=%s&to=%s', $baseUrl, $from, $to);

            $batchRequests[] = $this->client->request('GET', $url);
            error_log("Generator / construction du batch n° " . $batchRequestsIndex + 1);

            $batchRequestsIndex++;

            if ($batchRequestsIndex === ($this->batchRequestsSize)) {
                error_log("Generator / envoi d'un batch de requêtes");
                yield from $batchRequests;
                $batchRequests = [];
                $batchRequestsIndex = 0;
            }

            $i++;
        }
    }

}