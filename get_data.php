<?php
$limit = isset($_GET["limit"]) ? intval($_GET["limit"]) : 500;
$offset = isset($_GET["offset"]) ? intval($_GET["offset"]) : 0;

$db = new SQLite3('database.db');

$result = $db->query("SELECT * FROM flower_pot ORDER BY id DESC LIMIT $limit OFFSET $offset");
while($row = $result->fetchArray(SQLITE3_ASSOC)){
	$arr[] = $row;
}

echo json_encode($arr ?? array());
