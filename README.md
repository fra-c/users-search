# Users Search

### 1. Install

Clone this repository: `git clone https://github.com/fra-c/users-search.git` and move to the newly created directory `cd users-search`.

Run the install script: `./install.sh`.

This will copy the .env file, run composer install, start the service then run database migrations. No dependencies are required apart from Docker.

**Note**: Migrations might fail due to the MySql container not being ready. In that case run the migrations after a few seconds: `docker-compose run --rm php vendor/bin/doctrine-migrations migrations:migrate --no-interaction`

After first installation, the service can be started simply with `docker-compose up -d`.

### 2. Open App In Your Browser

The app will be available at: <http://localhost:8080/user-search.html>.

## About The Project

The project uses the Slim 3 framework, Doctrine ORM and Behat tests.

Run Behat tests with: `docker-compose run --rm -e DB_NAME=test_db -e LOG_FILENAME= php vendor/bin/behat`
