<?php
function sizecheck($width, $height, $size) {
	$result = array();
	$dim=array($width,$height);

	if ($size == "a4") {
		switch ($dim) {
    
		case $dim[0] < 2490 || $dim[0] > 2470 && $dim[1] < 3518 || $dim[1] > 3498 :
			$result[0] = "No bleeds applied";
			$result[1] = 300;
			break;
		case $dim[0] < 605 || $dim[0] > 585 && $dim[1] < 852 || $dim[1] > 832 :
			$result[0] = "No bleeds applied";
			$result[1] = 72;
			break;
		case $dim[0] < 2538 || $dim[0] > 2528 && $dim[1] < 3565 || $dim[1] > 3545 :
			$result[0] = "2mm Bleeds found";
			$result[1] = 300;
			break;
		case $dim[0] < 617 || $dim[0] > 597 && $dim[1] < 863|| $dim[1] > 843:
			$result[0] = "2mm Bleeds found";
			$result[1] = 72;
			break;
		default :
			$result[0] = "The size is not A4";
			
		} 
	} elseif ($size == "a5") {	
		switch ($dim) {
    
		case $dim[0] < 1758 || $dim[0] > 1738 && $dim[1] < 2490 || $dim[1] > 2470 :
			$result[0] = "No bleeds applied";
			$result[1] = 300;
			break;
		case $dim[0] < 430 || $dim[0] > 410 && $dim[1] < 605 || $dim[1] > 585 :
			$result[0] = "No bleeds applied";
			$result[1] = 72;
			break;
		case $dim[0] < 1811 || $dim[0] > 1791 && $dim[1] < 2538 || $dim[1] > 2518 :
			$result[0] = "2mm Bleeds found";
			$result[1] = 300;
			break;
		case $dim[0] < 442 || $dim[0] > 422 && $dim[1] < 617 || $dim[1] > 597 :
			$result[0] = "2mm Bleeds found";
			$result[1] = 72;
			break;
		default :
			$result[0] = "The size is not A5";
			
		} 
	} elseif ($size == "a6") {	
		switch ($dim) {
    
		case $dim[0] < 1250 || $dim[0] > 1230 && $dim[1] < 1764 || $dim[1] > 1744 :
			$result[0] = "No bleeds applied";
			$result[1] = 300;
			break;
		case $dim[0] < 308 || $dim[0] > 288 && $dim[1] < 431 || $dim[1] > 411 :
			$result[0] = "No bleeds applied";
			$result[1] = 72;
			break;
		case $dim[0] < 1297 || $dim[0] > 1277 && $dim[1] < 1811 || $dim[1] > 1791 :
			$result[0] = "2mm Bleeds found";
			$result[1] = 300;
			break;
		case $dim[0] < 319 || $dim[0] > 299 && $dim[1] < 442 || $dim[1] > 422 :
			$result[0] = "2mm Bleeds found";
			$result[1] = 72;
			break;
		default :
			$result[0] = "The size is not A6";
			
		}; 
	
	} else {
		return FALSE;
	}
	return $result;
}
$sz = "a5";
$hmm = sizecheck(432, 607, $sz);
print_r($hmm);

?>