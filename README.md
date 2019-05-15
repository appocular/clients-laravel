# Appocular clients for Laravel/Lumen

Laravel/Lumen service providers for Appocular services.

## Keeper

Registering service provider in Lumen:
``` php
$app->register(Appocular\Clients\KeeperServiceProvider::class);
$app->configure('keeper');
```

To configure, add a `config/keeper.php` file:

``` php
<?php

return [
    'base_uri' => env('KEEPER_BASE_URI', ''),
];
```

[![](https://img.shields.io/travis/com/appocular/clients-laravel.svg?style=for-the-badge)](https://travis-ci.com/appocular/clients-laravel)
[![](https://img.shields.io/codecov/c/github/appocular/clients-laravel.svg)](https://codecov.io/gh/appocular/keeper-laravel)
