<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaksi::with(["pelanggan", "layanan"]);

        if ($s = $request->query("cari")) {
            $query->where(function ($q) use ($s) {
                $q->whereHas("pelanggan", fn ($p) => $p->where("pel_nama", "like", "%" . $s . "%"))
                   ->orWhereHas("layanan", fn ($l) => $l->where("lay_jenis", "like", "%" . $s . "%"))
                   ->orWhere("trans_id", "like", "%" . $s . "%");
            });
        }

        match ($request->query("status")) {
            "proses" => $query->whereNull("trans_tgl_selesai"),
            "selesai" => $query->whereNotNull("trans_tgl_selesai"),
            default => null,
        };

        $transaksi = $query->orderByDesc("trans_id")->paginate(10)->withQueryString();

        return view("transaksi.index", compact("transaksi"));
    }

    public function create()
    {
        $pelanggan = Pelanggan::orderBy("pel_nama")->get();
        $layanan = Layanan::orderBy("lay_jenis")->get();

        return view("transaksi.create", compact("pelanggan", "layanan"));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "trans_id_pelanggan" => ["required", "integer", "exists:tb_pelanggan,pel_id"],
            "trans_id_layanan" => ["required", "integer", "exists:tb_layanan,lay_id"],
            "trans_tgl_masuk" => ["required", "date"],
            "trans_tgl_selesai" => ["nullable", "date", "after_or_equal:trans_tgl_masuk"],
            "trans_berat" => ["required", "integer", "min:1"],
        ]);

        $lay = Layanan::findOrFail($data["trans_id_layanan"]);
        $data["trans_total"] = $data["trans_berat"] * $lay->lay_harga;

        Transaksi::create($data);

        return redirect()->route("transaksi.index")->with("success", "Transaksi berhasil ditambahkan. Total dihitung otomatis dari berat × harga layanan.");
    }

    public function edit(Transaksi $transaksi)
    {
        $pelanggan = Pelanggan::orderBy("pel_nama")->get();
        $layanan = Layanan::orderBy("lay_jenis")->get();

        return view("transaksi.edit", compact("transaksi", "pelanggan", "layanan"));
    }

    public function update(Request $request, Transaksi $transaksi)
    {
        $data = $request->validate([
            "trans_id_pelanggan" => ["required", "integer", "exists:tb_pelanggan,pel_id"],
            "trans_id_layanan" => ["required", "integer", "exists:tb_layanan,lay_id"],
            "trans_tgl_masuk" => ["required", "date"],
            "trans_tgl_selesai" => ["nullable", "date", "after_or_equal:trans_tgl_masuk"],
            "trans_berat" => ["required", "integer", "min:1"],
        ]);

        $lay = Layanan::findOrFail($data["trans_id_layanan"]);
        $data["trans_total"] = $data["trans_berat"] * $lay->lay_harga;

        $transaksi->update($data);

        return redirect()->route("transaksi.index")->with("success", "Transaksi berhasil diperbarui.");
    }

    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();

        return redirect()->route("transaksi.index")->with("success", "Transaksi berhasil dihapus.");
    }
}