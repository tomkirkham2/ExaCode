<?php


function getImpacts($cube, $action)
{

$cube = file_get_contents($cube);

$length = strlen($cube);

$pos = strpos($cube, $action);



$subs = substr($cube ,$pos, $length);
if (strpos($subs, 'Column') !== false) {
$pos1 = strpos($subs, "Column");
$subs = substr($subs, '0', $pos1);
}
$ops = getThreats($subs, $action);
//print_r($ops);
return $ops;
}

function getThreats($subs, $action)
{
$combi2 = "";
$ctr = 0;
$cnt = substr_count($subs, 'refThreat');
$sub2 = $subs;
while ($cnt > $ctr ){
if (strpos($subs, 'refThreat') !== false){
$pos3 = strpos($subs, "refThreat");
$pos11 = strpos($sub2, "eg:threatImportance");
//echo "********************************************************************";
//echo $sub2;
//echo "  ***********************************************************************************************************  ";
$pos4 = strlen($subs);
$pos3 = ($pos3 + 9);
$subs = substr($subs, $pos3, $pos4);
//echo " subs = " . $subs; 
$sub2= substr($sub2, $pos11 + 19, $pos4);
$pos5 = strpos($subs, '"');
$pos6 = strpos($sub2, ';');
$threatName = substr($subs, $pos5 + 1, $pos6);
$threatName = str_replace('"','',$threatName);
$threatName = str_replace(';','',$threatName);
$threatName = trim($threatName);
$threatImp = substr($sub2, '0', $pos6);
//$threatImp = str_replace('"','',$threatImp);
$threatImp = str_replace(';','',$threatImp);
$threatImp = trim($threatImp);
if ($ctr == 0){
//echo " Threat Name = " . $threatName;
$combi = ($threatName ."=". $threatImp);
}
else
{
$combi = (":". $threatName ."=". $threatImp);
} 
//echo "pos da nos = ";
//if ($ctr == 0){
//$operations = array($combi);
//}

//else{
//array_push($operations, $combi);
//}
$combi2 = ($combi2 .$combi);
//echo $threatName;
//echo $threatImp; 
//$val = 
//echo "**********************************************************";
//echo $subs;
//echo "**********************************************************";
}
$ctr ++;
}
return $combi2;
}


?>
