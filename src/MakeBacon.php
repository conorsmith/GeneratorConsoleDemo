<?php

namespace ConorSmith\GeneratorConsoleDemo;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\TransferException;

class MakeBacon
{
    private $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function call($portion)
    {
        $portion = intval($portion);

        yield Payload::processing("Preparing your bacon...\n");

        if ($portion > 10) {
            yield Payload::failure(sprintf("%s is too much bacon. You'd die.", $portion));
        }

        if ($portion < 1) {
            yield Payload::failure(sprintf("%s is too little bacon. You'd die", $portion));
        }

        for ($i = 0; $i < $portion; $i++) {
            try {
                $response = $this->httpClient->get("http://baconipsum.com/api/?type=all-meat&paras=1&format=text");
            } catch (TransferException $e) {
                yield Payload::failure("Bacon transfer problem! %s", $e->getMessage());
            }

            yield Payload::processing(sprintf("%s\n", $response->getBody()->getContents()));
        }

        yield Payload::success("Your bacon is ready!");
    }
}
