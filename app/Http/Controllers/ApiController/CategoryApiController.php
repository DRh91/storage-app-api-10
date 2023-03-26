<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryResourceCollection;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryApiController extends BaseApiController
{
    public function __construct()
    {
        parent::__construct(
            Category::class,
            CategoryResource::class,
            CategoryResourceCollection::class,
            'categories'
        );
    }

    private function insertCategory(string $categoryName, array $children, ?int $parentId): void
    {
        $categoryId = DB::table('categories')->where('name', '=', $categoryName)->get()[0]?->id ?? null;
        if (isset($categoryId)) {
            DB::table('categories')->where('id', '=', $categoryId)->update(['name' => $categoryName, 'parent_id' => $parentId]);
        }
        else {
            DB::table('categories')->insert(['name' => $categoryName, 'parent_id' => $parentId]);
            $categoryId = DB::table('categories')->where('name', '=', $categoryName)->get()[0]->id;
        }
        foreach ($children as $categoryKey => $children) {
            $this->insertCategory(explode('$', $categoryKey)[0], $children, $categoryId);
        }
    }

    protected function validateEntity(Request $request)
    {
        return $request->validate([]);
    }

    protected function updateCategoryTree(Request $request)
    {
        $categories = $request->get('tree');
        foreach ($categories as $categoryName => $children) {
            echo $categoryName . PHP_EOL;
            $this->insertCategory(explode('$', $categoryName)[0], $children, null);
        }
    }
}
