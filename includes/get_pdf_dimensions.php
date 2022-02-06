<?php
// Function by fltman - https://stackoverflow.com/questions/9622357/php-get-height-and-width-in-pdf-file-proprieties?rq=1
function get_pdf_dimensions($path, $box="MediaBox") {
    //$box can be set to BleedBox, CropBox or MediaBox 

    $stream = new SplFileObject($path); 

    $result = false;
	
	
    while (!$stream->eof()) {
        if (preg_match("/".$box."\[[0-9]{1,}.[0-9]{1,} [0-9]{1,}.[0-9]{1,} ([0-9]{1,}.[0-9]{1,}) ([0-9]{1,}.[0-9]{1,})\]/", $stream->fgets(), $matches)) {
            $result["width"] = round($matches[1]);
            $result["height"] = round($matches[2]); 
            break;
        }
    }

    $stream = null;

    return $result;
	
}


?>
