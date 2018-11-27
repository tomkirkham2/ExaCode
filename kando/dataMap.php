<?php
include "tweetdata.php";
include "weatherdata.php";
include "articledata.php";
include "wikidata.php";
include "festivaldata.php";
include "sportsevents.php";
include "trafficdata.php";
include "crimeevents.php";
include "macsdata.php";
include "numResults.php";
include "businessevents.php";
include "peopledata.php";
include "osmdata.php";
include "getConfidence.php";
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("Protest", "indvban");
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("Weather", "rain");
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("Traffic", "High");
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("Festivals", "Eid");
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("Unknown Crowd", "0948");
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("High Crime", "Dakshinkhan");
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("Unrest", "corruption");
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("Sporting Crowd", "National%20Stadium");
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("Literacy", "rate");
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("No Embassy", "British Embassy");
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("Equiptment", "Minimum%20Temperature");
//echo "|||||||||||||||||||||||||||||||||||";
//echo map("PM News", "Hasina");
//echo "______________________________";


function map($threat)
{

if ($threat == "Protest")
{
$term = "indvban";

$tweets = getTweets($term);
$val = counter($tweets);

if ($val > 200){

$valf = 10;
}

if (($val < 200) && ($val > 150)){

$valf = 8;
}
if ($val < 150 && $val > 100){

$valf = 6;
}
if ($val > 70 && $val < 100){

$valf = 4;
}
if ($val > 50 && $val < 70){
$valf = 2;
}
if ($val < 50){

$valf = 1;
}

$conf = twitterConf();
$valf = $valf . ":" . $conf;
return $valf;

}

if ($threat == "Weather")
{
$term = "rain";
$rainProb = rainCheck($term);
$val = counter($rainProb);
//get prob
if ($val > 7){

$val = 10;
}
$conf = weatherConf();
$val = $val . ":" . $conf;

return $val;
}

if ($threat == "Traffic")
{
$term = "High";
$traf = searchTraffic($term);
$val = counter($traf);
//get prob
if ($val > 50){

$valf = 10;
}

if ($val < 50 && $val > 30){

$valf = 8;
}
if ($val < 30 && $val > 20){

$valf = 6;
}
if ($val > 10 && $val < 20){

$valf = 4;
}
if ($val > 5 && $val < 10){
$valf = 2;
}
if ($val < 5){
$valf = 1;
}

$conf = trafficConf();
$valf = $valf . ":" . $conf;


return $valf;

}

if ($threat == "Festivals")
{
$term = "Eid";
$fest = searchFestivals($term);
$val = counter($fest);
//echo "fest = " . $val;
//get prob
if ($val > 100){

$valf = 10;
}

if ($val < 100 && $val > 70){

$valf = 8;
}
if ($val < 70 && $val > 50){

$valf = 6;
}
if ($val > 30 && $val < 50){

$valf = 4;
}
if ($val > 10 && $val < 30){
$valf = 2;
}
if ($val < 10){
$valf = 1;
}
$conf = festivalsConf();
$valf = $valf . ":" . $conf;

return $valf;

}

if ($threat == "UnknownCrowd")
{
$term = "0948";
$macs = macsSearch($term);
//get prob
$val = counter($macs);
//echo "macs = " . $val; 
//get prob
if ($val > 50){

$valf = 10;
}

if ($val < 50 && $val > 35){

$valf = 8;
}
if ($val < 35 && $val > 25){

$valf = 6;
}
if ($val > 20 && $val < 25){

$valf = 4;
}
if ($val > 5 && $val < 20){
$valf = 2;
}
if ($val < 5){
$valf = 1;
}

$conf = unknownCrowdConf();
$valf = $valf . ":" . $conf;

return $valf;


}
if ($threat == "High Crime")
{
$term = "Dakshinkhan";
$crime = searchcrime($term);
$val = getCrimeDensity($crime);
if ($val > 7){

$valf = 10;
}

if ($val < 7 && $val > 5){

$valf = 8;
}
if ($val < 5 && $val > 3){

$valf = 6;
}
if ($val > 1 && $val < 3){

$valf = 4;
}
if ($val > 0.5 && $val < 1){
$valf = 2;
}
if ($val < 0.5){
$valf = 1;
}

$conf = highCrimeConf();
$valf = $valf . ":" . $conf;

//get prob
return $valf;

}
if ($threat == "Unrest")
{
$term = "corruption"; 
$unrest = getArticleCount($term);
//get prob
$val = counter($unrest);
//get prob
if ($val > 500){

$valf = 10;
}

if ($val < 500 && $val > 350){

$valf = 8;
}
if ($val < 350 && $val > 250){

$valf = 6;
}
if ($val > 200 && $val < 250){

$valf = 4;
}
if ($val > 50 && $val < 200){
$valf = 2;
}
if ($val < 50){
$valf = 1;
}
$conf = unrestConf();
$valf = $valf . ":" . $conf;

return $valf;

}
if ($threat == "SportsCrowd")
{
$term = "National%20Stadium";
$sports = searchSports($term);
//get prob
$dt = date('F j');
if (strpos($sports, $dt) !== false) {
    $val = 7;
}
else{

$val = 1;
//get prob
}
$conf = sportingCrowdConf();
$val = $val . ":" . $conf;

return $val;


}

if ($threat == "Equiptment")
{
$term = "Minimum%20Temperature";
$temp = rainCheck($term);
//echo $temp;
$val = getMinTemp($temp);

if ($val > 30){

$valf = 10;
}

if ($val < 30 && $val > 25){

$valf = 8;
}
if ($val < 25 && $val > 20){

$valf = 6;
}
if ($val > 15 && $val < 20){

$valf = 4;
}
if ($val > 15 && $val < 20){
$valf = 2;
}
if ($val < 15){
$valf = 1;
}

$conf = equiptmentConf();
$valf = $valf . ":" . $conf;


return $valf;


}
if ($threat == "PM News")
{
$term = "Hasina";
$inter = peopleSearch($term);
$val = counter($inter);
//get prob
if ($val > 50){

$valf = 10;
}

if ($val < 50 && $val > 35){

$valf = 8;
}
if ($val < 35 && $val > 25){

$valf = 6;
}
if ($val > 20 && $val < 25){

$valf = 4;
}
if ($val > 5 && $val < 20){
$valf = 2;
}
if ($val < 5){
$valf = 1;
}

$conf = newsConf();
$valf = $valf . ":" . $conf;

return $valf;


}
if ($threat == "No Embassy")
{
$term = "British Embassy"; 
$emb = getOsm($term);
//get prob
if (strpos($emb, $term) !== false) {
    $val = 1;
}
else{

$val = 7;
//get prob
}

$conf = embassyConf();

$val = $val . ":" . $conf;

return $val;





}
if ($threat == "Literacy")
{
$term = "rate";
$lr = searchWiki($term);
//echo $lr;
//get prob
$val = getRate($lr);
if ($val < 30){

$valf = 10;
}

if ($val < 50 && $val > 30){

$valf = 8;
}
if ($val < 60 && $val > 50){

$valf = 6;
}
if ($val > 60 && $val < 85){

$valf = 4;
}
if ($val > 85 && $val < 95){
$valf = 2;
}
if ($val > 95){
$valf = 1;
}

$conf = literacyConf();
$valf = $valf . ":" . $conf;

return $valf;


}



}



