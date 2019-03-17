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

## Start the application

```
php bin/console server:run
```

## Integrate the data 

Go to the folowing url : /feeder

## Compute Rotation rate

```
php bin/console app:rotation:compute
```

## Test the application

```
php bin/phpunit
```

## Watch the result

Go to url : /monitor
