<?php


use FastRoute\RouteCollector;

return function(RouteCollector $r) {

    // VIEW
    $r->addRoute('GET', '/catalog', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogController::class,
        'method'     => 'index'
    ]);



    // AJAX: products
    $r->addRoute('GET', '/ajax/catalog/categories', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogCategoryController::class,
        'method'     => 'ajaxGetAll'
    ]);

    $r->addRoute('POST', '/ajax/catalog/categories', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogCategoryController::class,
        'method'     => 'ajaxInsert'
    ]);

    $r->addRoute('PATCH', '/ajax/catalog/categories/{id:\d+}', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogCategoryController::class,
        'method'     => 'ajaxUpdate'
    ]);

    $r->addRoute('DELETE', '/ajax/catalog/categories/{id:\d+}', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogCategoryController::class,
        'method'     => 'ajaxDelete'
    ]);

    $r->addRoute('GET', '/ajax/catalog/products', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogProductController::class,
        'method'     => 'ajaxGetAll'
    ]);

    $r->addRoute('POST', '/ajax/catalog/products', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogProductController::class,
        'method'     => 'ajaxInsert'
    ]);

    $r->addRoute('POST', '/ajax/catalog/products/{id:\d+}/specification', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogProductController::class,
        'method'     => 'ajaxUpdateSpecification'
    ]);

    $r->addRoute('POST', '/ajax/catalog/products/import', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogProductController::class,
        'method'     => 'ajaxImport'
    ]);

    $r->addRoute('PUT', '/ajax/catalog/products/{id:\d+}', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogProductController::class,
        'method'     => 'ajaxUpdate'
    ]);

    $r->addRoute('PUT', '/ajax/catalog/products/{id:\d+}/availability', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogProductController::class,
        'method'     => 'ajaxUpdateAvailability'
    ]);

    $r->addRoute('DELETE', '/ajax/catalog/products/{id:\d+}', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogProductController::class,
        'method'     => 'ajaxDelete'
    ]);



    $r->addRoute('POST', '/ajax/catalog/products/{productId:\d+}/allergens', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogProductController::class,
        'method'     => 'ajaxAssignAllergen'
    ]);

    $r->addRoute('DELETE', '/ajax/catalog/products/{productId:\d+}/allergens/{allergenId:\d+}', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogProductController::class,
        'method'     => 'ajaxUnassignAllergen'
    ]);

    $r->addRoute('POST', '/ajax/catalog/products/{id:\d+}/photo', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogProductController::class,
        'method'     => 'ajaxUploadPhoto'
    ]);

    $r->addRoute('DELETE', '/ajax/catalog/products/{id:\d+}/photo', [
        'controller' => \App\Supplier\app\Http\Controllers\Catalog\CatalogProductController::class,
        'method'     => 'ajaxDeletePhoto'
    ]);
};
