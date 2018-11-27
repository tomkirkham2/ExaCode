<?php

function getPOS($output){
$stringFIND   = ",\"hits\":{\"total\":";
$stringFINDEND = ",\"max_score";
$pos = strpos($output, $stringFIND);
$pos = $pos +17;
$pos1 = strpos($output, $stringFINDEND);
$pos2 = $pos1 - $pos;
$out = substr($output, $pos, $pos2);
//echo " *********************** + $out + ******************************** ";
return $out;
}

?>
