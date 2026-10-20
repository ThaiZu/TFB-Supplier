<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use App\Supplier\app\Repositories\Catalog\CategoryRepository;
use App\Supplier\core\Http\ApiClient;

final class CatalogCategoryCapturingApiClient extends ApiClient
{
    public array $calls = [];

    public function __construct()
    {
    }

    public function get($endpoint, $decode_json = true)
    {
        $this->calls[] = ['method' => 'GET', 'endpoint' => $endpoint, 'payload' => null];
        return ['success' => true, 'data' => [['id' => 3, 'name' => 'Frozen']]];
    }

    public function post($endpoint, $data)
    {
        $this->calls[] = ['method' => 'POST', 'endpoint' => $endpoint, 'payload' => $data];
        return ['success' => true, 'code' => 201, 'data' => []];
    }

    public function patch($endpoint, $data)
    {
        $this->calls[] = ['method' => 'PATCH', 'endpoint' => $endpoint, 'payload' => $data];
        return ['success' => true, 'code' => 200, 'data' => []];
    }

    public function delete($endpoint)
    {
        $this->calls[] = ['method' => 'DELETE', 'endpoint' => $endpoint, 'payload' => null];
        return ['success' => true, 'code' => 200, 'data' => []];
    }
}

function catalogAssertSame(mixed $expected, mixed $actual, string $message): void
{
    if ($expected !== $actual) {
        fwrite(STDERR, $message . PHP_EOL);
        exit(1);
    }
}

$client = new CatalogCategoryCapturingApiClient();
$repository = new CategoryRepository($client);
$categories = $repository->getAll(7);
$repository->insert(7, ['name' => 'Frozen']);
$repository->update(7, 3, ['name' => 'Fresh']);
$repository->delete(7, 3);

catalogAssertSame('Frozen', $categories[0]->getName(), 'Category list is not mapped to category models.');
catalogAssertSame(['method' => 'GET', 'endpoint' => '/material-suppliers/7/catalog/categories', 'payload' => null], $client->calls[0], 'Category list endpoint mismatch.');
catalogAssertSame(['method' => 'POST', 'endpoint' => '/material-suppliers/7/catalog/categories', 'payload' => ['name' => 'Frozen']], $client->calls[1], 'Category create endpoint mismatch.');
catalogAssertSame(['method' => 'PATCH', 'endpoint' => '/material-suppliers/7/catalog/categories/3', 'payload' => ['name' => 'Fresh']], $client->calls[2], 'Category update endpoint mismatch.');
catalogAssertSame(['method' => 'DELETE', 'endpoint' => '/material-suppliers/7/catalog/categories/3', 'payload' => null], $client->calls[3], 'Category delete endpoint mismatch.');

$view = file_get_contents(__DIR__ . '/../../src/app/Views/catalog/catalog.twig');
catalogAssertSame(true, str_contains($view, 'id="filterCategory"'), 'Catalog does not render the category filter.');
catalogAssertSame(true, str_contains($view, 'id="productCategory"') === false, 'Product category input must remain in the product modal.');
catalogAssertSame(true, str_contains(file_get_contents(__DIR__ . '/../../src/app/Views/catalog/modals/product_manage.twig'), 'id="productCategory"'), 'Product modal does not render the category selector.');
catalogAssertSame(true, str_contains($view, 'id="categoryModal"'), 'Catalog does not render category CRUD modal.');

echo "Supplier catalog category contract tests passed.\n";
