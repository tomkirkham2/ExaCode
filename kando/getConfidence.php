<?php
//include "tweetdata.php";
//include "weatherdata.php";
//include "articledata.php";
//include "wikidata.php";
//include "festivaldata.php";
//include "sportsevents.php";
//include "trafficdata.php";
//include "crimeevents.php";
//include "macsdata.php";
//include "numResults.php";
//include "businessevents.php";
//include "peopledata.php";
//include "osmdata.php";
//include "dataMap.php";

//for test
/*
echo "---------";
echo twitterConf();
echo "---------";
echo weatherConf();
echo "---------";
echo trafficConf();
echo "---------";
echo festivalsConf();
echo "---------";
echo unknownCrowdConf();
echo "---------";
echo highCrimeConf();
echo "---------";
echo unrestConf();
echo "---------";
echo sportingCrowdConf();
echo "---------";
echo equiptmentConf();
echo "---------";
echo newsConf();
echo "---------";
echo embassyConf();
echo "---------";
echo literacyConf();
echo "---------";
*/
//each data source has a trust score between 0.1 and 1.0


//each data source has a stength score between 1 and 10 ranked on the size of the sample

function twitterConf()
{
$tweets = getTweets("*");
$val = counter2($tweets);

if ($val > 200000){

$valf = 10;
}

if (($val < 100000) && ($val > 50000)){

$valf = 8;
}
if ($val < 50000  && $val > 30000){

$valf = 6;
}
if ($val > 10000 && $val < 30000){

$valf = 4;
}
if ($val > 500 && $val < 10000){
$valf = 2;
}
if ($val < 500){

$valf = 1;
}

return $valf;

}

function weatherConf()
{

$val = 6;

return $val;
}




function trafficConf()
{
$traf = searchTraffic("*");
$val = counter2($traf);
//get prob
if ($val > 500){

$valf = 10;
}

if ($val < 500 && $val > 400){

$valf = 8;
}
if ($val < 400 && $val > 250){

$valf = 6;
}
if ($val > 100 && $val < 250){

$valf = 4;
}
if ($val > 50 && $val < 100){
$valf = 2;
}
if ($val < 50){
$valf = 1;
}


return $valf;

}



function festivalsConf()
{
$fest = searchFestivals("*");
$val = counter2($fest);
//get prob
if ($val > 300){

$valf = 10;
}

if ($val < 300 && $val > 200){

$valf = 8;
}
if ($val < 200 && $val > 100){

$valf = 6;
}
if ($val > 50 && $val < 100){

$valf = 4;
}
if ($val > 10 && $val < 50){
$valf = 2;
}
if ($val < 10){
$valf = 1;
}

return $valf;

}


function unknownCrowdConf()
{

$macs = macsSearch("*");
//get prob
$val = counter2($macs);
//get prob
if ($val > 100000){

$valf = 10;
}

if ($val < 100000 && $val > 70000){

$valf = 8;
}
if ($val < 70000 && $val > 50000){

$valf = 6;
}
if ($val > 25000 && $val < 50000){

$valf = 4;
}
if ($val > 10000 && $val < 25000){
$valf = 2;
}
if ($val < 10000){
$valf = 1;
}

return $valf;


}

function highCrimeConf()
{
$crime = searchcrime("*");
$val = counter2($crime);
if ($val > 50){

$valf = 10;
}

if ($val < 50 && $val > 40){

$valf = 8;
}
if ($val < 40 && $val > 30){

$valf = 6;
}
if ($val > 20 && $val < 30){

$valf = 4;
}
if ($val > 10 && $val < 20){
$valf = 2;
}
if ($val < 10){
$valf = 1;
}

//get prob
return $valf;

}

function unrestConf()
{
$unrest = getArticleCount("*");
//get prob
$val = counter2($unrest);
//get prob
if ($val > 4000){

$valf = 10;
}

if ($val < 4000 && $val > 3000){

$valf = 8;
}
if ($val < 3000 && $val > 1500){

$valf = 6;
}
if ($val < 1500 && $val > 500){

$valf = 4;
}
if ($val > 100 && $val < 500){
$valf = 2;
}
if ($val < 100){
$valf = 1;
}

return $valf;

}

function sportingCrowdConf()
{

$sports = searchSports("*");
$val = counter2($sports);
if ($val > 500){

$valf = 10;
}

if ($val < 500 && $val > 400){

$valf = 8;
}
if ($val < 400 && $val > 300){

$valf = 6;
}
if ($val > 300 && $val > 200){

$valf = 4;
}
if ($val > 100 && $val < 200){
$valf = 2;
}
if ($val < 100){
$valf = 1;
}
return $valf;


}


function equiptmentConf()
{
$temp = rainCheck("*");
//echo $temp;
$val = counter2($temp);

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
if ($val < 15 && $val > 10){
$valf = 2;
}
if ($val < 10){
$valf = 1;
}

return $valf;


}

function newsConf()
{
$inter = peopleSearch("*");
$val = counter2($inter);
//get prob
$valf = 3;
if ($val > 1000){

$valf = 10;
}

if ($val < 1000 && $val > 750){

$valf = 8;
}
if ($val < 750 && $val > 500){

$valf = 6;
}
if ($val < 500 && $val > 250){

$valf = 4;
}
if ($val > 100 && $val < 250){
$valf = 2;
}
if ($val < 100){
$valf = 1;
}

return $valf;
}

function embassyConf()
{
 
$emb = getOsm("*");
$val = counter2($emb);

if ($val > 250000){

$valf = 10;
}

if ($val < 250000 && $val > 150000){

$valf = 8;
}
if ($val < 150000 && $val > 50000){

$valf = 6;
}
if ($val > 25000 && $val < 50000){

$valf = 4;
}
if ($val > 10000 && $val < 25000){
$valf = 2;
}
if ($val < 10000 ){
$valf = 1;
}



return $valf;


}

function literacyConf()
{
$lr = searchWiki("*");
$val = counter2($lr);
if ($val > 5000 ){

$valf = 10;
}

if ($val < 5000 && $val > 3000){

$valf = 8;
}
if ($val < 3000 && $val > 1000){

$valf = 6;
}
if ($val > 500 && $val < 1000){

$valf = 4;
}
if ($val > 300 && $val < 500){
$valf = 2;
}
if ($val < 300){
$valf = 1;
}


return $valf;


}
// trust * strength = confidence on a scale of 0 to 10



function counter2($dataRes)
{

$pos = getPOS($dataRes);
return $pos;


}



?>

