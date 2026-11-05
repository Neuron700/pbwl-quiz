<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use App\Models\Pelanggan;
use App\Models\Transaksi;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            "pelanggan" => Pelanggan::count(),
            "layanan" => Layanan::count(),
            "transaksi" => Transaksi::count(),
            "proses" => Transaksi::whereNull("trans_tgl_selesai")->count(),
            "selesai" => Transaksi::whereNotNull("trans_tgl_selesai")->count(),
            "omzet" => (int) Transaksi::sum("trans_total"),
        ];

        $recent = Transaksi::with(["pelanggan", "layanan"])
            ->orderByDesc("trans_tgl_masuk")
            ->orderByDesc("trans_id")
            ->take(8)
            ->get();

        return view("dashboard", compact("stats", "recent"));
    }
}