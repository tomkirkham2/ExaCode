<?php
//require('numResults.php');
//echo "start";
function getArticleCount($searchTerm)
{
     // create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, "http://127.0.0.1:9200/dstl/article/_search?q=$searchTerm"); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 

        // $output contains the output string 
        $output = curl_exec($ch); 


      //  echo $output;

        // close curl resource to free up system resources 
        curl_close($ch);      

return $output; 
//echo "fin";
}
?>
