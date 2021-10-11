# Example RESTful API using Laravel Lumen

Best practice for building restful api, and improve error handling

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
