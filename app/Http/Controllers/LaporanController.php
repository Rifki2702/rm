<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporanKunjungan()
    {
        return view('laporan.kunjungan');
    }

    public function laporanFarmasi()
    {
        return view('laporan.farmasi');
    }
}
