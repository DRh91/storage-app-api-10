<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;


/**
 * Class StorageItem
 *
 * @property int $id
 * @property DateTime $bestBeforeDate
 * @property string $barcode
 * @property int $state
 *
 * @package App\Models
 */
class StorageItem extends Model
{
    protected $fillable = [
        'bestBeforeDate', 'idBarcodeInfo', 'state'
    ];

    public function barcodeInfo(){
        return $this->belongsTo(BarcodeInfo::class, 'idBarcodeInfo');
    }
}
