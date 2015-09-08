<?php

namespace ConorSmith\GeneratorConsoleDemo\Http;

use ConorSmith\GeneratorConsoleDemo\MakeBacon;
use ConorSmith\GeneratorConsoleDemo\Payload;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MakeBaconController
{
    private $domainService;

    public function __construct(MakeBacon $domainService)
    {
        $this->domainService = $domainService;
    }

    public function index(Request $request)
    {
        $output = [];

        foreach ($this->domainService->call($request->get("portion")) as $payload) {
            $output[] = $payload->getMessage();

            if ($payload->getStatus() === Payload::FAILURE) {
                return new Response($this->formatOutput($output), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }

        return new Response($this->formatOutput($output), Response::HTTP_OK);
    }

    private function formatOutput(array $output)
    {
        return nl2br(implode("\n", $output));
    }
}
