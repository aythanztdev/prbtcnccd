## Requirements
* MySQL
* PHP >= 7.2
* Composer

## Installation
1. git clone https://github.com/aythanztdev/prbtcnccd.git
2. cd prbtcnccd
3. composer install
4. php bin/console doctrine:migrations:migrate
5. php bin/console app:populate-on-deploy // Populate master tables (Category and Tax)
6. php bin/console server:run
7. Go to the browser and visit http://127.0.0.1:8000/api

## Utils
* php bin/console hautelook:fixtures:load --append // Populate tables with random data