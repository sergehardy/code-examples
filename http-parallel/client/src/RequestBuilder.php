<?php
namespace App;
class RequestBuilder
{

    public function __construct(private RequestGenerator $generator=new RequestGenerator() )
    {
    }

    public function build(string $baseUrl, int $batchSize):iterable
    {
        $generator = $this->generator->generate($baseUrl,$batchSize);
        while ($generator->valid()) {
            $response = $generator->current();
            yield $response->getContent();
            $generator->send($response);
        }
    }


}