<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    public function index(Request $request)
    {
        $query = Layanan::query();

        if ($s = $request->query("cari")) {
            $query->where("lay_jenis", "like", "%" . $s . "%");
        }

        $layanan = $query->orderByDesc("lay_id")->paginate(10)->withQueryString();

        return view("layanan.index", compact("layanan"));
    }

    public function create()
    {
        return view("layanan.create");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "lay_jenis" => ["required", "string", "max:100"],
            "lay_harga" => ["required", "integer", "min:0"],
        ]);

        Layanan::create($data);

        return redirect()->route("layanan.index")->with("success", "Layanan berhasil ditambahkan.");
    }

    public function edit(Layanan $layanan)
    {
        return view("layanan.edit", compact("layanan"));
    }

    public function update(Request $request, Layanan $layanan)
    {
        $data = $request->validate([
            "lay_jenis" => ["required", "string", "max:100"],
            "lay_harga" => ["required", "integer", "min:0"],
        ]);

        $layanan->update($data);

        return redirect()->route("layanan.index")->with("success", "Layanan berhasil diperbarui.");
    }

    public function destroy(Layanan $layanan)
    {
        try {
            $layanan->delete();
            return redirect()->route("layanan.index")->with("success", "Layanan berhasil dihapus.");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route("layanan.index")->with("error", "Layanan tidak dapat dihapus karena masih dipakai transaksi.");
        }
    }
}