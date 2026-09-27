<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    //
    protected $fillable = [
        'park_name',
        'location'
    ];


    public function permit()
{
    return $this->hasMany(Permit::class);
}
}
