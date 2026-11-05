<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Layanan extends Model
{
    protected $table = "tb_layanan";
    protected $primaryKey = "lay_id";
    public $timestamps = false;

    protected $fillable = ["lay_jenis", "lay_harga"];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, "trans_id_layanan", "lay_id");
    }
}