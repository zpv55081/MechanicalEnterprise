
# Веб-приложение механического предприятия

## Разработчикам

### Системные требования

SQL database

PHP >= 8.1
Ctype PHP Extension
cURL PHP Extension
DOM PHP Extension
Fileinfo PHP Extension
Filter PHP Extension
Hash PHP Extension
Mbstring PHP Extension
OpenSSL PHP Extension
PCRE PHP Extension
PDO PHP Extension
Session PHP Extension
Tokenizer PHP Extension
XML PHP Extension

Composer

### Разворачивание проекта

- В Laravel каталоге склонированного проекта установить зависимости

    `composer install --optimize-autoloader`

- Создать файл .env в корне сайта на базе .env.example

- Сгенерировать ключ приложения

    `php artisan key:generate`

- Сконфигурировать кэш фреймворка

    `php artisan config:cache`

- Накатить миграции

    `php artisan migrate`

- Накатить сиды

    `php artisan db:seed`

**Готово**

### Продакшн

* Оптимизация загрузки маршрута prod

    `php artisan route:cache`

    (для отмены: php artisan route:clear)

### Документация и остальное

<https://laravel.com/docs/10.x/deployment>
