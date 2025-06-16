<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sensor Data Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(to right, #00c6ff, #0072ff);
      color: #fff;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .hero {
      text-align: center;
    }
    .hero h1 {
      font-size: 3rem;
      font-weight: bold;
    }
    .hero p {
      font-size: 1.25rem;
      margin-bottom: 30px;
    }
    .btn-main {
      background-color: #fff;
      color: #0072ff;
      padding: 12px 25px;
      border-radius: 30px;
      font-size: 1.1rem;
      text-decoration: none;
    }
    .btn-main:hover {
      background-color: #e0f0ff;
    }
  </style>
</head>
<body>
  <div class="hero">
    <h1>Welcome to Sensor Data Portal</h1>
    <p>View and compare environmental sensor data from CMU, UR, and Makerere</p>
    <a href="view.php" class="btn btn-main">Go to Visualizations</a>
  </div>
</body>
</html>
