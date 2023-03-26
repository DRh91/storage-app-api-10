<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int $id
 * @property string $name
 * @property string $barcode
 * @property string $brand
 * @property string $imageUrl
 * @property string $keywords
 * @property string $category
 * @property int $unitQuantity
 * @property int $shelf
 * @property array $ratings
 * @property string $unit

 *
 * @package App\Models
 */
class RemovedItem extends Model
{
    public function barcodeInfo(){
        return $this->belongsTo(BarcodeInfo::class, 'idBarcodeInfo');
    }
}
