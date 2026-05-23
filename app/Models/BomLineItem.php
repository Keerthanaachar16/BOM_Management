<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BomLineItem extends Model
{
    protected $fillable = [
        'bom_header_id',
        'item_code',
        'part_number',
        'description',
        'uom',
        'required_quantity',
        'specification',
        'allocated_to',
        'inventory_status'
    ];

    public function bomHeader()
    {
        return $this->belongsTo(BomHeader::class);
    }

    public function allocations()
    {
        return $this->hasMany(MaterialAllocation::class);
    }
}