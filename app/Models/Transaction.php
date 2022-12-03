<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = [
        'rent_id',
        'tanggal_sewa',
        'tanggal_selesai',
        'status'
    ];

    public function rent(){
        return $this->belongsTo(Rent::class);
    }
}
