<?php
function sizecheck($width, $height, $size) {
	$result = array();
	$dim = array($width,$height);

	if ($size == "a4") {
		switch ($dim) {
    
		case (($dim[0] == 2480 && $dim[1] == 3508) || ($dim[0] == 3508 && $dim[1] == 2480))  :
			$result[0] = 1;
			$result[1] = 300;
			break;
		case (($dim[0] == 595 && $dim[1] == 842) || ($dim[0] == 842 && $dim[1] == 595)) :
			$result[0] = 1;
			$result[1] = 72;
			break;
		case (($dim[0] == 2528  && $dim[1] == 3555) || ($dim[0] == 3555  && $dim[1] == 2528)) :
			$result[0] = 2;
			$result[1] = 300;
			break;
		case (($dim[0] == 607 && $dim[1] == 853) || ($dim[0] == 853 && $dim[1] == 607)) :
			$result[0] = 2;
			$result[1] = 72;
			break;
		default :
			$result[0] = 0;
			
		} 
	} elseif ($size == "a5") {	
		switch ($dim) {
    
		case ((($dim[0] == 1748 || $dim[0] == 1754) && $dim[1] == 2480) || ($dim[0] == 2480 && ($dim[1] == 1748 || $dim[1] == 1754))) :
			$result[0] = 1;
			$result[1] = 300;
			break;
		case ((($dim[0] == 420 || $dim[0] == 421) && $dim[1] == 595) || ($dim[0] == 595 && ($dim[1] == 420 || $dim[1] == 421))) :
			$result[0] = 1;
			$result[1] = 72;
			break;
		case ((($dim[0] == 1801 || $dim[0] == 1795) && $dim[1] == 2528) || ($dim[0] == 2528 && ($dim[1] == 1801 || $dim[1] == 1795))) :
			$result[0] = 2;
			$result[1] = 300;
			break;
		case ((($dim[0] == 432 || $dim[0] == 431) && $dim[1] == 607) || ($dim[0] == 607 && ($dim[1] == 432 || $dim[1] == 431))) :
			$result[0] = 2;
			$result[1] = 72;
			break;
		default :
			$result[0] = 0;
			
		} 
	} elseif ($size == "a6") {	
		switch ($dim) {
    
		case (($dim[0] == 1240 && ($dim[1] == 1754 || $dim[1] == 1748)) || (($dim[0] == 1754 || $dim[0] == 1748) && $dim[1] == 1240)) :
			$result[0] = 1;
			$result[1] = 300;
			break;
		case (($dim[0] == 298 && ($dim[1] == 421 || $dim[1] == 420)) || (($dim[0] == 421 || $dim[0] == 420) && $dim[1] == 298))  :
			$result[0] = 1;
			$result[1] = 72;
			break;
		case (($dim[0] == 1287 && ($dim[1] == 1801 || 1795)) || (($dim[0] == 1801 || $dim[0] == 1795) && $dim[1] == 1287)) :
			$result[0] = 2;
			$result[1] = 300;
			break;
		case (($dim[0] == 309 && ($dim[1] == 432 || $dim[1] == 431)) || (($dim[0] == 432 || $dim[0] == 431) && $dim[1] == 309)) :
			$result[0] = 2;
			$result[1] = 72;
			break;
		default :
			$result[0] = 0;
			
		}; 
	
	} elseif ($size == "Business Card") {	
		switch ($dim) {
    
		case (($dim[0] == 1004 && $dim[1] == 650) || ($dim[0] == 650 && $dim[1] == 1004)) :
			$result[0] = 1;
			$result[1] = 300;
			break;
		case (($dim[0] == 241 && $dim[1] == 156) || ($dim[0] == 156 && $dim[1] == 241)) :
			$result[0] = 1;
			$result[1] = 72;
			break;
		case (($dim[0] == 1051 && $dim[1] == 697) || ($dim[0] == 697 && $dim[1] == 1051)) :
			$result[0] = 2;
			$result[1] = 300;
			break;
		case (($dim[0] == 252 && $dim[1] == 167) || ($dim[0] == 167 && $dim[1] == 252)) :
			$result[0] = 2;
			$result[1] = 72;
			break;
		default :
			$result[0] = 0;
			
		}; 
	
	
	}else {
		return 0;
	}
	return $result;
}


?>