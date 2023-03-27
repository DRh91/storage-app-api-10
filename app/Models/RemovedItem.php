<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 * @property int $id
 * @package App\Models
 */
class RemovedItem extends Model
{
    public function barcodeInfo()
    {
        return $this->belongsTo(BarcodeInfo::class, 'id_barcode_info');
    }
}
