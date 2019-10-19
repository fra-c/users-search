<?php

namespace App\Action;

use Slim\Http\Request;
use Slim\Http\Response;

interface Action
{
    public function __invoke(Request $request, Response $response, array $args): Response;
}
