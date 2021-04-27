<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Selldetail extends Model
{
    use HasFactory;
    protected $table = 'selldetails';
    protected $fillable = [
        'sell_id',
        'barang_id',
        'jumlahkeluar',
    ];
}
