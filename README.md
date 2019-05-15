# Keeper Laravel

Laravel/Lumen service provider for Keeper.

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

[![](https://img.shields.io/travis/com/appocular/keeper-laravel.svg?style=for-the-badge)](https://travis-ci.com/appocular/keeper-laravel)
[![](https://img.shields.io/codecov/c/github/appocular/keeper-laravel.svg)](https://codecov.io/gh/appocular/keeper-laravel)
