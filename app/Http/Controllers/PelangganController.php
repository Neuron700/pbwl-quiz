<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::query();

        if ($s = $request->query("cari")) {
            $query->where(function ($q) use ($s) {
                $q->where("pel_nama", "like", "%" . $s . "%")
                  ->orWhere("pel_hp", "like", "%" . $s . "%")
                  ->orWhere("pel_alamat", "like", "%" . $s . "%");
            });
        }

        $pelanggan = $query->orderByDesc("pel_id")->paginate(10)->withQueryString();

        return view("pelanggan.index", compact("pelanggan"));
    }

    public function create()
    {
        return view("pelanggan.create");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "pel_nama" => ["required", "string", "max:100"],
            "pel_alamat" => ["nullable", "string"],
            "pel_hp" => ["required", "string", "max:30"],
        ]);

        Pelanggan::create($data);

        return redirect()->route("pelanggan.index")->with("success", "Pelanggan berhasil ditambahkan.");
    }

    public function edit(Pelanggan $pelanggan)
    {
        return view("pelanggan.edit", compact("pelanggan"));
    }

    public function update(Request $request, Pelanggan $pelanggan)
    {
        $data = $request->validate([
            "pel_nama" => ["required", "string", "max:100"],
            "pel_alamat" => ["nullable", "string"],
            "pel_hp" => ["required", "string", "max:30"],
        ]);

        $pelanggan->update($data);

        return redirect()->route("pelanggan.index")->with("success", "Pelanggan berhasil diperbarui.");
    }

    public function destroy(Pelanggan $pelanggan)
    {
        try {
            $pelanggan->delete();
            return redirect()->route("pelanggan.index")->with("success", "Pelanggan berhasil dihapus.");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route("pelanggan.index")->with("error", "Pelanggan tidak dapat dihapus karena masih memiliki transaksi.");
        }
    }
}