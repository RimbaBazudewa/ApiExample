<h1 align="center">Api Football </h1>

## About This Api 

This is an example for  api(application programming interface) football manager. this api created using laravel 9.x ,use sanctum for auth
Laravel is accessible, powerful, and provides tools required for large, robust applications.

##  Instalation

after clone this project use  command like this inside project directory :

```Bash
	composer install
``` 
rename .env.example to .env if using linux command like this : 
```Bash
	cp .env.example .env
```
after that open the .env and change the value of DB DATABASE to the database you want to use then type this if the database is empty:

```Bash
	php artisan migrate --seed
```
use this if the database not empty :
```Bash
	php artisan migrate:fresh --seed
```
before running the project make sure the app key is generated using this:
```Bash
	php artisan key:generate
```

run the project :

```Bash
	php artisan serve
```


##  Documentation

to see documentation , you can use web browser and type this url:
```Bash
	http://localhost:8000/request-docs/
```


###  Testing
login testing : 
```Bash
    {
        "email": "test@example.com",
        "password" : "password"
    }
``

command for testing :

```Bash
	php artisan test 
```
