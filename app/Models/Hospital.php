<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hospital extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'location'];

    public function surgeries()
    {
        return $this->hasMany(\App\Models\Surgery::class, 'hospital_id');
    }
}