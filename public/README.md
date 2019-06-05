# Installation
## Steps
1. git clone https://github.com/aythanztdev/prbtcnccd.git
2. cd prbtcnccd
3. composer install
4. php bin/console doctrine:migrations:migrate
5. php bin/console app:populate-on-deploy
6. php bin/console server:run
7. Go to the browser and visit http://127.0.0.1:8000/api