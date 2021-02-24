<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'reps_in_set'];

    public function sets()
    {
       return $this->hasMany('\App\Models\Set');
    }
}
