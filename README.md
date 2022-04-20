<h1 align="center"><a href="https://divii.fr" target="_blank">Divii</a></h1>

## About Divii

Le premier site qui démystifie les arts ancestraux pour tous ceux qui souhaitent mieux se connaître.

La première plateforme proposant de réunir et de rendre plus accessibles les arts divinatoires, à travers des cours et conférences en ligne et en direct sur différents thèmes, mais aussi via une offre de consultations à distance complète et qualitative avec des professionnels reconnus et certifiés par la plateforme.

## Installation

### Clone git project
```
git clone https://github.com/joelinjatovo/divii.fr.git
```

### Composer
```
cd divii.fr
composer install
```

### NPM
```
npm install
```

### Generate key
Copy .env.example as .env

```
php artisan key:generate
```

### Database & Migration
Config database connection in .env file
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=divii_fr
DB_USERNAME=root
DB_PASSWORD=
```
Run this command in console
```
php artisan migrate --seed
```

### VueJS
Run this command in console to view change
```
npm run watch
```

### Server Local
Run this command in console to run serve
```
php artisan serve

Starting Laravel development server: http://127.0.0.1:8000
[Mon Jan 24 14:13:09 2022] PHP 8.1.2 Development Server (http://127.0.0.1:8000) started
```

## Change PHP Version
- $ which php
- $ mv /usr/bin/php /usr/bin/php-backup
- $ ln -s /opt/plesk/php/8.1/bin/php /usr/bin/php
- $ php -v

## browscap
- Download php_browscap.ini from https://browscap.org/stream?q=PHP_BrowsCapINI
- Add this line to php.ini

```
[browscap]
browscap = "path/to/php_browscap.ini"
```
