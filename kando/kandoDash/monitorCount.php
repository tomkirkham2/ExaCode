<?php

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
$stamp = time();
//echo " stamp1 ";
//echo $stamp;
$stamp2 = time() - 10;
echo " stamp2 ";
echo $stamp2;
//echo "    --- ";
//sleep(0.3);
$sql = "SELECT DISTINCT mac FROM macs WHERE time > $stamp2";
$result = $conn->query($sql);

$rows = $result->num_rows;

echo $rows;
$cnt = 0;
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {  
}
} else {
    echo "0";
}

$conn->close();

?>
