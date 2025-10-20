<?php

namespace App\Filament\Resources\MeltTemperatureResource\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\MeltTemperature;
use App\Models\TemperatureReading;
use Carbon\Carbon;

class MeltTemperatureChart extends ChartWidget
{
    protected ?string $heading = 'Melt Temperature Chart';

    // Add filter property
    public ?string $filter = null;

    public function getHeading(): string
    {
        return __('messages.melt_temperature_chart');
    }

    protected function getFilters(): ?array
    {
        return [
            'today' => __('messages.today'),
            'yesterday' => __('messages.yesterday'),
            'last_week' => __('messages.last_week'),
            'last_month' => __('messages.last_month'),
        ];
    }

    protected function getData(): array
    {
        $date = match ($this->filter) {
            'yesterday' => Carbon::yesterday(),
            'last_week' => Carbon::today()->subWeek(),
            'last_month' => Carbon::today()->subMonth(),
            default => Carbon::today(),
        };

        $readings = TemperatureReading::whereHas('meltTemperature', function ($query) use ($date) {
            if ($this->filter === 'last_week') {
                $query->whereBetween('created_at', [$date, Carbon::today()]);
            } elseif ($this->filter === 'last_month') {
                $query->whereBetween('created_at', [$date, Carbon::today()]);
            } else {
                $query->whereDate('created_at', $date);
            }
        })
            ->orderBy('recorded_at')
            ->get();

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
        $timeUnit = match ($this->filter) {
            'last_week' => [
                'unit' => 'day',
                'displayFormats' => [
                    'day' => 'MMM D',
                ],
                'tooltipFormat' => 'MMM D, HH:mm',
            ],
            'last_month' => [
                'unit' => 'day',
                'displayFormats' => [
                    'day' => 'MMM D',
                ],
                'tooltipFormat' => 'MMM D, HH:mm',
            ],
            default => [
                'unit' => 'hour',
                'displayFormats' => [
                    'hour' => 'HH:mm'
                ],
                'tooltipFormat' => 'HH:mm'
            ],
        };

        return [
            'responsive' => true,
            'maintainAspectRatio' => false,
            'scales' => [
                'x' => [
                    'type' => 'time',
                    'time' => $timeUnit,
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
