<?php

namespace App\Supplier\app\Http\Controllers\Catalog;

use App\Supplier\app\Http\Controllers\Controller;
use App\Supplier\app\Services\Catalog\CategoryService;
use Symfony\Component\HttpFoundation\Request;

class CatalogCategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService)
    {
    }

    public function ajaxGetAll()
    {
        return $this->json(['success' => true, 'data' => $this->categoryService->getAll()]);
    }

    public function ajaxInsert()
    {
        $response = $this->categoryService->insert($this->getJson(Request::createFromGlobals()));
        return $this->json($response, $response['code'] ?? 200);
    }

    public function ajaxUpdate(int $id)
    {
        $response = $this->categoryService->update($id, $this->getJson(Request::createFromGlobals()));
        return $this->json($response, $response['code'] ?? 200);
    }

    public function ajaxDelete(int $id)
    {
        $response = $this->categoryService->delete($id);
        return $this->json($response, $response['code'] ?? 200);
    }
}
