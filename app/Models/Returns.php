<?php

namespace App\Models;

use App\Models\Rental;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Returns extends Model
{
    use HasFactory;
    protected $table = 'returns';
    protected $fillable = [
        'user_id',
        'rental_id',
        'return_date',
        'rental_days',
        'rental_fee',
    ];

    public function rental()
    {
        return $this->belongsTo(Rental::class);
    }
}
