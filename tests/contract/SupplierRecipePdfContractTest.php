<?php

declare(strict_types=1);

require __DIR__ . '/../../vendor/autoload.php';

use App\Supplier\app\Repositories\Recipe\RecipeRepository;
use App\Supplier\core\Http\ApiClient;

final class RecipePdfCapturingApiClient extends ApiClient
{
    public array $calls = [];

    public function __construct()
    {
    }

    public function get($endpoint, $decode_json = true)
    {
        $this->calls[] = ['endpoint' => $endpoint, 'decode_json' => $decode_json];
        return ['success' => true, 'data' => '%PDF', 'filename' => 'baguette-recipe.pdf'];
    }
}

function assertRecipePdfContract(mixed $expected, mixed $actual, string $message): void
{
    if ($expected !== $actual) {
        fwrite(STDERR, $message . PHP_EOL);
        exit(1);
    }
}

$client = new RecipePdfCapturingApiClient();
$repository = new RecipeRepository($client);
$repository->getPdf(7, 11);

assertRecipePdfContract(['endpoint' => '/material-suppliers/7/recipes/11/pdf', 'decode_json' => false], $client->calls[0], 'recipe PDF endpoint mismatch');

$view = file_get_contents(__DIR__ . '/../../src/app/Views/recipes/index.twig');
assertRecipePdfContract(true, str_contains($view, '/recipes/${r.id}/pdf'), 'recipe list does not expose the PDF download action');
assertRecipePdfContract(true, str_contains($view, 'recipes_download_pdf'), 'recipe PDF action is not translated');

$routes = file_get_contents(__DIR__ . '/../../src/core/Bootstrap/Routes/RecipeRoutes.php');
assertRecipePdfContract(true, str_contains($routes, "/recipes/{id:\\d+}/pdf"), 'supplier recipe PDF route is missing');

echo "Supplier recipe PDF contract tests passed.\n";
