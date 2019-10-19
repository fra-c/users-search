<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert;
use Slim\Http\Response;

class UsersSearchContext implements Context
{
    use AppTrait;
    use DatabaseTrait;

    /** @var Response */
    private $response;

    /**
     * @When I search the terms :terms
     */
    public function iSearchTheTerms($terms)
    {
        $queryParams = http_build_query([
            'terms' => $terms
        ]);

        $this->response = $this->request('GET', '/users?' . $queryParams);
    }

    /**
     * @When I search the terms :terms filtering duplicates
     */
    public function iSearchTheTermsFilteringDuplicates($terms)
    {
        $queryParams = http_build_query([
            'terms' => $terms,
            'dupes' => '0'
        ]);

        $this->response = $this->request('GET', '/users?' . $queryParams);
    }


    /**
     * @Then I should get the following results:
     */
    public function iShouldGetTheFollowingResults(TableNode $results)
    {
        Assert::assertEquals(200, $this->response->getStatusCode());
        Assert::assertEquals(json_decode($this->response->getBody(), true), $results->getColumnsHash());
    }
}
