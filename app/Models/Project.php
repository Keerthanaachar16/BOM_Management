<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'project_code',
        'description'
    ];

    public function bomHeaders()
    {
        return $this->hasMany(BomHeader::class);
    }
}
