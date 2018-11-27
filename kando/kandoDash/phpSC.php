<?php
echo '<pre>';
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');

// Outputs all the result of shellcommand "ls", and returns
// the last output line into $last_line. Stores the return value
// of the shell command in $retval.
$last_line = system('sudo tcpdump -i wlan0 -j host -e -s 256 type mgt subtype probe-req', $retval);

// Printing additional info
echo '
</pre>
<hr />Last line of the output: ' . $last_line . '
<hr />Return value: ' . $retval;
flush();
?>