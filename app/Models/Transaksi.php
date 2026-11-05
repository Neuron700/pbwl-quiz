<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = "tb_transaksi";
    protected $primaryKey = "trans_id";
    public $timestamps = false;

    protected $fillable = [
        "trans_id_pelanggan",
        "trans_id_layanan",
        "trans_tgl_masuk",
        "trans_tgl_selesai",
        "trans_berat",
        "trans_total",
    ];

    protected $casts = [
        "trans_tgl_masuk" => "date",
        "trans_tgl_selesai" => "date",
        "trans_total" => "integer",
        "trans_berat" => "integer",
    ];

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, "trans_id_pelanggan", "pel_id");
    }

    public function layanan()
    {
        return $this->belongsTo(Layanan::class, "trans_id_layanan", "lay_id");
    }
}