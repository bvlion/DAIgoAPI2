# D◯I 語 API

API 4 D◯I 語 app on PHP

- Android

## FW

- [Slim4](https://www.slimframework.com/)

## Environment

### Install

```
docker compose up composer
```

### Execution

```
docker compose up slim -d
```

### Test

```
docker compose exec slim vendor/bin/phpcs
docker compose exec slim vendor/bin/phpstan
docker compose exec slim vendor/bin/phpunit
```

## EndPoint

- [Authenticated API](/doc/AuthenticatedAPI.md)
- [Unauthenticated API](/doc/UnauthenticatedAPI.md)
- [Unauthenticated Web](/doc/UnauthenticatedWEB.md)