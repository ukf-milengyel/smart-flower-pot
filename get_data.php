<?php
$db = new SQLite3('database.db');

$result = $db->query("SELECT * FROM flower_pot ORDER BY id DESC LIMIT 500");
while($row = $result->fetchArray(SQLITE3_ASSOC)){
	$arr[] = $row;
}

echo json_encode($arr);
