## Laravel Service Repository Pattern Example

This is example of how to implement service repository pattern on laravel 6.  

## Installation Guide

You need docker to run this project

- enter project directory
- cp .env.example .env
- docker-compose up -d --build
- docker exec -it laravel_service_repository_pattern_app /bin/bash
- php artisan key:generate
- php artisan migrate:fresh --seed
