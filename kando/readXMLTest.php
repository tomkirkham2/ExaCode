
<?php

$json_data = file_get_contents('datacubetactical.xml');
json_decode($json_data, true);
print_r($json_data);
?>
