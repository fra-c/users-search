<?php

use Slim\App;
use Slim\Http\Environment;
use Slim\Http\Request;
use Slim\Http\Response;

trait AppTrait
{
    public function createApp(): App
    {
        return require __DIR__ . '/../../app/app.php';
    }

    protected function request(string $method, string $uri, array $params = [], array $headers = []): Response
    {
        $environment = Environment::mock(['REQUEST_METHOD' => strtoupper($method), 'REQUEST_URI' => $uri]);

        $request = Request::createFromEnvironment($environment);

        if (!empty($params)) {
            $request = $request->withParsedBody($params);
        }

        foreach ($headers as $name => $value) {
            $request = $request->withAddedHeader($name, $value);
        }

        return $this->createApp()->process($request, new Response());
    }
}
