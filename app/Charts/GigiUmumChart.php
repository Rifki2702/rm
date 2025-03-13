<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\KunjunganPoliUmum; // Model for general visits
use App\Models\KunjunganPoliGigi; // Model for dental visits

class GigiUmumChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        // Fetch daily data for general visits using created_at
        $kunjunganUmumData = KunjunganPoliUmum::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        // Fetch daily data for dental visits using created_at
        $kunjunganGigiData = KunjunganPoliGigi::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count')
            ->toArray();

        // Prepare data for the donut chart
        $data = [
            isset($kunjunganUmumData[0]) ? $kunjunganUmumData[0] : 0, // Poli Umum
            isset($kunjunganGigiData[0]) ? $kunjunganGigiData[0] : 0  // Poli Gigi
        ];

        // Create labels for the chart
        $labels = ['Kunjungan Poli Umum', 'Kunjungan Poli Gigi'];

        return $this->chart->donutChart()
            ->setTitle('Kunjungan Poli Umum dan Gigi')
            ->setSubtitle('Statistik Kunjungan per Hari')
            ->addData($data) // Corrected method to add data
            ->setLabels($labels);
    }
}
