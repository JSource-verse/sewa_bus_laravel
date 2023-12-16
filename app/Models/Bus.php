<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = ['nama', 'jumlah_kursi', 'tipe_bus', 'harga', 'photo'];


    public function transaction()
    {
        return $this->hasMany(Transaction::class, 'bus_id');

    }
}
