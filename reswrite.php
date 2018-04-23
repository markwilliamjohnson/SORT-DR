<?php
$file = fopen ("changethis.csv", "r");
$csvval = "";
for ($n=0;$n<$index;$n++) 
{
$csvval = fgetcsv ($file, ",");
}
$imga = urldecode ($csvval[0]);
$imgb = urldecode ($csvval[1]);

