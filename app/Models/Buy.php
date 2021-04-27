<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;
    protected $table = 'buys';
    protected $fillable = [
        'kodetransaksi',
        'tanggaltransaksi',
        'totaltransaksi',
        'supplier_id',
        'user_id',
    ];
}
