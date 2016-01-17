<?php
$cty = fopen("http://gd.geobytes.com/gd?after=-1&variables=GeobytesCountry,GeobytesCity","r");
echo fread($cty,1000);
?>