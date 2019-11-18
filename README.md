# Appocular clients for Laravel/Lumen

Laravel/Lumen service providers for Appocular services.

## Keeper

Registering service provider in Lumen:
``` php
$app->register(Appocular\Clients\KeeperServiceProvider::class);
```

To configure, add a `config/keeper.php` file:

``` php
<?php

return [
    'base_uri' => env('KEEPER_BASE_URI', ''),
];
```

## Differ

Registering service provider in Lumen:
``` php
$app->register(Appocular\Clients\DifferServiceProvider::class);
```

To configure, add a `config/keeper.php` file:

``` php
<?php

return [
    'base_uri' => env(DIFFER_BASE_URI', ''),
];
```

## Assessor

Registering service provider in Lumen:
``` php
$app->register(Appocular\Clients\AssessorServiceProvider::class);
```

To configure, add a `config/assessor.php` file:

``` php
<?php

return [
    'base_uri' => env(ASSESSOR_BASE_URI', ''),
];
```

[![](https://github.com/appocular/clients-laravel/workflows/Run%20checks%20and%20tests/badge.svg)](https://github.com/appocular/clients-laravel/actions)
[![](https://img.shields.io/codecov/c/github/appocular/clients-laravel.svg)](https://codecov.io/gh/appocular/clients-laravel)
