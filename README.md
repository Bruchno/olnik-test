Клонировать проект

Создать базу данных

Скопировать .env.example в .env и установите правильные учетные данные базы данных.

Запустить composer install чтобы установить все пакеты для vendor

Запустить php artisan key:generate для генерации ключа приложения

Запустите php artisan migrate чтобы создать таблицу

Запустите php artisan db:seed --class=HousSeeder чтобы заполнить таблицу

Запустите npm install чтобы установить зависимости

Запустить php artisan serve

Должно работать без npm run prod
