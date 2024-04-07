# Symfony54 Web App Tutorial

```sh
 php bin\console list
```

## Getting start

```sh
docker-compose -f compose.yaml -p "sf_local" up -d
symfony server:stop
symfony server:start
```

### Migrations

```sh
# generate
php bin/console make:migration
# run migrations
php bin/console doctrine:migrations:migrate
```

### Create new entity

```sh
php bin\console make:entity
```
