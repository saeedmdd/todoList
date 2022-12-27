# Todo list

### How to start project
```shell
cp .env.example .env

docker-compose build

docker-compose up

docker exec -t todolist-php bash -c "composer install"
docker exec -t todolist-php bash -c "php artisan key:generate"
docker exec -t todolist-php bash -c "php artisan migrate --seed"

```
