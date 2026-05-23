<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    protected $fillable = [

        'action',
        'user_id'
    ];
    public function user()
{
    return $this->belongsTo(User::class);
}
}