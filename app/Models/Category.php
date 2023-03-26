<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $parent_id
 * @property string $name
 */
class Category extends Model
{
    protected $fillable = [
        'name', 'parent_id'
    ];
}
