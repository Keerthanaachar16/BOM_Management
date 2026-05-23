<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseIntent extends Model
{
    protected $fillable = [
        'purchase_intent_batch_id',
        'item_code',
        'description',
        'specification',
        'required_quantity',
        'available_quantity',
        'shortfall_quantity',
        'status',
        'date_raised'
    ];

    protected $casts = [
        'date_raised' => 'date'
    ];

    public function batch()
    {
        return $this->belongsTo(PurchaseIntentBatch::class);
    }
}
