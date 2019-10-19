<?php

namespace App\Action;

use Slim\Http\Request;
use Slim\Http\Response;
use UsersSearch\UserRepository;

class UserSearchAction implements Action
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $filterDuplicates = $request->getQueryParam('dupes') === '0' ? true : false;
        $results = $this->userRepository->findByTerms($request->getQueryParam('terms'), $filterDuplicates);

        return $response->withJson($results);
    }
}
