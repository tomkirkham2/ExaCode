<?php
include'dataMap.php';
include'getImpacts.php';

//$data = getImpact("
$data = getImpacts("datacubetactical.xml", "action3");
//echo $data;
getRisk($data);

function getRisk($data)
{
$i=0;

//split data into threats and impacts

$threats = explode(":", $data);
$c = sizeof($threats);

while ($i < $c)
{
$length = strlen($threats[$i]);
$pos = strpos($threats[$i], "=");
$threat = substr($threats[$i] ,'0', $pos);
$impact = substr($threats[$i],$pos+1,$length);
//get threat value

$prob = map($threat);
$prob = explode(":", $prob); 

if ($i == 0){
$threatProb = array($prob[0]);
$threatImpa = array($impact);
$threatConf  = array($prob[1]);
}

else{
array_push($threatProb, $prob[0]);
array_push($threatImpa, $impact);
array_push($threatConf, $prob[1]);
}



$i++;
}

//Apply Impact
$e = 0;
$d = sizeof($threatProb);

while ($e < $d)
{
$pos2 = strpos($threats[$e], "=");
$dathreat = substr($threats[$e] ,'0', $pos2);

if ($e == 0){

$risk = ($dathreat ."=". ($threatProb[$e] * $threatImpa[$e]) ."+". $threatConf[$e]);

}
else
{
$risk = ($risk .":". $dathreat ."=". ($threatProb[$e] * $threatImpa[$e])."+". $threatConf[$e]);
}
$e++;
}


return $risk;




}

?>
