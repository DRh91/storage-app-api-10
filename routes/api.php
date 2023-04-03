<?php

use App\Http\Controllers\ApiController\AuthenticationController;
use App\Http\Controllers\ApiController\BarcodeInfoApiController;
use App\Http\Controllers\ApiController\CategoryApiController;
use App\Http\Controllers\ApiController\CustomShoppingItemApiController;
use App\Http\Controllers\ApiController\ExceptionUploadController;
use App\Http\Controllers\ApiController\ImageUploadController;
use App\Http\Controllers\ApiController\RemovedItemsApiController;
use App\Http\Controllers\ApiController\StorageItemApiController;
use Illuminate\Support\Facades\Route;

# auth
Route::post('/auth/token', [AuthenticationController::class, 'generateToken']);

# exceptions
Route::post('/upload/exception', [ExceptionUploadController::class, 'upload']);

# images
Route::post('/upload/image', [ImageUploadController::class, 'upload'])->middleware(['auth:sanctum']);

# barcode infos
Route::post('/barcode-infos/search', [BarcodeInfoApiController::class, 'search'])->middleware(['auth:sanctum']);
Route::get('/barcode-infos/last-change', [BarcodeInfoApiController::class, 'lastChange'])->middleware(['auth:sanctum']);
Route::get('/barcode-infos/count', [BarcodeInfoApiController::class, 'count'])->middleware(['auth:sanctum']);
Route::apiResource('/barcode-infos', BarcodeInfoApiController::class)->middleware(['auth:sanctum']);

# storage items
Route::post('/storage-items/sync', [StorageItemApiController::class, 'syncStore'])->middleware(['auth:sanctum']);
Route::post('/storage-items/search', [StorageItemApiController::class, 'search'])->middleware(['auth:sanctum']);
Route::get('/storage-items/last-change', [StorageItemApiController::class, 'lastChange'])->middleware(['auth:sanctum']);
Route::get('/storage-items/count', [StorageItemApiController::class, 'count'])->middleware(['auth:sanctum']);
Route::apiResource('/storage-items', StorageItemApiController::class)->middleware(['auth:sanctum']);

# custom shopping items
Route::get('/custom-shopping-items/last-change', [CustomShoppingItemApiController::class, 'lastChange'])->middleware(['auth:sanctum']);
Route::get('/custom-shopping-items/count', [CustomShoppingItemApiController::class, 'count'])->middleware(['auth:sanctum']);
Route::apiResource('/custom-shopping-items', CustomShoppingItemApiController::class)->middleware(['auth:sanctum']);

# categories
Route::get('/categories/last-change', [CategoryApiController::class, 'lastChange'])->middleware(['auth:sanctum']);
Route::get('/categories/count', [CategoryApiController::class, 'count'])->middleware(['auth:sanctum']);
Route::post('/categories/update-tree', [CategoryApiController::class, 'updateCategoryTree'])->middleware(['auth:sanctum']);
Route::apiResource('/categories', CategoryApiController::class)->middleware(['auth:sanctum']);

# removed items
Route::get('/removed-items', [RemovedItemsApiController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('/removed-items/count', [RemovedItemsApiController::class, 'count'])->middleware(['auth:sanctum']);
Route::get('/removed-items/last-change', [RemovedItemsApiController::class, 'lastChange'])->middleware(['auth:sanctum']);
