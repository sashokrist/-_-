<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    protected $fillable = ['name', 'specialization'];

    /**
     * Fetch all doctors (can be extended with filtering if needed)
     */
    public static function getAllDoctors()
    {
        return self::all();
    }
}
