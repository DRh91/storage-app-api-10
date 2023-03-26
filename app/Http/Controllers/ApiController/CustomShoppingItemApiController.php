<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomShoppingItemResource;
use App\Http\Resources\CustomShoppingItemResourceCollection;
use App\Models\CustomShoppingItem;
use Illuminate\Http\Request;

class CustomShoppingItemApiController extends BaseApiController
{
    public function __construct()
    {
        parent::__construct(
            CustomShoppingItem::class,
            CustomShoppingItemResource::class,
            CustomShoppingItemResourceCollection::class,
            'custom_shopping_items'
        );
    }


    protected function validateEntity(Request $request)
    {
        return $request->validate(
            [
            ]
        );
    }

}
