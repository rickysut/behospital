<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ParentInfo extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'mother_name', 
        'father_name', 
        'mother_age',
        'father_age',
        'address',
        'phone_number'
    ];

    

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
