<?php

namespace App\Filament\Resources\MeltTemperatureResource\Widgets;

use LaraZeus\InlineChart\InlineChartWidget;

class TemperatureReadingsChart extends InlineChartWidget
{
    protected static ?string $heading = 'Temperature Readings';
    
    public int $maxWidth = 300;
    protected static ?string $maxHeight = '150';

    protected function getData(): array
    {
        if (!isset($this->record)) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        $readings = $this->record->temperatureReadings()
            ->orderBy('recorded_at')
            ->get();

        if ($readings->isEmpty()) {
            return [
                'datasets' => [],
                'labels' => [],
            ];
        }

        return [
            'datasets' => [
                [
                    'label' => __('messages.temperature'),
                    'data' => $readings->pluck('temperature')->toArray(),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'borderWidth' => 2,
                    'fill' => true,
                    'tension' => 0.3,
                ]
            ],
            'labels' => $readings->map(fn($reading) => $reading->recorded_at->format('H:i'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}
