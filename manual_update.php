<?php
exec('python manual_update.py', $output, $retval);
echo $retval;
