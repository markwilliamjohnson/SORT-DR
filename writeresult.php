<?php
function encodeURIComponent($str) {
    $revert = array('%21'=>'!', '%2A'=>'*', '%27'=>"'", '%28'=>'(', '%29'=>')');
    return strtr(rawurlencode($str), $revert);
}

$selbest = $_GET ["selectbest"];
$selworst = $_GET["selectworst"];
$apos = encodeURIComponent($_GET["apos"]);
$aneg = encodeURIComponent($_GET["aneg"]);
$bpos = encodeURIComponent($_GET["bpos"]);
$bneg = encodeURIComponent($_GET["bneg"]);
$conf = $_GET["conf"];
$user = $_GET["user"];
$buttonval = $_GET["butval"];
$mystr = $selbest . "," . $selworst . ", " . $apos . "," . $aneg . "," . $bpos . "," . $bneg . "," . $conf . "," . $user . "," . date("Y-m-d H:i:s") . ", " . $buttonval . "\n";
$myfile = fopen ("datafile.csv", "a");
fwrite ($myfile, $mystr);
fclose ($myfile);
?>
