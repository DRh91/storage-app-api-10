<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StorageItemInfo
 *
 *
 * @property int $id
 * @property string $name
 * @property string $barcode
 * @property boolean $isCustom
 * @property string $brand
 * @property string $imageUrl
 * @property string $keywords
 * @property int $idCategory
 * @property int $unitQuantity
 * @property int $shelf
 * @property array $ratings
 * @property string $unit

 * @package App\Models
 */
class BarcodeInfo extends Model
{
    protected $fillable = [
        'barcode', 'isCustom', 'name', 'brand', 'imageUrl', 'keywords', 'idCategory', 'unitQuantity','unitQuantityDrained', 'unit', 'ratings', 'shelf'
    ];

    protected $casts = [
        'shoppingQuantity' => 'integer',
        'shoppingPriority' => 'integer',
        'unitQuantity' => 'integer',
        'shelf' => 'integer',
        'ratings' => 'array'
    ];
}
