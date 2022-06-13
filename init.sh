# Ezzel a shell scripttel lehet nullarol inicializalni a Laravel projektet Linux rendszereken
composer install --no-interaction
cp .env.example .env
php artisan key:generate
npm install
npm run prod
# A storage, cache irhato kell legyen a webszerver altal
chmod -R 777 storage bootstrap/cache
# Egy ures sqlite fajlnak leteznie kell, kulonben a migrate nem mukodik
touch database/database.sqlite
php artisan migrate:fresh
php artisan db:seed
echo "Az inicializalo parancsok lefutottak, ha minden rendben ment, akkor indithato a projekt..."
