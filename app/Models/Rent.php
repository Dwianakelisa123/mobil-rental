<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'tanggal_sewa',
        'tanggal_selesai',
        'payment'
    ];
    protected $guarded=[];
    public function transaction()
    {
        return $this->hasMany(Transaction::class);
    }
}
