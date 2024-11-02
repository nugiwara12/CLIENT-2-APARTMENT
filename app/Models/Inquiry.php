<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inquiry extends Model
{
    use HasFactory;

    // Specify the table if it's not the plural form of the model name
    protected $table = 'inquiries'; // Optional, use if table name is not 'inquiries'

    // Define the fillable attributes
    protected $fillable = [
        'price',
        'room_number',
        'full_name',
        'contact_number',
        'email',
        'valid_id',
        'agreement',
        'inquiry_status',
        'status',
    ];    

    // Optional: Define any relationships
    public function room()
    {
        return $this->belongsTo(Room::class); // Assuming a relationship with a Room model
    }

    // Optional: Cast attributes
    protected $casts = [
        'price' => 'float',
        'agreement' => 'boolean',
    ];
}
