<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName',
        'middleName',
        'lastName',
        'studentId',
        'email',
        'phone',
        'universitry',
        'college',
        'gpa',
        'password',

        'image',
        'profileGroup',
        'country',
        'nationalId',
        'grandFather',

        'fullName',
        'gender',
        'degree',
        'term',

        'year',
        'hours',
        'supervisorName',

        'supervisorPhone',
        'startTraining',

        'endTraining',
        'ar',



        'cv',
        'er',
        'tr'
    ];
}
