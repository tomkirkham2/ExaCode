<?php


$del = system("curl -XDELETE 'http://127.0.0.1:9200/dstl/riskregister/?pretty=true'");
echo $del;




?>
