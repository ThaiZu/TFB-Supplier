<?php
namespace App\Supplier\app\Services\Catalog;

use App\Supplier\app\Repositories\Catalog\CategoryRepository;
use App\Supplier\core\Support\GlobalRegistry;

class CategoryService
{
    public function __construct(
        private CategoryRepository $catalogCategoryRepository
    )
    {
    }

    public function getAll(): array
    {
        return $this->catalogCategoryRepository->getAll((int) GlobalRegistry::get('user')['supplier_id']);
    }

    public function insert(array $data): array
    {
        return $this->catalogCategoryRepository->insert((int) GlobalRegistry::get('user')['supplier_id'], $data);
    }

    public function update(int $id, array $data): array
    {
        return $this->catalogCategoryRepository->update((int) GlobalRegistry::get('user')['supplier_id'], $id, $data);
    }

    public function delete(int $id): array
    {
        return $this->catalogCategoryRepository->delete((int) GlobalRegistry::get('user')['supplier_id'], $id);
    }
}
