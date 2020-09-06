echo off

goto(){
# Linux code here
docker-compose build
docker-compose up -d
docker-compose exec php composer install
docker-compose exec php php bin/console doctrine:migrations:migrate -n
docker-compose exec php php bin/console doctrine:fixtures:load -n
uname -o
}

goto $@
exit

:(){
rem Windows script here
docker-compose build
docker-compose up -d
docker-compose exec php composer install
docker-compose exec php php bin/console doctrine:migrations:migrate -n
docker-compose exec php php bin/console doctrine:fixtures:load -n
echo %OS%
exit