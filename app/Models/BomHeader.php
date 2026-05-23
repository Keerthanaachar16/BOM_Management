<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BomHeader extends Model
{
    protected $fillable = [
        'project_id',
        'bom_number',
        'version',
        'uploaded_file',
        'uploaded_at',
        'uploaded_by',
        'is_locked'
    ];

    protected $casts = [
        'uploaded_at' => 'datetime'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function lineItems()
    {
        return $this->hasMany(BomLineItem::class);
    }

    public function purchaseIntentBatch()
    {
        return $this->hasOne(PurchaseIntentBatch::class);
    }
}
