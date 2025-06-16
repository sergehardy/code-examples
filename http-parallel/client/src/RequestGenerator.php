<?php

namespace App;

use Generator;
use Symfony\Component\HttpClient\CurlHttpClient;

class RequestGenerator
{
    public function __construct(private $client = new CurlHttpClient() )
    {
    }

    public function generate(string $baseUrl, int $batchSize): Generator
    {
        $i = 0;
        while (true) {
            $from = $i * $batchSize + 1;
            $to = ($i + 1) * $batchSize;
            $url = sprintf('%s/?from=%s&to=%s', $baseUrl, $from, $to);
            $response = yield $this->client->request('GET',  $url);

            if($response->getStatusCode() !== 200) {
                break;
            }
            $content= $response->getContent();
            $body = json_decode($content, true);

            $data = $body['items'] ?? null;

            if ($data === null) {
                break;
            }
            $i++;
        }
    }

}