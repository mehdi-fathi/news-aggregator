# News-Aggregator Project

## Description

News-Aggregator is a Laravel-based application designed to fetch news from various sources and filter them based on user
preferences. Utilizing a RESTful API, it allows users to receive news updates tailored to their interests.

I assumed this project would be a large scale project, so I try to implement robust and engineering structure.

- Database: PostgreSQL
- PHP : 8.1
- Laravel : 10.34.2

## Features

- Fetch news from multiple sources.

- RESTful API for retrieving news and preferences user.

- Filter news based on user preferences.

- Swagger documentation `http://127.0.0.1:8000/api/documentation`

## Install

        $ composer install
        $ php artisan migrate
        $ php artisan db:seed --class=dataSourceSeeder
        $ php artisan serve

for run schedule:

     $ php artisan schedule:work

for run queues:

     $ php artisan queue:listen --queue=high,default
