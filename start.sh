cd ./docker || exit

docker compose up -d
docker exec farm-fusion-php composer install
