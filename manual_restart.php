<?php
exec('python manual_restart.py', $output, $retval);
echo $retval;
