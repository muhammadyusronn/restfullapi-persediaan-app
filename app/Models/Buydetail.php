<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buydetail extends Model
{
    use HasFactory;
    protected $table = 'buydetails';
    protected $fillable = [
        'buy_id',
        'barang_id',
        'jumlahmasuk',
        'hargabeli',
    ];
}
