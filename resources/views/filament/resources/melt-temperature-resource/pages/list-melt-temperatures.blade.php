@extends('filament::page')

@section('content')
<div>
  <canvas id="meltTemperatureChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const ctx = document.getElementById('meltTemperatureChart').getContext('2d');
  const chartData = @json($chartData);

  const labels = chartData.map(data => data.date);
  const data = chartData.map(data => data.avg_temp);

  const meltTemperatureChart = new Chart(ctx, {
    type: 'line', // You can change this to 'bar', 'pie', etc.
    data: {
      labels: labels,
      datasets: [{
        label: 'Average Melt Temperature',
        data: data,
        borderColor: 'rgba(75, 192, 192, 1)',
        backgroundColor: 'rgba(75, 192, 192, 0.2)',
        borderWidth: 1,
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  });
</script>
@endsection