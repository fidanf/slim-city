<?php

use App\Controllers\Villes\VilleController;
use App\Controllers\HomeController;
use App\Middlewares\CorsMiddleware;

/**
 * Web Routes
 */

$app->group('/', function () {
	$this->get('', [HomeController::class, 'index'])->setName('home');
});

/**
 * Api Routes
 */

$app->group('/api', function() {
    $this->get('/departements', [VilleController::class, 'departements']);
    $this->get('/villes/{departement}', [VilleController::class, 'communes']);
});

/**
 * Global Middlewares
 */

$app->add($container->get(CorsMiddleware::class));
