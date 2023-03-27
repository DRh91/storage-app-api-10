<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Resources\BarcodeInfoResource;
use App\Http\Resources\BarcodeInfoResourceCollection;
use Illuminate\Http\Request;
use App\Models\BarcodeInfo;
use Illuminate\Http\Resources\Json\JsonResource;

class BarcodeInfoApiController extends BaseApiController
{
    public function __construct()
    {
        parent::__construct(
            BarcodeInfo::class,
            BarcodeInfoResource::class,
            BarcodeInfoResourceCollection::class,
            'barcode_infos'
        );
    }

    protected function validateEntity(Request $request)
    {
        return $request->validate(
            [
                'barcode'    => 'required',
                'name'       => 'required',
                'brand'      => 'required',
            ]
        );
    }

    public function search(Request $request)
    {
        $barcode = $request->get('barcode') ?? null;
        $barcodeInfoClass = BarcodeInfo::class;
        $barcodeInfo = $barcodeInfoClass::where('barcode', '=', $barcode)->first();
        if ($barcodeInfo === null) {
            return new JsonResource([]);
        }
        return new $this->entityResourceCollectionClass([$barcodeInfo]);
    }
}
