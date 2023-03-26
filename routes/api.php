<?php

use App\Http\Controllers\ApiController\BarcodeInfoApiController;
use App\Http\Controllers\ApiController\CategoryApiController;
use App\Http\Controllers\ApiController\CustomShoppingItemApiController;
use App\Http\Controllers\ApiController\ExceptionUploadController;
use App\Http\Controllers\ApiController\ImageUploadController;
use App\Http\Controllers\ApiController\RemovedItemsApiController;
use App\Http\Controllers\ApiController\StorageItemApiController;
use App\Http\Middleware\CompressResponseMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Laravel\Sanctum\Sanctum;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

# exceptions
Route::post('/upload/exception', [ExceptionUploadController::class, 'upload']);

# images
Route::post('/upload/image', [ImageUploadController::class, 'upload']);

# barcode infos
Route::post('/search/barcode-infos', [BarcodeInfoApiController::class, 'search']);
Route::get('/lastChange/barcode-infos', [BarcodeInfoApiController::class, 'lastChange']);
Route::get('/count/barcode-infos', [BarcodeInfoApiController::class, 'count']);
Route::apiResource('/barcode-infos', BarcodeInfoApiController::class, ['middleware' => CompressResponseMiddleware::class]);

# storage items
Route::post('/sync/storage-items', [StorageItemApiController::class, 'syncStore']);
Route::post('/search/storage-items', [StorageItemApiController::class, 'search']);
Route::get('/lastChange/storage-items', [StorageItemApiController::class, 'lastChange']);
Route::get('/count/barcode-infos', [BarcodeInfoApiController::class, 'count']);
Route::apiResource('/storage-items', StorageItemApiController::class);

# custom shopping items
Route::get('/lastChange/custom-shopping-items', [CustomShoppingItemApiController::class, 'lastChange']);
Route::get('/count/custom-shopping-items', [CustomShoppingItemApiController::class, 'count']);
Route::apiResource('/custom-shopping-items', CustomShoppingItemApiController::class,
                   ['middleware' => CompressResponseMiddleware::class]);

//@todo: last change and count to api resource


# categories
Route::get('/lastChange/categories', [CategoryApiController::class, 'lastChange'])->middleware(['auth:sanctum']);
Route::get('/count/categories', [CategoryApiController::class, 'count'])->middleware(['auth:sanctum']);
Route::post('/categories/update-tree', [CategoryApiController::class, 'updateCategoryTree'])->middleware(['auth:sanctum']);
Route::apiResource('/categories', CategoryApiController::class)->middleware(['auth:sanctum']);

# removed items
Route::get('/count/removed-items', [RemovedItemsApiController::class, 'count']);
Route::get('/removed-items', [RemovedItemsApiController::class, 'index'], ['middleware' => CompressResponseMiddleware::class]);
Route::get('/lastChange/removed-items', [RemovedItemsApiController::class, 'lastChange']);

Route::post('/sanctum/token', function (Request $request) {
    $request->validate(
        [
            'name'     => 'required',
            'email'    => 'required|email',
            'password' => 'required'
        ]
    );

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
                                                    'email' => ['The provided credentials are incorrect.'],
                                                ]);
    }

    return $user->createToken($request->name, ['*'],)->plainTextToken;
});


