<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;


/**
 * Class StorageItem
 *
 * @property int $id
 * @property DateTime $best_before_date
 * @property string $barcode
 * @property int $state
 *
 * @package App\Models
 */
class StorageItem extends Model
{
    protected $fillable = [
        'best_before_date', 'id_barcode_info', 'state'
    ];

    public function barcodeInfo(){
        return $this->belongsTo(BarcodeInfo::class, 'id_barcode_info');
    }
}
