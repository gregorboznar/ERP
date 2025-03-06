<?php

namespace App\Filament\Resources\MeltTemperatureResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\MeltTemperature;
use Carbon\Carbon;

class MeltTemperatureChart extends ChartWidget
{
    protected static ?string $heading = 'Temperature Chart';

    protected function getData(): array
    {
        $today = Carbon::today();

        $temperatures = MeltTemperature::whereDate('recorded_at_1', $today)
            ->orderBy('recorded_at_1')
            ->get();

        // Prepare data for each temperature series
        $series = [
            ['label' => 'Temperature 1', 'recorded_at' => 'recorded_at_1', 'temperature' => 'temperature_1', 'color' => 'rgb(255, 99, 132)'],
            ['label' => 'Temperature 2', 'recorded_at' => 'recorded_at_2', 'temperature' => 'temperature_2', 'color' => 'rgb(54, 162, 235)'],
            ['label' => 'Temperature 3', 'recorded_at' => 'recorded_at_3', 'temperature' => 'temperature_3', 'color' => 'rgb(255, 206, 86)'],
            ['label' => 'Temperature 4', 'recorded_at' => 'recorded_at_4', 'temperature' => 'temperature_4', 'color' => 'rgb(75, 192, 192)'],
        ];

        $datasets = [];

        foreach ($series as $seriesInfo) {
            $data = $temperatures->map(function ($record) use ($seriesInfo) {
                return [
                    'x' => Carbon::parse($record->{$seriesInfo['recorded_at']})->format('H:i'),
                    'y' => $record->{$seriesInfo['temperature']},
                ];
            })
                // Sort each dataset by the 'x' value to ensure proper ordering
                ->sortBy('x')
                ->values();

            $datasets[] = [
                'label' => $seriesInfo['label'],
                'data' => $data,
                'borderColor' => $seriesInfo['color'],
                'backgroundColor' => 'transparent',
                'borderWidth' => 2,
                'tension' => 0.1,  // Slight curvature for the lines
                'fill' => false,
                'pointRadius' => 4,
                'pointHoverRadius' => 6,
            ];
        }

        // Collecting unique labels (optional if using a time scale)
        $labels = collect([
            $temperatures->pluck('recorded_at_1')->map(fn($date) => Carbon::parse($date)->format('H:i')),
            $temperatures->pluck('recorded_at_2')->map(fn($date) => Carbon::parse($date)->format('H:i')),
            $temperatures->pluck('recorded_at_3')->map(fn($date) => Carbon::parse($date)->format('H:i')),
            $temperatures->pluck('recorded_at_4')->map(fn($date) => Carbon::parse($date)->format('H:i')),
        ])->flatten()->unique()->sort();

        return [
            'labels' => $labels,
            'datasets' => $datasets,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => [
                    'type' => 'time',
                    'time' => [
                        'unit' => 'minute',
                        'displayFormats' => [
                            'minute' => 'HH:mm'
                        ]
                    ],
                ],
                'y' => [
                    'beginAtZero' => false,
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                ],
            ],
        ];
    }
}
