<?php

namespace App\Models;

/*
 * (c) @iLabAfrica
 * BLIS      - a port of the Basic Laboratory Information System (BLIS) to Laravel.
 * Team Lead - Emmanuel Kweyu.
 */

use Illuminate\Database\Eloquent\Model;

class SpecimenTypeTestType extends Model
{
    protected $table = 'specimen_type_test_type';

    public $timestamps = false; 

    public $fillable = ['specimen_type_id', 'test_type_id'];
}
