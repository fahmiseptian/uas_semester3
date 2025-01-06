<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    protected $table = 'orders';
    protected $primaryKey = 'id_pesanan';
    public $incrementing = true;
    public $timestamps = false;
    protected $fillable = [
        'nama_tamu',
        'tipe_kamar',
        'check_in',
        'check_out',
    ];
}
