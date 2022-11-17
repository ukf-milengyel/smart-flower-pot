<html>

<head>
  <title>settings</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

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
        <a class="nav-item nav-link" href="statistics.php">Statistics</a>
        <a class="nav-item nav-link active" href="settings.php">Settings<span class="sr-only">(current)</span></a>
      </div>
    </div>
  </nav>

  <?php
  ini_set("display_errors", 1);
  ini_set("display_startup_errors", 1);
  error_reporting(E_ALL);
  $config = json_decode(file_get_contents("config.json"), true);

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $config["pump_enable"] = isset($_POST["pump_enable"]) ? true : false;
    $config["manual_update_enable"] = isset($_POST["manual_update_enable"]) ? true : false;
    $config["update_delay"] = intval($_POST["update_delay"]);
    $config["pump_threshold"] = $_POST["pump_threshold"] / 100;
    $config["pump_on_time"] = intval($_POST["pump_on_time"]);

    for ($i = 0; $i < 3; $i++) {
      $config["status_led_threshold"][$i] = $_POST["led" . $i] / 100;
    }

    file_put_contents("config.json", json_encode($config));

    exec('python manual_restart.py');

    echo '<script>alert("Settings were saved, system is restarting.")</script>';
  }

  ?>

  <div class="container mt-5">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
      <div class="custom-control custom-switch mb-2">
        <input type="checkbox" class="custom-control-input" id="enablePump" <?php echo $config["pump_enable"] ?
          "checked" : ""; ?> name="pump_enable"/>
        <label class="custom-control-label" for="enablePump">Enable pump</label>
      </div>

      <div class="custom-control custom-switch mb-2">
        <input type="checkbox" class="custom-control-input" id="manualUpdate" <?php echo $config["manual_update_enable"]
          ? "checked" : ""; ?> name="manual_update_enable" />
        <label class="custom-control-label" for="manualUpdate">Enable manual update</label>
      </div>

      <div class="form-outline mb-2">
        <label class="form-label" for="updateTime">Time between updates (seconds)</label>
        <input type="number" min="10" max="3600" id="updateTime" class="form-control"
          value="<?php echo $config["update_delay"] ?>" name="update_delay" required />
      </div>

      <div class="form-outline mb-2">
        <label class="form-label" for="humidity">Threshold percentage of soil humidity (percentage)</label>
        <input type="number" min="10" max="90" id="humidity" class="form-control"
          value="<?php echo $config["pump_threshold"] * 100 ?>" name="pump_threshold" required />
      </div>

      <div class="form-outline mb-2">
        <label class="form-label" for="pumpTime">Run pump for (seconds)</label>
        <input type="number" min="1" max="10" id="pumpTime" class="form-control"
          value="<?php echo $config["pump_on_time"] ?>" name="pump_on_time" required />
      </div>

      Threshold percentage of control LEDs
      <div class="form-inline mt-2 mb-5">

        <div class="form-outline mr-5">
          <label class="form-label" for="Red">Red</label>
          <input type="number" min="0" max="100" id="Red" name="led0"
            value="<?php echo $config["status_led_threshold"][0] * 100; ?>" class="form-control" required />
        </div>

        <div class="form-outline mr-5">
          <label class="form-label" for="Yellow">Yellow</label>
          <input type="number" min="0" max="100" id="Yellow" name="led1"
            value="<?php echo $config["status_led_threshold"][1] * 100; ?>" class="form-control" required />
        </div>

        <div class="form-outline mr-5">
          <label class="form-label" for="Green">Green</label>
          <input type="number" min="0" max="100" id="Green" name="led2"
            value="<?php echo $config["status_led_threshold"][2] * 100; ?>" class="form-control" required />
        </div>

        <div class="form-outline mr-5">
          <label class="form-label" for="Blue">Blue</label>
          <input type="number" min="0" max="100" id="Blue" name="led3"
            value="<?php echo $config["status_led_threshold"][3] * 100; ?>" class="form-control" required />
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Submit settings</button>


    </form>
  </div>

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