## Requirements
* MySQL
* PHP >= 7.2
* Composer

## Installation
1. git clone https://github.com/aythanztdev/prbtcnccd.git
2. cd prbtcnccd
3. Set your datababase credentials in .env
4. composer install
5. php bin/console doctrine:migrations:migrate
6. php bin/console app:populate-on-deploy // Populate master tables (Category and Tax)
7. php bin/console server:run
8. Go to the browser and visit http://127.0.0.1:8000/api

## How to create a new product from http://127.0.0.1:8000/api 
1. GET /api/categories and choose one element. Remember the id.
2. GET /api/taxes and choose one element. Remember the id.
3. POST /api/media_objects and upload de file. Show the result and remember the id.
4. POST /api/products and fill the json:
```
    {
	    "name": "Cap of Star Wars The Last Jedi",
	    "description": "The Star Wars The Last Jedi Collection 9TWENTY is constructed of a black poly fabric. A Star Wars fighter plane is embroidered on the front panels and the cap features a D-Ring closure.",
	    "price": "20.50",
	    "category": {
		    "id": 1
	    },
	    "tax": {
		    "id": 1
	    },
	    "images": [{
		    "id": 1
	    }]
    }
```

## Utils
* php bin/console hautelook:fixtures:load --append // Populate tables with random data
* php bin/phpunit // Run tests
