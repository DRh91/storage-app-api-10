<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class StorageItemInfo
 *
 *
 * @property int $id
 * @property string $name
 * @property string $barcode
 * @property boolean $is_custom
 * @property string $brand
 * @property string $image_url
 * @property string $keywords
 * @property int $id_category
 * @property int $unit_quantity
 * @property int $unit_quantity_drained
 * @property int $shelf
 * @property array $ratings
 * @property string $unit

 * @package App\Models
 */
class BarcodeInfo extends Model
{
    protected $fillable = [
        'barcode', 'is_custom', 'name', 'brand', 'image_url', 'keywords', 'id_category', 'unit_quantity','unit_quantity_drained', 'unit', 'ratings', 'shelf'
    ];

    protected $casts = [
        'shopping_quantity' => 'integer',
        'shopping_priority' => 'integer',
        'unit_quantity' => 'integer',
        'shelf' => 'integer',
        'ratings' => 'array'
    ];
}
