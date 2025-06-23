<?php

namespace App;
class RequestBuilder
{

    public function __construct(private RequestGenerator $generator = new RequestGenerator())
    {
    }

    public function build(string $baseUrl): iterable
    {
        $generator = $this->generator->generate($baseUrl);
        while ($generator->valid()) {
            $response = $generator->current();

            if ($response->getStatusCode() === 416) {
                error_log("Builder / 416 détectée");
                break;

            }
            $content = $response->getContent();
            error_log("Builder / Nouvelle réponse de date ".json_decode($content, true)['clock']);
            yield $content;
            $generator->send($response);
        }
    }


}