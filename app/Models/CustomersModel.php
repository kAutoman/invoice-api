<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomersModel extends Model
{
    use HasFactory;

    public $table = 'customers';

    protected $fillable = [
        'title',
        'mobile_phone',
        'email',
        'name',
        'address',
        'town',
        'postal_code',
        'further_note',
        'state',
        'remind_date',
        'category_id',
        'attached_files',
    ];
}
