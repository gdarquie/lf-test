# Install project

## Dependencies

- PHP 7+ (tested with 7.3)
- PostgreSQL
- Composer

## Installation

```
cd <project>
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

## Start application

```
php bin/console server:run
```