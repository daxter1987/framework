<?php

namespace App;

//use Illuminate\Database\Eloquent\SoftDeletes;

class ClassName extends AbstractModel
{
//    use SoftDeletes;

    protected $table = 'ClassNameLowerCase';

    protected $fillable = [
        '$fillable_attributes'
    ];

    protected $dates = ['deleted_at'];
}
