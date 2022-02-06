<?php
//returns 0 for wrong size, 1 for correct size, 2 for correct size with bleeds
function pdfchecker($width, $height, $size){
	
	$result = array();
	if($size == "a4"){
		if(($width == 595 && $height == 842) || ($width == 842 && $height == 595)){
			return 1;
		}else if(($width == 607 && $height == 853) || ($width == 853 && $height == 607)){
			return 2;
		}else{
			return 0;
		}
	}elseif($size == "a5"){
		if((($width == 421 || $width == 420) && $height == 595) || ($width == 595 && ($height == 421 || $height == 420))){
			return 1;
		}else if((($width == 432 || $width == 431) && $height == 607) || ($width == 607 && ($height == 432 || $height == 431))){
			return 2;
		}else{
			return 0;
		}
	}elseif($size == "a6"){
		if(($width == 298 && ($height == 421 || $height == 420)) || (($width == 421 || $width == 420) && $height == 298)){
			return 1;
		}else if(($width == 309 && ($height == 432 || $height == 431)) || (($width == 432 || $width == 431) && $height == 309)){
			return 2;
		}else{
			return 0;
		}
	}elseif($size == "bc"){
		if(($width == 241 && $height == 156) || ($width == 156 && $height == 241)){
			return 1;
		}else if(($width == 252 && $height == 167) || ($width == 167 && $height == 252)){
			return 2;
		}else{
			return 0;
		}
	}else{
		return 0;
	}
	

}

?>