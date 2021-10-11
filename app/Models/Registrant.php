<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrant extends Model
{
    use HasFactory;

    protected $table = "registrants";

    protected $fillable = [
        'name', 'id_card_number', 'address', 'phone'
    ];

}
