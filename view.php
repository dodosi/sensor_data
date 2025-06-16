<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sensor Data Visualization</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">Sensor Dashboard</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </nav>

  <!-- Filters -->
  <div class="container mt-4">
    <div class="row align-items-center mb-4">
      <div class="col-md-4 mb-2">
        <label for="locationSelect" class="form-label fw-bold">Select Location</label>
        <select id="locationSelect" class="form-select">
          <option value="UR">University of Rwanda</option>
          <option value="CMU">Carnegie Mellon University</option>
          <option value="MAKERERE">Makerere University</option>
        </select>
      </div>
      <div class="col-md-4 mb-2">
        <label for="nodeSelect" class="form-label fw-bold">Select Node</label>
        <select id="nodeSelect" class="form-select">
          <option value="ENV_001">ENV_001</option>
          <option value="ENV_002">ENV_002</option>
          <option value="UR_KGL">UR_KGL</option>
          <option value="MAKERERE_A">MAKERERE_A</option>
        </select>
      </div>
      <div class="col-md-4 d-flex align-items-end">
        <button id="refreshButton" class="btn btn-outline-primary w-100">Refresh Data</button>
      </div>
    </div>

    <!-- Temperature Chart -->
    <div class="card mb-5">
      <div class="card-body">
        <h5 class="card-title">Temperature (AHT20)</h5>
        <canvas id="temperatureChart"></canvas>
      </div>
    </div>

    <!-- Humidity Chart -->
    <div class="card mb-5">
      <div class="card-body">
        <h5 class="card-title">Humidity (AHT20)</h5>
        <canvas id="humidityChart"></canvas>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    let temperatureChart, humidityChart;

    async function fetchDataAndUpdateCharts(nodeId) {
      try {
        const response = await fetch(`get_data.php?node_id=${encodeURIComponent(nodeId)}`);
        const data = await response.json();

        const labels = data.map(row => row.timestamp);
        const temperature = data.map(row => JSON.parse(row.data).temperature.aht20[0]);
        const humidity = data.map(row => JSON.parse(row.data).humidity.aht20[0]);

        if (temperatureChart) {
          temperatureChart.data.labels = labels;
          temperatureChart.data.datasets[0].data = temperature;
          temperatureChart.update();
        } else {
          temperatureChart = new Chart(document.getElementById('temperatureChart'), {
            type: 'line',
            data: {
              labels,
              datasets: [{
                label: 'Temperature (°C)',
                data: temperature,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
              }]
            }
          });
        }

        if (humidityChart) {
          humidityChart.data.labels = labels;
          humidityChart.data.datasets[0].data = humidity;
          humidityChart.update();
        } else {
          humidityChart = new Chart(document.getElementById('humidityChart'), {
            type: 'line',
            data: {
              labels,
              datasets: [{
                label: 'Humidity (%)',
                data: humidity,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
              }]
            }
          });
        }
      } catch (err) {
        console.error("Error fetching data:", err);
      }
    }

    const nodeSelect = document.getElementById('nodeSelect');
    const refreshButton = document.getElementById('refreshButton');

    refreshButton.addEventListener('click', () => {
      fetchDataAndUpdateCharts(nodeSelect.value);
    });

    // Load initial data
    fetchDataAndUpdateCharts(nodeSelect.value);

    // Auto-refresh every minute
    setInterval(() => {
      fetchDataAndUpdateCharts(nodeSelect.value);
    }, 1000);
  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
