<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomShoppingItem
 *
 * @property int $shoppingQuantity
 * @property int $shoppingPriority
 * @property string $name
 * @package App\Models
 */
class CustomShoppingItem extends Model
{
    protected $fillable = [
        'shoppingQuantity', 'shoppingPriority', 'name'
    ];

    protected $casts = [
        'shoppingQuantity' => 'integer',
        'shoppingPriority' => 'integer'
    ];

}
