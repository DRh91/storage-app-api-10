<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CustomShoppingItem
 *
 * @property int $shopping_quantity
 * @property int $shopping_priority
 * @property string $name
 * @package App\Models
 */
class CustomShoppingItem extends Model
{
    protected $fillable = [
        'shopping_quantity', 'shopping_priority', 'name'
    ];

    protected $casts = [
        'shopping_quantity' => 'integer'
    ];

}
