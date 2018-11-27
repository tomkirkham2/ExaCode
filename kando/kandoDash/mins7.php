<?php

$z = $_GET["time"];
$servername = "localhost";
$username = "root";
$password = "huthwaite";
$dbname = "Hannover";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$time = time();
$sql = "SELECT MIN(time) as time FROM `macs`";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {




$t = $time - $row['time'];
$r = round($t/60, 0, PHP_ROUND_HALF_DOWN);
$f =  $r - $z;
echo $f;
}
}




?>
