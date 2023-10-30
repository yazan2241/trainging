<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'special',
        'term',
        'year',
        'startTraining',
        'endTraining',
        'status',
        'complete'
    ];
}
