<?php

namespace App\Filament\Resources\MeltTemperatureResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\MeltTemperature;
use App\Models\TemperatureReading;
use Carbon\Carbon;

class MeltTemperatureChart extends ChartWidget
{
    protected static ?string $heading = 'Melt Temperature Chart';

    public function getHeading(): string
    {
        return __('messages.melt_temperature_chart');
    }

    protected function getData(): array
    {
        $today = Carbon::today();

        // Get today's temperature readings
        $readings = TemperatureReading::whereHas('meltTemperature', function ($query) use ($today) {
            $query->whereDate('created_at', $today);
        })
            ->orderBy('recorded_at')
            ->get();

        // Prepare data for temperature series
        $data = $readings->map(function ($reading) {
            return [
                'x' => Carbon::parse($reading->recorded_at)->format('H:i'),
                'y' => $reading->temperature,
            ];
        })
            ->sortBy('x')
            ->values();

        $datasets = [
            [
                'label' => 'Temperature (°C)',
                'data' => $data,
                'borderColor' => 'rgb(255, 99, 132)',
                'backgroundColor' => 'rgba(255, 99, 132, 0.1)',
                'borderWidth' => 2,
                'tension' => 0.3,
                'fill' => true,
                'pointRadius' => 4,
                'pointHoverRadius' => 6,
                'pointBackgroundColor' => 'rgb(255, 99, 132)',
            ],

            [
                'label' => 'Temperature Limit',
                'data' => collect($data)->map(function ($point) {
                    return [
                        'x' => $point['x'],
                        'y' => 700,
                    ];
                })->toArray(),
                'borderColor' => 'rgba(54, 162, 235, 0.8)',
                'borderWidth' => 2,
                'pointRadius' => 0,
                'fill' => false,
                'tension' => 0,
                'borderDash' => [5, 5],
            ],

        ];

        return [
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
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'x' => [
                    'type' => 'time',
                    'time' => [
                        'unit' => 'hour',
                        'displayFormats' => [
                            'hour' => 'HH:mm'
                        ],
                        'tooltipFormat' => 'HH:mm'
                    ],
                    'title' => [
                        'display' => true,
                        'text' => 'Time'
                    ]
                ],
                'y' => [
                    'beginAtZero' => false,
                    'title' => [
                        'display' => true,
                        'text' => 'Temperature (°C)'
                    ]
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                ],

            ],
        ];
    }
}
