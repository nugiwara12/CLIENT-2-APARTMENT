<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'room_number',
        'full_name',
        'contact_number',
        'email',
        'valid_id',
        'agreement',
        'inquiry_status',
    ];
}