function counter($dataRes)
{

$pos = getPOS($dataRes);
return $pos;


}

function getCrimeDensity($crime)
{

$stringFIND   = "DensityofCrime";
$stringFINDEND = "geolocation";
$pos = strpos($crime, $stringFIND);
$pos = $pos +16;
$pos1 = strpos($crime, $stringFINDEND);
$pos2 = $pos1 - $pos-2;
$out = substr($crime, $pos, $pos2);
return $out;

}
function getRate($lr)
{
//echo $lr;
$stringFIND   = "rate";
$stringFINDEND = "%";
$pos = strpos($lr, $stringFIND);
//echo $pos;
$pos = $pos +6;
//echo $pos;
$lr = substr($lr, $pos, $pos +30);
//echo $lr;
$pos1 = strpos($lr, $stringFINDEND);
//echo $pos1;
$pos2 = $pos - $pos1;
//echo $pos2;
$out = substr($lr, '2', $pos1-2);
//echo $out;
return $out;
}

function getMinTemp($temp)
{
//echo $temp;
$tempFind = "Minimum Temperature";
//echo "<<<<<<<<<<<<<<<";
$pos = strpos($temp, $tempFind);
//echo $pos;
//echo "  ";
$pos = $pos +20;
//echo $pos;
//echo "---------";
$temp = substr($temp, $pos, $pos +10);
$pos1 = strpos($temp, "C ");
$temp = substr($temp, '0', $pos1 -2);
//echo $temp;
$temp = trim($temp);
return $temp;

}





?>
