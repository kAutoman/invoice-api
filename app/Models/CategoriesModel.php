<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesModel extends Model
{

    public $table = 'categories';

    protected $fillable = [
        'name'
    ];
}
