<?php
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$last_line = system('sudo tcpdump -i wlan0 -j host -e -s 256 type mgt subtype probe-req', $retval);
$time = date('r');
echo "data: The server time is: {$time}\n\n";
echo "last line: {$last_line}\n\n";
flush();
?>

