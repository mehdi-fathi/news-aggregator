# News-Aggregator Project

## Description

News-Aggregator is a Laravel-based application designed to fetch news from various sources and filter them based on user
preferences. Utilizing a RESTful API, it allows users to receive news updates tailored to their interests.

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Features

Fetch news from multiple sources.
RESTful API for retrieving news.
Filter news based on user preferences.

## Install

        $ composer install
        $ php artisan migrate
        $ php artisan db:seed --class=dataSourceSeeder
        $ php artisan serve
