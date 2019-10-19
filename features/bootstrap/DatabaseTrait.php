<?php

use Doctrine\DBAL\Migrations\Tools\Console\ConsoleRunner;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Console\ConsoleRunner as OrmSchemaToolConsoleRunner;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;


trait DatabaseTrait
{
    /**
     * @BeforeScenario
     */
    public function resetDatabase()
    {
        $app = $this->createApp();
        $dbSettings = $app->getContainer()->get('settings')['database'];

        /** @var \Doctrine\ORM\EntityManager $entityManager */
        $entityManager = $app->getContainer()->get(EntityManagerInterface::class);

        $query = 'DROP DATABASE IF EXISTS %1$s;';
        $query .= 'CREATE DATABASE %1$s;';

        (new PDO(
            sprintf('mysql:host=%s', $dbSettings['host']),
            $dbSettings['user'],
            $dbSettings['password']
        ))->exec(sprintf($query, $dbSettings['dbname']));

        $helperSet = OrmSchemaToolConsoleRunner::createHelperSet($entityManager);

        $cli = ConsoleRunner::createApplication($helperSet);
        $cli->setAutoExit(false);

        $output = new BufferedOutput();
        $input = new ArrayInput([
            'command' => 'migrations:migrate',
            '--no-interaction' => null
        ]);

        $cli->run($input, $output);
    }
}
