<?php
require('numResults.php');
echo "start";

     // create curl resource 
        $ch = curl_init(); 

echo " 1 ";        // set url 
        curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:9200/dstl/riskregister/_search?q=*:*"); 
echo " 2 ";
        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
echo " 3 ";
        // $output contains the output string 
        $output = curl_exec($ch); 
echo " 4 ";
//echo "---------------------- " + $output + " -----------------------";  
        echo $output;
//getPOS($output);
echo " 5 ";
        // close curl resource to free up system resources 
        curl_close($ch);      


echo "fin";
?>
