<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    protected $table = "tb_pelanggan";
    protected $primaryKey = "pel_id";
    public $timestamps = false;

    protected $fillable = ["pel_nama", "pel_alamat", "pel_hp"];

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class, "trans_id_pelanggan", "pel_id");
    }
}