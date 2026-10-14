<?php
namespace App\Supplier\app\Repositories\Catalog;


use App\Supplier\app\Models\Catalog\CategoryModel;
use App\Supplier\core\Http\ApiClient;

class CategoryRepository
{
    public function __construct(
        private ApiClient $apiClient
    )
    {
    }

    public function getAll(int $supplierId): array
    {

        $response = $this->apiClient->get("/material-suppliers/$supplierId/catalog/categories");

        $objects = [];
        if(isset($response['data'])){
            foreach ($response['data'] as $object){
                $objects[] = new CategoryModel($object);
            }
        }

        return $objects;
    }

    public function insert(int $supplierId, array $data): array
    {
        return $this->apiClient->post("/material-suppliers/{$supplierId}/catalog/categories", $data);
    }

    public function update(int $supplierId, int $id, array $data): array
    {
        return $this->apiClient->patch("/material-suppliers/{$supplierId}/catalog/categories/{$id}", $data);
    }

    public function delete(int $supplierId, int $id): array
    {
        return $this->apiClient->delete("/material-suppliers/{$supplierId}/catalog/categories/{$id}");
    }


}
