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
        </select>
      </div>
      <div class="col-md-4 d-flex align-items-end">
        <button id="refreshButton" class="btn btn-outline-primary w-100">Refresh Data</button>
      </div>
    </div>

    <!-- Temperature Chart -->
    <div class="card mb-5">
      <div class="card-body">
        <h5 class="card-title">Temperature</h5>
        <canvas id="temperatureChart"></canvas>
      </div>
    </div>

    <!-- Humidity Chart -->
    <div class="card mb-5">
      <div class="card-body">
        <h5 class="card-title">Humidity</h5>
        <canvas id="humidityChart"></canvas>
      </div>
    </div>
    <div class="card mb-5">
        <div class="card-body">
            <h5 class="card-title">Pressure</h5>
            <canvas id="pressureChart"></canvas>
        </div>
    </div>

    <!-- Rain Chart -->
    <div class="card mb-5">
        <div class="card-body">
            <h5 class="card-title">Rain Intensity & Volume</h5>
            <canvas id="rainChart"></canvas>
        </div>
    </div>

  </div>
<!-- Pressure Chart -->


  <!-- Scripts -->
  <script>
   let temperatureChart, humidityChart, pressureChart, rainChart;


    async function fetchDataAndUpdateCharts(nodeId) {
      try {
        const response = await fetch(`get_data.php?node_id=${encodeURIComponent(nodeId)}`);
        const data = await response.json();

        const parsedData = data.map(row => JSON.parse(row.data));

        const labels = data.map(row => row.timestamp);

        const temperatureSeries = {
        aht20: parsedData.map(d => d.temperature.aht20[0]),
        sht31: parsedData.map(d => d.temperature.sht31[0]),
        bme280: parsedData.map(d => d.temperature.bme280[0]),
        htu21: parsedData.map(d => d.temperature.htu21[0])
        };

        if (temperatureChart) {
            temperatureChart.data.labels = labels;
            temperatureChart.data.datasets = [
                { label: 'AHT20', data: temperatureSeries.aht20, borderColor: 'red', borderWidth: 1 },
                { label: 'SHT31', data: temperatureSeries.sht31, borderColor: 'green', borderWidth: 1 },
                { label: 'BME280', data: temperatureSeries.bme280, borderColor: 'blue', borderWidth: 1 },
                { label: 'HTU21', data: temperatureSeries.htu21, borderColor: 'orange', borderWidth: 1 }
            ];
            temperatureChart.update();
            } else {
            temperatureChart = new Chart(document.getElementById('temperatureChart'), {
                type: 'line',
                data: {
                labels,
                datasets: [
                    { label: 'AHT20', data: temperatureSeries.aht20, borderColor: 'red', borderWidth: 1 },
                    { label: 'SHT31', data: temperatureSeries.sht31, borderColor: 'green', borderWidth: 1 },
                    { label: 'BME280', data: temperatureSeries.bme280, borderColor: 'blue', borderWidth: 1 },
                    { label: 'HTU21', data: temperatureSeries.htu21, borderColor: 'orange', borderWidth: 1 }
                ]
                },  
            options: {
                responsive: true,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    legend: {
                    position: 'top'
                    },
                    title: {
                    display: true,
                    text: 'Sensor Measurements'
                    }
                }
            }
            });
            }
const humiditySeries = {
  aht20: parsedData.map(d => d.humidity.aht20[0]),
  sht31: parsedData.map(d => d.humidity.sht31[0]),
  bme280: parsedData.map(d => d.humidity.bme280[0]),
  htu21: parsedData.map(d => d.humidity.htu21[0])
};

if (humidityChart) {
  humidityChart.data.labels = labels;
  humidityChart.data.datasets = [
    { label: 'AHT20', data: humiditySeries.aht20, borderColor: 'red', borderWidth: 1 },
    { label: 'SHT31', data: humiditySeries.sht31, borderColor: 'green', borderWidth: 1 },
    { label: 'BME280', data: humiditySeries.bme280, borderColor: 'blue', borderWidth: 1 },
    { label: 'HTU21', data: humiditySeries.htu21, borderColor: 'orange', borderWidth: 1 }
  ];
  humidityChart.update();
} else {
  humidityChart = new Chart(document.getElementById('humidityChart'), {
    type: 'line',
    data: {
      labels,
      datasets: [
        { label: 'AHT20', data: humiditySeries.aht20, borderColor: 'red', borderWidth: 1 },
        { label: 'SHT31', data: humiditySeries.sht31, borderColor: 'green', borderWidth: 1 },
        { label: 'BME280', data: humiditySeries.bme280, borderColor: 'blue', borderWidth: 1 },
        { label: 'HTU21', data: humiditySeries.htu21, borderColor: 'orange', borderWidth: 1 }
      ]
    },
    options: {
        responsive: true,
        interaction: {
            mode: 'index',
            intersect: false
        },
        plugins: {
            legend: {
            position: 'top'
            },
            title: {
            display: true,
            text: 'Sensor Measurements'
            }
        }
    }
  });
}
const pressureData = parsedData.map(d => d.pressure[0]);

if (pressureChart) {
  pressureChart.data.labels = labels;
  pressureChart.data.datasets[0].data = pressureData;
  pressureChart.update();
} else {
  pressureChart = new Chart(document.getElementById('pressureChart'), {
    type: 'line',
    data: {
      labels,
      datasets: [
        { label: 'Pressure (hPa)', data: pressureData, borderColor: 'purple', borderWidth: 1 }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'top' },
        title: {
          display: true,
          text: 'Pressure Over Time'
        }
      }
    }
  });
}
const rainIntensity = parsedData.map(d => d.rain.intensity);
const rainVolume = parsedData.map(d => d.rain.volume);

if (rainChart) {
  rainChart.data.labels = labels;
  rainChart.data.datasets[0].data = rainIntensity;
  rainChart.data.datasets[1].data = rainVolume;
  rainChart.update();
} else {
  rainChart = new Chart(document.getElementById('rainChart'), {
    type: 'line',
    data: {
      labels,
      datasets: [
        { label: 'Rain Intensity (mm/h)', data: rainIntensity, borderColor: 'navy', borderWidth: 1 },
        { label: 'Rain Volume (mm)', data: rainVolume, borderColor: 'teal', borderWidth: 1 }
      ]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { position: 'top' },
        title: {
          display: true,
          text: 'Rainfall Over Time'
        }
      }
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
    }, 10000);
    async function loadNodeOptions() {
  try {
    const response = await fetch('get_nodes.php');
    const nodes = await response.json();
    const nodeSelect = document.getElementById('nodeSelect');
    nodeSelect.innerHTML = ''; // Clear existing options

    nodes.forEach(nodeId => {
      const option = document.createElement('option');
      option.value = nodeId;
      option.textContent = nodeId;
      nodeSelect.appendChild(option);
    });

    // Load data for the first node by default
    if (nodes.length > 0) {
      fetchDataAndUpdateCharts(nodes[0]);
    }

  } catch (err) {
    console.error("Error loading node options:", err);
  }
}

// Call the function to load options
loadNodeOptions();

  </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
