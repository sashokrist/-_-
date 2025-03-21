<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hairstylist extends Model
{
    protected $fillable = ['name', 'specialization', 'business_id'];

    public function business()
    {
        return $this->belongsTo(Business::class);
    }
}
