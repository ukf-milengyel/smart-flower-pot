<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  <title>SmartPot</title>
</head>

<body>

  <nav class="navbar navbar-dark bg-primary navbar-expand-lg">
    <a class="navbar-brand" href="https://github.com/ukf-milengyel/smart-flower-pot/"
      target="_blank">SmartPot</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link" href="index.php">Home</a>
        <a class="nav-item nav-link active" href="statistics.php">Statistics<span class="sr-only">(current)</span></a>
        <a class="nav-item nav-link" href="settings.php">Settings</a>
      </div>
    </div>
  </nav>


  <div class="container text-center">
    <div class="form mt-5" class="w-100">
        <label class="form-label" for="limit">Limit</label>
        <input id="limit" class="form-control" value="400" min="10" type="number">
        <label class="form-label" for="offset">Offset</label>
        <input id="offset" class="form-control" value="0" min="0" type="number">
        <button type="button" class="mt-3 btn btn-primary w-100" onclick="fetchData()">
            Refresh data
        </button>
    </div>

    <h1 class="mt-5">Air humidity</h1>
    <canvas id="airHumidity" class="mr-auto ml-auto my" style="width:100%;"></canvas>
    
    <h1 class="mt-5">Soil humidity</h1>
    <canvas id="soilHumidity" class="mr-auto ml-auto my-5" style="width:100%;"></canvas>
    
    <h1 class="mt-5">Temperature</h1>
    <canvas id="temperature" class="mr-auto ml-auto my-5" style="width:100%;"></canvas>
    
    <h1 class="mt-5">Light level</h1>
    <canvas id="lightLevel" class="mr-auto ml-auto my-5" style="width:100%;"></canvas>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
  <script src="statistics.js"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1"
    crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
    crossorigin="anonymous"></script>
</body>

</html>