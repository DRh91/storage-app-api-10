<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class StorageItemInfo
 *
 *
 * @property int $id
 * @property string $name
 * @property string $barcode
 * @property string $brand
 * @property string $imageUrl
 * @property string $keywords
 * @property int $amount
 * @property string $unit

 * @package App\Models
 */
class StorageItemInfo extends Model
{
    protected $fillable = [
        'barcode', 'name', 'brand', 'imageUrl', 'keywords', 'amount', 'unit'
    ];


}
