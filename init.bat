:: Ezzel a batch scripttel lehet nullarol inicializalni a Laravel projektet Windows rendszereken
call composer install --no-interaction
copy .env.example .env
call php artisan key:generate
call npm install
call npm run prod
:: Egy ures sqlite fajlnak leteznie kell, kulonben a migrate nem mukodik
type nul > database/database.sqlite
call php artisan migrate:fresh
call php artisan db:seed
echo "Az inicializalo parancsok lefutottak, ha minden rendben ment, akkor indithato a projekt..."
@pause
