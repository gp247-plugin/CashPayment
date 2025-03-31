<?php
use Illuminate\Support\Facades\Route;

$config = file_get_contents(__DIR__.'/gp247.json');
$config = json_decode($config, true);

if(gp247_extension_check_active($config['configGroup'], $config['configKey'])) {


    Route::group(
    [
        'middleware' => GP247_FRONT_MIDDLEWARE,
        'prefix'    => 'plugin/shippingstandard',
        'namespace' => 'App\GP247\Plugins\CashPayment\Controllers',
    ],
    function () {
        Route::get('index', 'FrontController@index')
        ->name('shippingstandard.index');
    }
);

    Route::group(
        [
            'prefix' => GP247_ADMIN_PREFIX.'/shippingstandard',
            'middleware' => GP247_ADMIN_MIDDLEWARE,
            'namespace' => '\App\GP247\Plugins\CashPayment\Admin',
        ], 
        function () {
            Route::get('/', 'AdminController@index')
            ->name('admin_shippingstandard.index');
        }
    );
}