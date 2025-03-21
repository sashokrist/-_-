<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'business_type_id',
        'user_id',
        'location',
        'phone',
        'email',
        'description'
    ];

    public function businessType()
    {
        return $this->belongsTo(BusinessType::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function hairstylists()
    {
        return $this->hasMany(Hairstylist::class);
    }

    public function tables()
    {
        return $this->hasMany(Table::class);
    }

    public function doctors()
    {
        return $this->hasMany(Doctor::class);
    }

}

