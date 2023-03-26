<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Resources\RemovedItemResource;
use App\Http\Resources\RemovedItemResourceCollection;
use App\Models\RemovedItem;
use Illuminate\Http\Request;

class RemovedItemsApiController extends BaseApiController
{
    public function __construct()
    {
        parent::__construct(
            RemovedItem::class,
            RemovedItemResource::class,
            RemovedItemResourceCollection::class,
            'removed_items'
        );
    }

    protected function validateEntity(Request $request)
    {

    }
}
