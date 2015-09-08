<?php

require_once __DIR__ . "/../vendor/autoload.php";

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

$controller = new \ConorSmith\GeneratorConsoleDemo\Http\MakeBaconController(
    new \ConorSmith\GeneratorConsoleDemo\MakeBacon(new \GuzzleHttp\Client)
);

$response = $controller->index($request);

$response->send();
