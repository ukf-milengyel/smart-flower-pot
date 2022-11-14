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
    <a class="navbar-brand" href="https://github.com/ukf-milengyel/smart-flower-pot/blob/main/settings.php"
      target="_blank">SmartPot</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavAltMarkup"
      aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-item nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
        <a class="nav-item nav-link" href="statistics.php">Statistics</a>
        <a class="nav-item nav-link" href="settings.php">Settings</a>
      </div>
    </div>
  </nav>

  <div class="container">
    <table class="table text-center" id="table">
      <thead>
        <tr>
          <th scope="col">Air humidity (%)</th>
          <th scope="col">Soil humidity (%)</th>
          <th scope="col">Temperature (°C)</th>
          <th scope="col">Light level (%)</th>
          <th scope="col">Datetime</th>
        </tr>
      </thead>
      
    </table>

    <div align="center">
      <button type="button" class="btn btn-primary mt-5" style="width:50%" onclick="restart()">
        <font size="6">Restart</font>
      </button>
      <button type="button" class="btn btn-success mt-5" style="width:50%" onclick="manualUpdate()">
        <font size="6">Manual update</font>
      </button>
    </div>

  </div>

  <script type="text/javascript" src="index.js"></script>
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