<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AddressBook extends Model
{
    use HasFactory;
    protected $table = 'address_book';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'website',
        'gender',
        'age',
        'nationality',
        'created_by',
    ];
}
