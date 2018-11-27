<?php
//require('riskCalc.php');
//echo "start ";

function writeRisk($riskName, $riskScore)
{
//echo $risk;
//Protest

if ($riskName == "Protest"){
//echo "in protest";
writeProtest($riskScore);

}
if ($riskName == "Festivals"){
//echo "in festivals";
writeFestivals($riskScore);

}
if ($riskName == "Weather"){
//echo "in weather";
writeWeather($riskScore);

}
if ($riskName == "Traffic"){
//echo "in traffic";
writeTraffic($riskScore);

}
 
}

function writeProtest($riskScore)
{
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Protest Square\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.73767,90.39604\"}'", $retval);

//Protest
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Opposition Area\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.71935,90.40280\"}'", $retval);

//Protest
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Opposition Area\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.7939,90.3675\"}'", $retval);

//Protest
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Parliament\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.76243,90.37854\"}'", $retval);

//Protest
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"President House\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.72335,90.41805\"}'", $retval);

//Protest
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Police HQ\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.7401,90.4170\"}'", $retval);

//Protest
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Military Base\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.7309,90.3729\"}'", $retval);

//Protest
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Ex Pat Residential\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.7520,90.3429\"}'", $retval);


}

function writeTraffic($riskScore)
{
//Traffic
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Main Hospital\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.7251,90.3986   \"}'", $retval);

//Traffic
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Central Station\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.7303,90.4251\"}'", $retval);

//Traffic
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Hotel Area\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.8303,90.4260\"}'", $retval);

}

function writeFestivals($riskScore)
{
//Festivals
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Cricket Ground\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.7263,90.4106\"}'", $retval);

//Festivals
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Trade Expo\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.7666,90.3779\"}'", $retval);
}

function writeWeather($riskScore)
{
//Weather
$write = exec("curl -X POST 'http://127.0.0.1:9200/dstl/riskregister' -d '{\"Impact\":\"5\",\"Name\":\"Airport\",\"Probability\":0.1,\"RiskID\":$riskScore, \"Timestamp\":\"2016-05-05\", \"coordinates\":\"23.8427,90.4034 \"}'", $retval);
 
}




?>


