Для того чтобы развернуть выполнить следующие инструкции:
```
git clone git@github.com:kolo6ok/test-weather-service.git
npm install 
npm run dev
docker-compose up --build -d
docker-compose exec php composer install
docker-compose exec php php artisan migrate --seed
```
