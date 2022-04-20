git pull
composer install
php artisan migrate
php artisan optimize:clear
php artisan optimize
php artisan queue:restart
cp public/js/app.js beta.divii.fr/js/app.js
cp public/css/custom.css beta.divii.fr/css/custom.css
