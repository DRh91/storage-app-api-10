<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Resources\StorageItemResource;
use App\Http\Resources\StorageItemResourceCollection;
use App\Models\BarcodeInfo;
use App\Models\StorageItem;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class StorageItemApiController extends BaseApiController
{
    public function __construct()
    {
        parent::__construct(
            StorageItem::class,
            StorageItemResource::class,
            StorageItemResourceCollection::class,
            'storage_items'
        );
    }


    protected function validateEntity(Request $request)
    {
        return $request->validate(
            [
//                'idBarcodeInfo' => 'required',
            ]
        );
    }

    public function syncStore(Request $request): ResourceCollection
    {
        $amountToCreate = $request->input('amount') ?? 0;
        $idBarcodeInfo = BarcodeInfo::where('barcode', '=', $request->get("barcode"))->first()->id;
        $request->query->set("idBarcodeInfo", $idBarcodeInfo);
        $entities = [];
        for ($i = 0; $i < $amountToCreate; $i++) {
            $entity = $this->modelClass::create($request->all());
            $entities[] = $entity;
        }

        return new $this->entityResourceCollectionClass($entities);
    }

    public function store(Request $request): ResourceCollection
    {
        $id = $request->get("id") ?? null;
        $idBarcodeInfo = BarcodeInfo::where('barcode', '=', $request->get("barcode"))->first()->id;
        $request->query->set("idBarcodeInfo", $idBarcodeInfo);
        $request->request->remove('barcode');
        $requestHasId = $id !== null;

        # store best before date duration
        $bestBeforeDate = $request->get("bestBeforeDate");
        if ($bestBeforeDate !== null && $id === null) {
            $bestBeforeDate = (new DateTime($bestBeforeDate))->getTimestamp();
            $now = (new DateTime('now'))->getTimestamp();
            // 1 day = 24 hours -> 24 * 60 * 60 = 86400 seconds
            $diffInDays = round(($bestBeforeDate - $now) / 86400);
            if ($diffInDays > 0) {
                DB::table('barcode_info_best_before_date_durations')->insert(
                    array('idBarcodeInfo' => $idBarcodeInfo, 'bestBeforeDateDurationInDays' => $diffInDays)
                );
            }
        }

        if ($requestHasId) {
            $this->validateEntity($request);
            return $this->update($id, $request);
        } else {
            $this->validateEntity($request);
            $entity = $this->modelClass::create($request->all());
            return new $this->entityResourceCollectionClass([$entity]);
        }
    }


    public function destroy($entityId)
    {
        /** @var StorageItem $entity */
        $entity = $this->modelClass::where('id', '=', $entityId)->first();
        $idBarcodeInfo = $entity->idBarcodeInfo;

        DB::table('removed_items')->insert(
            array('idBarcodeInfo' => $idBarcodeInfo, 'idStorageItem' => $entityId)
        );

        return parent::destroy($entityId);
    }

    public function search(Request $request)
    {
        $barcode = $request->get('barcode') ?? null;
        $barcodeInfoClass = BarcodeInfo::class;
        $barcodeInfo = $barcodeInfoClass::where('barcode', '=', $barcode)->first();
        if ($barcodeInfo === null) {
            return new $this->entityResourceCollectionClass([]);
        }
        $idBarcodeInfo = $barcodeInfo->id;
        $storageItems = $this->modelClass::where('idBarcodeInfo', '=', $idBarcodeInfo)->get();
        return new $this->entityResourceCollectionClass($storageItems);
    }

    public function lastChange(Request $request, ?string $table = null)
    {
        /**
         * The parent provides the latest change of a CHANGED storage item.
         * If a storage item was removed the parent does not provided the _actual_ last change of this table.
         * That's why we have to use the removed item last change - if an item was deleted the actual lastChange must be read from the
         * removed items table.
         */

        $storageItemChange = parent::lastChange($request)['lastChange'];
        $removedItemChange = parent::lastChange($request, 'removed_items')['lastChange'];
        $latestChange = $storageItemChange > $removedItemChange ? $storageItemChange : $removedItemChange;
        return ['lastChange' => $latestChange];
    }


}
