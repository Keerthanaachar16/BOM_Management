<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseIntentBatch extends Model
{
    protected $fillable = [
        'bom_header_id',
        'batch_number'
    ];

    public function bomHeader()
    {
        return $this->belongsTo(BomHeader::class);
    }

    public function purchaseIntents()
    {
        return $this->hasMany(PurchaseIntent::class);
    }
}