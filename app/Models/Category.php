<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $shopping_quantity
 * @property int $target_item_count
 * @property int $parent_id
 * @property string $name
 */
class Category extends Model
{
    protected $fillable = [
        'name', 'shopping_quantity', 'target_item_count', 'parent_id'
    ];
}
