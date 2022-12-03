<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type_id',
        'image'
    ];

    public function type(){
        return $this->belongsTo(Type::class);
    }
}
