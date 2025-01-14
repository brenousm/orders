#Build container
docker-compose up -d --build --force-recreate

#Config project
docker exec -i api-orders cp -r .env.example .env
docker exec -i api-orders chmod 777 -R storage
docker exec -i api-orders composer install
docker exec -i api-orders php artisan key:generate
docker exec -i api-orders php artisan jwt:secret

#config database
docker exec -i api-orders php artisan migrate:fresh --seed

#clean e cache app
docker exec -i api-orders php artisan optimize

#run background job queue
docker exec -i api-orders php artisan queue:work --daemon &

#run tests
docker exec -it api-orders ./vendor/bin/phpunit --filter UserTest
docker exec -it api-orders ./vendor/bin/phpunit --filter OrderTest
