<?php
$file = file_get_contents("config.json") or die ("{}");
echo $file;
