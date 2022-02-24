<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartsModel extends Model
{
    use HasFactory;

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
