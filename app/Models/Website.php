<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = ['sop', 'nomor_admin', 'nomor_rekening', 'sosial_media'];

    protected $casts = [
        'nomor_admin' => 'json',
        'nomor_rekening' => 'json',
        'sosial_media' => 'json'
    ];
}
