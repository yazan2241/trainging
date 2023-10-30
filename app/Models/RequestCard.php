<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestCard extends Model
{
    use HasFactory;
    protected $fillable = [
        'userId',
        'type',
        'contract',
        'file',
        'job'
    ];
}
