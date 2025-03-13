<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\KunjunganRawatInap; // Keep only the KunjunganRawatInap model

class KunjunganChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\AreaChart
    {
        // Fetch daily data for rawat inap for the current month from the database
        $kunjunganInapData = KunjunganRawatInap::selectRaw('tanggal_masuk as date, COUNT(*) as count')
            ->whereMonth('tanggal_masuk', date('m')) // Current month
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        // Create an array for the X-axis labels (dates of the month)
        $days = KunjunganRawatInap::selectRaw('tanggal_masuk as date')
            ->whereMonth('tanggal_masuk', date('m')) // Current month
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('date')
            ->toArray();

        // Check if kunjunganInapData is empty and set a default value to avoid issues in the chart
        if (empty($kunjunganInapData)) {
            $kunjunganInapData = array_fill(0, count($days), 0); // Fill with zeros for each day
        }

        return $this->chart->areaChart()
            ->setTitle('Statistik Kunjungan Rawat Inap')
            ->setSubtitle('Kunjungan Rawat Inap')
            ->addData('Kunjungan Rawat Inap', $kunjunganInapData) // Add data for rawat inap
            ->setXAxis($days);
    }
}
