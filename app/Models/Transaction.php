<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected $fillable = ['bus_id', 'user_id', 'tanggal_checkin', 'tanggal_checkout', 'durasi_sewa', 'tujuan', 'penjemputan', 'keterangan', 'status', 'total', 'bukti_pembayaran'];


    public function bus()
    {
        return $this->belongsTo(Bus::class, 'bus_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
