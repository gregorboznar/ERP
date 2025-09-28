@php
    $chartData = $getRecord()->getChartData();
@endphp

<div class="w-full h-48">
    @if(count($chartData['values']) > 0)
        <canvas id="temperature-chart-{{ $chartData['id'] }}" class="w-full h-full"></canvas>
        
        @once
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        @endonce
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js is not loaded');
                    return;
                }
                
                const ctx = document.getElementById('temperature-chart-{{ $chartData['id'] }}').getContext('2d');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: {!! json_encode($chartData['labels']) !!},
                        datasets: [{
                            data: {!! json_encode($chartData['values']) !!},
                            backgroundColor: 'rgba(239, 68, 68, 0.1)',
                            borderColor: 'rgba(239, 68, 68, 1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgba(239, 68, 68, 1)',
                            pointBorderColor: '#ffffff',
                            pointBorderWidth: 2,
                            pointRadius: 4,
                            pointHoverRadius: 6
                        }, {
                            data: Array({{ count($chartData['labels']) }}).fill(700),
                            borderColor: 'rgba(59, 130, 246, 0.8)',
                            backgroundColor: 'transparent',
                            borderWidth: 2,
                            borderDash: [5, 5],
                            pointRadius: 0,
                            pointHoverRadius: 0,
                            fill: false,
                            tension: 0
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                titleColor: '#ffffff',
                                bodyColor: '#ffffff',
                                borderColor: 'rgba(239, 68, 68, 1)',
                                borderWidth: 1
                            }
                        },
                        scales: {
                            x: {
                                display: true,
                                title: {
                                    display: false
                                },
                                grid: {
                                    display: false
                                }
                            },
                            y: {
                                display: true,
                                title: {
                                    display: false
                                },
                                grid: {
                                    color: 'rgba(0, 0, 0, 0.1)'
                                }
                            }
                        },
                        interaction: {
                            intersect: false,
                            mode: 'index'
                        }
                    }
                });
            });
        </script>
    @else
        <div class="flex items-center justify-center h-full text-gray-500">
            <span>No temperature readings</span>
        </div>
    @endif
</div>
