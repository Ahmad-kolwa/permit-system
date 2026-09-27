<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    //
    
    protected $fillable = [
        'permit_id',
        'amount',
        'payment_reference',
        'payment_date'
    ];

    public function permit()
{
    return $this->belongsTo(Permit::class);
}
}
