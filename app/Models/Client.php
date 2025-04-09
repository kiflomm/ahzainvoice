<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'address',
        'phone',
        'tin_number',
        'vat_registration',
        'registration_date',
    ];

    protected $casts = [
        'registration_date' => 'date',

    ];

    public function records()
    {
        return $this->hasMany(Record::class);
    }
}
