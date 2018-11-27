<?php
//include'getImpacts.php';
include'getRisk.php';
include'riskWrite.php';
$ctr=1;

//Get the operation from the form
$cubeName = $_POST["cube"];
//echo $cube;
//$cubeName = "datacubetactical.xml";
//Get threats and impacts for operation
$cube = file_get_contents($cubeName);
$cnt = substr_count($cube, "Column");
while ($ctr <= $cnt ){
$act = "action" . $ctr;

$ctr++;
}
//get Impacts
$actions = getImpacts($cubeName, $act);

//getRisk Vals
$risk = getRisk($actions);

//Clear Risk Reg

$del = exec("curl -XDELETE 'http://127.0.0.1:9200/dstl/riskregister/?pretty=true'");


//getConfidence Vals
//Write Risks
$risks = explode(":", $risk);
$c = sizeof($risks);
$i = 0;
while ($i < $c)
{
$length = strlen($risks[$i]);
$pos = strpos($risks[$i], "=");
$riskName = substr($risks[$i] ,'0', $pos);
$riskName = trim($riskName);
$riskScor = substr($risks[$i],$pos+1,$length);
$riskScor = trim($riskScor);
$exp = explode("+", $riskScor);
if ($i == 0){
$riskNameArr = array($riskName);
$riskScoreArr = array($exp[0]);
$riskConfArr= array($exp[1]);
}

else{
array_push($riskNameArr, $riskName);
array_push($riskScoreArr, $exp[0]);
array_push($riskConfArr, $exp[1]);

}
if ($cubeName == "datacubetactical.xml")
{
$res = writeRisk($riskName, $exp[0]);
}
$i++;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
  <meta content="text/html; charset=ISO-8859-1"
 http-equiv="content-type">
  <title></title>
</head>
<body>
<table
 style="width: 694px; text-align: left; margin-left: auto; margin-right: auto;"
 border="1" cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td style="width: 96px; font-weight: bold;"><big><big>Risk</big></big></td>
      <td style="width: 234px; font-weight: bold;"><big><big>Score</big></big></td>
      <td style="width: 359px; font-weight: bold;"><big><big>Confidence</big></big></td>
    </tr>
    <tr>
      <td style="width: 96px;"><big><big><?php echo $riskNameArr[0]?></big></big></td>
      <td style="width: 234px;"><big><big><?php echo $riskScoreArr[0]?></big></big></td>
      <td style="width: 359px;"><big><big><?php echo $riskConfArr[0]?></big></big></td>
    </tr>
    <tr>
      <td style="width: 96px;"><big><big><?php echo $riskNameArr[1]?></big></big></td>
      <td style="width: 234px;"><big><big><?php echo $riskScoreArr[1]?></big></big></td>
      <td style="width: 359px;"><big><big><?php echo $riskConfArr[1]?></big></big></td>
    </tr>
    <tr>
      <td style="width: 96px;"><big><big><?php echo $riskNameArr[2]?></big></big></td>
      <td style="width: 234px;"><big><big><?php echo $riskScoreArr[2]?></big></big></td>
      <td style="width: 359px;"><big><big><?php echo $riskConfArr[2]?></big></big></td>
    </tr>
    <tr>
      <td style="width: 96px;"><big><big><?php echo $riskNameArr[3]?></big></big></td>
      <td style="width: 234px;"><big><big><?php echo $riskScoreArr[3]?></big></big></td>
      <td style="width: 359px;"><big><big><?php echo $riskConfArr[3]?></big></big></td>
    </tr>
  </tbody>
</table>
<div style="text-align: center;"><br>
</div>
<br> 


<?php 

$knit1 = $riskNameArr[0] . ":" .  $riskScoreArr[0] . ":" . $riskConfArr[0];
$knit2 = $riskNameArr[1] . ":" .  $riskScoreArr[1] . ":" .  $riskConfArr[1];
$knit3 = $riskNameArr[2] . ":" .  $riskScoreArr[2] . ":" .  $riskConfArr[2];
$knit4 = $riskNameArr[3] . ":" .  $riskScoreArr[3] . ":" .  $riskConfArr[3];

$knit = $knit1 . "-" . $knit2 . "-" . $knit3 . "-" . $knit4;
$knit = str_replace(' ','',$knit);


if ($_POST["cube"] == "datacubetactical.xml"){
echo "<big><big><big>Click <a href=http://127.0.0.1:5601/#/visualize/edit/Riskregister3?_g=%28%29&amp;_a=%28filters:%21%28%29,linked:%21t,query:%28query_string:%28query:%27*%27%29%29,vis:%28aggs:%21%28%28id:%271%27,params:%28%29,schema:metric,type:count%29,%28id:%272%27,params:%28autoPrecision:%21t,field:coordinates,mapCenter:%21%2823.71907904630928,90.40091514587402%29,mapZoom:11,precision:6%29,schema:segment,type:geohash_grid%29%29,listeners:%28%29,params:%28addTooltip:%21t,heatBlur:%2722%27,heatMaxZoom:%2717%27,heatMinOpacity:%270.28%27,heatNormalizeData:%21t,heatRadius:%2725%27,isDesaturated:%21f,mapType:Heatmap%29,type:tile_map%29%29'> here</a> to view results </big></big></big><br>"
;}
if ($_POST["cube"] == "datacubeoperational.xml"){

/*$knit1 = $riskNameArr[0] . ":" .  $riskScoreArr[0] . ":" . $riskConfArr[0]; 
$knit2 = $riskNameArr[1] . ":" .  $riskScoreArr[1] . ":" .  $riskConfArr[1]; 
$knit3 = $riskNameArr[2] . ":" .  $riskScoreArr[2] . ":" .  $riskConfArr[2];
$knit4 = $riskNameArr[3] . ":" .  $riskScoreArr[3] . ":" .  $riskConfArr[3]; 

$knit = $knit1 . "-" . $knit2 . "-" . $knit3 . "-" . $knit4;
$knit = str_replace(' ','',$knit);
*/


echo "<big><big><big>Click <a href=http://sig-25.esc.rl.ac.uk/kandoDash/kandoDashOp.php?data=$knit>here</a> to view results </big></big></big><br>";
}

if ($_POST["cube"] == "datacubestrategic.xml"){
echo "<big><big><big>Click <a href=http://sig-25.esc.rl.ac.uk/kandoDash/kandoDashSt.php?data=$knit> here</a> to view results </big></big></big><br>";
}

?>


</body>
</html>

