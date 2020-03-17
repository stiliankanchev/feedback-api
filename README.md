# Task requirements (estimates as ~2h, took ~6h)
Using recent version of Symfony framework build a REST API for Guestbook Application where people can leave their feedback about virtual restaurant.

It should have 2 endpoints:

- POST /feedback - should accept json object and save it to persistence layer. You can use database or maybe just a file, does not matter.
- GET /feedback - should return the last 10 “feedback“ objects saved if they do not contain the word “test1” or “test2”

There is not need for authorisation, authentication, user management.

The solution must include Dockerfile.

If the solution uses third party software (such as relational database, e.g. MySQL) there should be docker-compose.yaml file.

Bonus points for unit and integration tests.

# Running the project

Running all services: `docker-compose up --build`
Running migrations: `docker-compose exec php php bin/console doctrine:migrations:migrate`
Running tests: `docker-compose exec php php bin/phpunit`

# TODO: Improvements
- proper environments setup. Everything in a single file
- there is something wrong with the file permissions inside the container
- add validators inside the controller
- add more tests
- extract consts
- fix code formatting
- unify class/variable naming
- clear unnecessary files
- fix integration test - test lifecycle works differently and data dont get cleaned - separate runtime and test database will fix the issue
- use transaction rollback in tests to revert stored entities instead deletes before and after each test

# Resources
- https://www.codebyamir.com/blog/object-to-json-in-php
- https://symfony.com/doc/current/doctrine.html
- https://symfony.com/doc/current/routing.html#creating-routes-as-annotations
- https://symfony.com/doc/current/introduction/http_fundamentals.html
- https://symfony.com/doc/current/configuration.html
- https://www.digitalocean.com/community/tutorials/how-to-set-up-laravel-nginx-and-mysql-with-docker-compose
- https://knplabs.com/en/blog/how-to-dockerise-a-symfony-4-project


# Quick commands
`php bin/console doctrine:migrations:migrate`
`php bin/phpunit`
`symfony server:start`
`composer require annotations`
`composer require symfony/orm-pack`
`composer require --dev symfony/maker-bundle`
`composer require --dev symfony/phpunit-bridge`

# Some commands used to provision a VM on DigitalOcean
Tried to keep my laptop clean so a VM was used

## Get latest packages and setup basic php environment
sudo apt update
sudo apt install -y curl wget php libapache2-mod-php php-cli php-zip unzip php-fpm php-xml php-mysql php-mbstring


## Install composer https://getcomposer.org/download/
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

## Install Symfony
curl -sS https://get.symfony.com/cli/installer | bash
sudo mv /home/sti/.symfony/bin/symfony /usr/local/bin/symfony


## Install docker https://docs.docker.com/install/linux/docker-ce/ubuntu/
sudo apt-get remove docker docker-engine docker.io containerd runc
sudo apt-get install \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg-agent \
    software-properties-common
curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -
sudo apt-get install docker-compose

sudo add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
   $(lsb_release -cs) \
   stable"
sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io


## Add MySQL container
docker run --name some-mysql -e MYSQL_ROOT_PASSWORD=my-secret-pw -d mysql

