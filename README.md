# Example RESTful API using Laravel Lumen

Best practice for building restful api, and improve error handling

## Authentication and Authorization

<a>https://dev.to/ndiecodes/build-a-jwt-authenticated-api-with-lumen-2afm
</a>

### database

- create migration

```
php artisan make:migration create_users_table
```

- create seeders

```
php artisan make:seeder UsersTableSeeder
php artisan migrate
php artisan db:seed --class=UsersTableSeeder
```

### configure jwt

```
composer require tymon/jwt-auth:1.0.1
composer require lcobucci/jwt:3.3.3
```

- create file config/auth.php
- edit user model to implement JWTSubject

### bootstrap/app.php

```php
$app->routeMiddleware([
    'auth' => App\Http\Middleware\Authenticate::class,
]);
$app->register(App\Providers\AuthServiceProvider::class);
$app->register(\Tymon\JWTAuth\Providers\LumenServiceProvider::class);
```
```
php artisan jwt:secret
```

### controllers

- create AuthController.php
- create UserController.php (use middleware('auth'))

### routes

- update routes

## Tutorial

- create migration for barangs table <br>

```
php artisan make:migration create_barangs_table
```

- create model, <code>Barang.php</code>

- create seeder <br>

```
php artisan make:seeder BarangsTableSeeder
```

- run migrate <br>

```
php artisan migrate
```

- run seeder <br>

```
php artisan db:seed
// or
php artisan db:seed --class=BarangsTableSeeder
```

- create controller, <code>BarangController.php</code>

- update router <br>

```php
$router->group(['prefix' => 'api/'], function () use($router){
    // barang
    $router->get('barangs', 'BarangController@index');
    $router->post('barang', 'BarangController@create');
    $router->get('barang/{id}', 'BarangController@show');
    $router->put('barang/{id}', 'BarangController@update');
    $router->delete('barang/{id}', 'BarangController@destroy');
});
```

- Testing
