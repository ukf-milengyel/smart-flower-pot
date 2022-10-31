<html>
<head>
	<title>settings</title>
</head>
<body>
	<?php 
	ini_set("display_errors", 1);
	ini_set("display_startup_errors", 1);
	error_reporting(E_ALL);
	$config = json_decode(file_get_contents("config.json"), true);
	
	if ($_SERVER["REQUEST_METHOD"] == "POST"){
		$config["pump_enable"] = isset($_POST["pump"]) ? true : false;
		$config["manual_update_enable"] = isset($_POST["manual"]) ? true : false;
		$config["update_delay"] = intval($_POST["uddelay"]);
		$config["pump_threshold"] = $_POST["pthreshold"] / 100;
		$config["pump_on_time"] = intval($_POST["ptime"]);
		$config["pump_threshold"] = $_POST["pthreshold"] / 100;
		
		for ($i = 0; $i < 3; $i++){
			$config["status_led_threshold"][$i] = $_POST["led".$i] / 100;
		}
		
		file_put_contents("config.json", json_encode($config));
		
		exec('python manual_restart.py');
		echo "Nastavenia boli zmenené, zariadenie sa reštartuje.";
	}
	
	?>
	<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		Povoliť pumpu <input type="checkbox" name="pump" <?php echo $config["pump_enable"] ? "checked" : ""; ?>><br>
		Povoliť aktualizáciu tlačidlom <input type="checkbox" name="manual" <?php echo $config["manual_update_enable"] ? "checked" : ""; ?>><br>
		Čas medzi aktualizáciami <input type="number" min="10" max="3600" name="uddelay" value="<?php echo $config["update_delay"]; ?>"> sekúnd<br>
		Automatické spustenie pumpy pri vlhkosti pôdy menej ako <input type="number" min="10" max="90" name="pthreshold" value="<?php echo $config["pump_threshold"] * 100; ?>"> %<br>
		Doba spustenia pumpy <input type="number" min="1" max="10" name="ptime" value="<?php echo $config["pump_on_time"]; ?>"> sekúnd<br><br>
		Stavové LED pri vlhkosti pôdy:<br>
		Červená &lt <input type="number" min="0" max="100" name="led0" value="<?php echo $config["status_led_threshold"][0] * 100;?>">%<br>
		Žltá &lt <input type="number" min="0" max="100" name="led1" value="<?php echo $config["status_led_threshold"][1] * 100;?>"> %<br>
		Zelená &lt <input type="number" min="0" max="100" name="led2" value="<?php echo $config["status_led_threshold"][2] * 100;?>"> %<br>
		Modrá &lt <input type="number" min="0" max="100" name="led3" value="<?php echo $config["status_led_threshold"][3] * 100;?>"> %<br><br>
		<input type="submit" value="Uložiť a reštartovať">
	</form>
</body>
</html>
