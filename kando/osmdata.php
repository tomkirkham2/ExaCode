<?php
//require('numResults.php');

function getOsm($searchTerm)
{
     // create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:9200/dstl/osmpoi/_search?q=$searchTerm"); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

   $output_t = curl_exec($ch);

//$nr = new numResults;

        // $output contains the output string 
         
    
        // close curl resource to free up system resources 
        curl_close($ch);      
return $output_t;
}
?>
