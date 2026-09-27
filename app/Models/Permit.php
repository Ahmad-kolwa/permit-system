<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permit extends Model
{
    //
     protected $fillable = [
        'permit_code',
        'user_id',
        'park_id',
        'visitor_name',
        'visit_date',
        'amount',
        'status'
    ];
    
    public function user()
{
    return $this->belongsTo(User::class);
}

public function park()
{
    return $this->belongsTo(Park::class);
}

public function payment()
{
    return $this->hasMany(Payment::class);
}
}
