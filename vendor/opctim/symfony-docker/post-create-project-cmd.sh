#!/usr/bin/env bash

# set project name
sed -i.bak -e "s/COMPOSE_PROJECT_NAME=symfony_dockerized/COMPOSE_PROJECT_NAME=$(basename $(pwd))/g" ./.env

# generate secrets
NEW_APP_SECRET=$(php -r "echo bin2hex(openssl_random_pseudo_bytes(20));")
NEW_DB_PASSWORD=$(php -r "echo bin2hex(openssl_random_pseudo_bytes(5));")

# set secrets
sed -i.bak -e "s/your_db_password/$NEW_DB_PASSWORD/g" ./.env
sed -i.bak -e "s/your_db_password/$NEW_DB_PASSWORD/g" ./application/.env
sed -i.bak -e "s/your_app_secret/$NEW_APP_SECRET/g" ./application/.env

rm -rf ./.env.bak
rm -rf ./application/.env.bak

# create .env.local
cp ./application/.env ./application/.env.local
sed -i.bak -e "s/APP_ENV=prod/APP_ENV=dev/g" ./application/.env.local
sed -i.bak -e "s/APP_DEBUG=false/APP_DEBUG=true/g" ./application/.env.local

rm -rf ./application/.env.local.bak

# start & setup container
docker-compose up -d
docker-compose exec php bash -c "composer install"

# delete self
rm -rf ./post-create-project-cmd.sh

printf "\nDone!\n\nHave a look at your new awesome project running at https://127.0.0.1"

printf "\n(You'll have to trust the certificate as it is self-signed)\n\nHave fun!\n\n"
