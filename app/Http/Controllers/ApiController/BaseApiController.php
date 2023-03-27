<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

abstract class BaseApiController extends Controller
{
    // http://127.0.0.1:8000/api/search/category?XDEBUG_SESSION_START=PHPSTORM
    // http://localhost/budgetbook_laravel/budgetbook/public/api/accounts?idUser=0&XDEBUG_SESSION_START=PHPSTORM

    //    php artisan make:controller ApiController/BaseApiController
    //    php artisan make:controller ApiController/CategoryApiController
    //    php artisan make:controller ApiController/StorageItemApiController
    //    php artisan make:model Category
    //    php artisan make:model StorageItem
    //    php artisan make:resource CategoryResource
    //    php artisan make:resource CategoryResourceCollection --collection
    //    php artisan make:resource StorageItemResource
    //    php artisan make:resource StorageItemResourceCollection --collection

    protected string $entityResourceClass;
    protected string $entityResourceCollectionClass;
    protected string $modelClass;
    protected string $tableName;

    public function __construct(
        string $modelClass,
        string $entityResourceClass,
        string $entityResourceCollectionClass,
        string $tableName)
    {
        $this->modelClass = $modelClass;
        $this->entityResourceClass = $entityResourceClass;
        $this->entityResourceCollectionClass = $entityResourceCollectionClass;
        $this->tableName = $tableName;
    }

    /**
     * Get all entities with a GetRequest (http://127.0.0.1:8000/api/entity)
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function index(Request $request): ResourceCollection
    {
        $perPage = $request->input('perPage') ?? 25;
        $page = $request->get('page') ?? 1;
        $lastChange = $request->get('lastChange') ?? '1900-01-01 00:00:00';
        $entities = (new $this->modelClass())::query()->where('created_at', '>=', $lastChange)->orWhere('updated_at', '>=', $lastChange)->paginate($perPage, ['*'], null, $page);
        return new $this->entityResourceCollectionClass($entities);
    }


    /**
     * Get entity by id with a GetRequest (http://127.0.0.1:8000/api/entity/{id})
     *
     * @param int $entityId
     * @return JsonResource
     */
    public function show(int $entityId): JsonResource
    {
        $entityId = $this->modelClass::where('id', '=', $entityId)->first();
        return new $this->entityResourceClass($entityId);
    }


    /**
     * Create new entity / update existing entity with a PostRequest (http://127.0.0.1:8000/api/entity) with data as json body.
     *
     * @param Request $request
     * @return ResourceCollection
     */
    public function store(Request $request): ResourceCollection
    {
        $request->query->remove('XDEBUG_SESSION_START');

        $id = $request->get("id") ?? null;
        $requestHasId = $id !== null;
        if ($requestHasId) {
            $this->validateEntity($request);
            $entity = $this->modelClass::where('id', '=', $id)->first() ?? null;
            if ($entity === null) {
                throw new InvalidArgumentException('Entity with id ' . $id . ' could not be found');
            }
            return $this->update($id, $request);
        } else {
            $this->validateEntity($request);
            $entity = $this->modelClass::create($request->all());
            return new $this->entityResourceCollectionClass([$entity]);
        }
    }

    /**
     * Update an entity with a PatchRequest (http://127.0.0.1:8000/api/entity/{id}) with data as json body.
     *
     * @param $entity
     * @param Request $request
     * @return ResourceCollection
     */
    public function update($entity, Request $request): ResourceCollection
    {
        DB::table($this->tableName)
          ->where('id', '=', $entity)
          ->update($request->all());

        return new $this->entityResourceCollectionClass([$this->modelClass::where('id', '=', $entity)->first()]);
    }


    /**
     * Delete an entity by id with a DeleteRequest (http://127.0.0.1:8000/api/entity/{id})
     *
     * @return JsonResponse
     */
    public function destroy($entity)
    {
        DB::table($this->tableName)->delete($entity);
        return new $this->entityResourceCollectionClass([]);
    }

    public function lastChange(Request $request, ?string $table = null)
    {
        $lastCreate = DB::table($table ?? $this->tableName)->max('created_at');
        $lastUpdate = DB::table($table ?? $this->tableName)->max('updated_at');
        $latestChange = $lastCreate > $lastUpdate ? $lastCreate : $lastUpdate;
        return ['last_change' => $latestChange];
    }

    public function count(Request $request)
    {
        return ['count' => DB::table($this->tableName)->count('id')];
    }

    protected function validateEntity(Request $request)
    {
        return $request->validate([]);
    }
}
