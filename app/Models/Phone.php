<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \App\Models\PhoneNumber;

class Phone extends Model
{
    use HasFactory;

    public function phoneNumber()
    {
        return $this->belongsTo(PhoneNumber::class);
    }

    protected $fillable = [
         'number', 'phone_number_id'
    ];
}
