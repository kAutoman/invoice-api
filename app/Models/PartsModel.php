<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PartsModel extends Model
{

    public $table = 'parts';

    protected $fillable = [
        'q',
        'mq',
        'description',
        'pno',
        'is_shopping',
        'type',
    ];
}
