<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $fillable = ['number', 'seats', 'business_id'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
