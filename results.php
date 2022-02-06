<?php
//includes
require 'includes/header.include.php';
include 'functions/sizechecker3.php';
include 'functions/pdfchecker.php';

//starting variables
$flag = 0;
$path = "";
$checked = array();
$issues = array();
$errors = array();
$orientation = "Portrait";
//checking submission
if(isset($_SESSION['submitted']) && isset($_SESSION['file_count'])){
	$path = $_SESSION['file1_extension'];
	$size = $_SESSION['selected_size'];
	$file_count = $_SESSION['file_count'];
	$file1_name = $_SESSION['file1_name'];
	if($_SESSION['file_count'] == 2){
		$file2_name = $_SESSION['file2_name'];
	}
	
	if($size != "Business Card"){
		$cap_size = strtoupper($size);
	}else{
		$cap_size = $size;
	}
	
	if($size == "a4"){
		$suggested_size = "210mm x 297mm";
	}elseif($size == "a5"){
		$suggested_size = "148.5mm x 210mm";
	}elseif($size == "a6"){
		$suggested_size = "105mm x 148.5";
	}elseif($size == "Business Card"){
		$suggested_size = "85mm x 55mm";
	}
	
	//checking PDF files
	if($path == "pdf"){
		$pdf_width = $_SESSION['pdf_width'];
		$pdf_height = $_SESSION['pdf_height'];
		$result = pdfchecker($pdf_width, $pdf_height, $size);
		
		//determining file orientation
		if($pdf_width > $pdf_height){
			$orientation = "Landscape";
		}
		$issues[] = "Unable to check clour profile and resolution for PDF files. Export your file as JPG or click here to find out how to check the colour profile of your document.";
		$checked[] = "The orientation of your file is $orientation.";
		
		
		if($result == 1){
			$issues['_No bleeds'] = "FILE 1: Lack of bleeds: Your artwork is at risk and might get cut wrongly. Add 2mm to each side of your artwork. Click here to find out how or get technical assistance.";
			$checked[] = "FILE 1: Your artwork has the correct size for $cap_size.";
		}elseif($result == 2){
			$checked[] = "FILE 1: Your artwork has the correct size for $cap_size.";
			$checked[] = "FILE 1: Your artwork includes 2mm bleeds.";
		}else{
			$errors['_Wrong size'] = "The FILE 1 is not $cap_size. The size for $cap_size is: $suggested_size.";
		
		}
		if($file_count == 2){
			
			$pdf_width2 = $_SESSION['pdf_width2'];
			$pdf_height2 = $_SESSION['pdf_height2'];
			$result2 = pdfchecker($pdf_width2, $pdf_height2, $size);
			if($result2 == 1){
			$issues['.No bleeds'] = "FILE 2: Lack of bleeds: Your artwork is at risk and might get cut wrongly. Add 2mm to each side of your artwork. Click here to find out how or get technical assistance.";
			$checked[] = "FILE 2: Your artwork has the correct size for $cap_size.";
			}elseif($result2 == 2){
			$checked[] = "FILE 2: Your artwork has the correct size for $cap_size.";
			$checked[] = "FILE 2: Your artwork includes 2mm bleeds.";
			}else{
			$errors['.Wrong size'] = "The FILE 2 is not $cap_size. The size for $cap_size is: $suggested_size.";
		
			}
			
			
		}

	  //processing non PDF files
	} else {
		
		$file1_width = $_SESSION['img_width'];
		$file1_height = $_SESSION['img_height'];
		if($file1_width > $file1_height){
			$orientation = "Landscape";
		}
		if(isset($_SESSION['img_colour'])){
			$file1_colour = $_SESSION['img_colour'];
		}
		$results = sizecheck($file1_width, $file1_height, $size);
		
		if($results[0] == 1 && $results[1] == 300){
			$issues['_No bleeds'] = "<span class=\"note\">FILE '$file1_name': Lack of bleeds:</span>  Your artwork is at risk and might get cut wrongly. Add 2mm to each side of your artwork. Click here to find out how or get technical assistance.";
			$checked[] = "<span class=\"note\">FILE '$file1_name':</span>  Your artwork has the correct size for $cap_size.";
			$checked[] = "<span class=\"note\">FILE '$file1_name':</span>  The file has the correct resolution of 300DPI.";
		}elseif($results[0] == 1 && $results[1] == 72){
			$issues['_No bleeds'] = "<span class=\"note\">FILE '$file1_name': Lack of bleeds:</span>  Your artwork is at risk and might get cut wrongly. Add 2mm to each side of your artwork. Click here to find out how or get technical assistance.";
			$issues['_Low res'] = "<span class=\"note\">FILE '$file1_name': Low resolution:</span>  Your artwork has the resolution of 72DPI. The optimal resolution for printing is 300DPI.";
			$checked[] = "<span class=\"note\">FILE '$file1_name':</span>  Your artwork has the correct size for $cap_size.";
		}elseif($results[0] == 2 && $results[1] == 300){
			$checked[] = "<span class=\"note\">FILE '$file1_name':</span>  2mm bleed detected.";
			$checked[] = "<span class=\"note\">FILE '$file1_name':</span>  Your artwork has the correct size for $cap_size.";
			$checked[] = "<span class=\"note\">FILE '$file1_name':</span>  The file has the correct resolution of 300DPI.";
		}elseif($results[0] == 2 && $results[1] == 72){
			$checked[] = "<span class=\"note\">FILE '$file1_name':</span>  2mm bleed detected.";
			$checked[] = "<span class=\"note\">FILE '$file1_name':</span>  Your artwork has the correct size for $cap_size.";
			$issues['_Low res'] = "<span class=\"note\">FILE '$file1_name': Low resolution:</span>  Your artwork has the resolution of 72DPI. The optimal resolution for printing is 300DPI.";
		}elseif(count($results) < 2){
			$errors['_Wrong size'] = "<span class=\"note\">FILE '$file1_name'</span>  is not $cap_size. The size for $cap_size is: $suggested_size.";
		}
		$checked[] = "<span class=\"note\">FILE '$file1_name': Orientation:</span>  $orientation";
		if($path == "png"){
			$issues['_PNG extension'] = "<span class=\"note\">FILE '$file1_name': PNG extension:</span> Your file is in PNG format which is optimal for web and monitors. Export your file as PDF or JPEG for the best results.";
		}else{
			if($file1_colour == 3){
				$issues['_RGB colour profile'] = "<span class=\"note\">FILE '$file1_name': RGB:</span> The colour profile of your file is RGB, this might result in colour alteration during printing. Export your file with a CMYK colour profile, to see how click here or contact techincal assistance.";
			}elseif($file1_colour == 4){
				$checked[] = "<span class=\"note\">FILE '$file1_name':</span> Your file has the correct CMYK colour profile.";
			}else{
				$errors['_Colour profile issue'] = "<span class=\"note\">FILE '$file1_name':</span> cannot detect colour profile.";
			}	
		}
				
		
		
		//checking for second file
		if($file_count == 2){
			$path2 = $_SESSION['file2_extension'];
			$file2_name = $_SESSION['file2_name'];
			$file2_width = $_SESSION['img_width2'];
			$file2_height = $_SESSION['img_height2'];
			if($file2_width > $file2_height){
			$orientation2 = "Landscape";
			}else{
			$orientation2 = "Portrait";
			}
			if(isset($_SESSION['img_colour2'])){
			$file2_colour = $_SESSION['img_colour2'];
			}
			$results2 = sizecheck($file2_width, $file2_height, $size);
			if($results2[0] == 1 && $results2[1] == 300){
				$issues['.No bleeds'] = "<span class=\"note\">FILE '$file2_name': Lack of bleeds:</span> Your artwork is at risk and might get cut wrongly. Add 2mm to each side of your artwork. Click here to find out how or get technical assistance.";
				$checked[] = "<span class=\"note\">FILE '$file2_name': Your artwork has the correct size for $cap_size.";
				$checked[] = "<span class=\"note\">FILE '$file2_name': The file has the correct resolution of 300DPI.";
			}elseif($results2[0] == 1 && $results2[1] == 72){
				$issues['.No bleeds'] = "<span class=\"note\">FILE '$file2_name': Lack of bleeds:</span>  Your artwork is at risk and might get cut wrongly. Add 2mm to each side of your artwork. Click here to find out how or get technical assistance.";
				$issues['.Low res'] = "<span class=\"note\">FILE '$file2_name':</span>  Low resolution: Your artwork has the resolution of 72DPI. The optimal resolution for printing is 300DPI.";
				$checked[] = "<span class=\"note\">FILE '$file2_name':</span>  Your artwork has the correct size for $cap_size.";
			}elseif($results2[0] == 2 && $results2[1] == 300){
				$checked[] = "<span class=\"note\">FILE '$file2_name':</span>  2mm bleed detected.";
				$checked[] = "<span class=\"note\">FILE '$file2_name':</span>  Your artwork has the correct size for $cap_size.";
				$checked[] = "<span class=\"note\">FILE '$file2_name':</span>  The file has the correct resolution of 300DPI.";
			}elseif($results2[0] == 2 && $results2[1] == 72){
				$checked[] = "<span class=\"note\">FILE '$file2_name':</span>  2mm bleed detected.";
				$checked[] = "<span class=\"note\">FILE '$file2_name':</span>  Your artwork has the correct size for $cap_size.";
				$issues['.Low res'] = "<span class=\"note\">FILE '$file2_name':</span>  Low resolution: Your artwork has the resolution of 72DPI. The optimal resolution for printing is 300DPI.";
			}elseif(count($results2) < 2){
				$errors['.Wrong size'] = "<span class=\"note\">FILE '$file2_name'</span>  is not $cap_size. The size for $cap_size is: $suggested_size.";
			}
			$checked[] = "<span class=\"note\">FILE '$file2_name': Orientation:</span>  $orientation2";
			if($path2 == "png"){
			$issues['.png extension'] = "<span class=\"note\">FILE '$file2_name': PNG extension:</span>  Your file is in PNG format which is optimal for web and monitors. Export your file as PDF or JPEG for the best results.";
			}else{
			if($file2_colour == 3){
				$issues['.RGB colour profile'] = "<span class=\"note\">FILE '$file2_name': RGB:</span>  The colour profile of your file is RGB, this might result in colour alteration during printing. Export your file with a CMYK colour profile, to see how click here or contact techincal assistance.";
			}elseif($file2_colour == 4){
				$checked[] = "<span class=\"note\">FILE '$file2_name':</span>  Your file has the correct CMYK colour profile.";
			}else{
				$errors['.Colour profile issue'] = "<span class=\"note\">FILE '$file2_name':</span>  cannot detect colour profile.";
			}
			}
				
		}
		
		//
		
		
	}
	
	
}		
	
 else {
	echo '<h1 class="access">ACCESS DENIED</h1>';
}



?>



<main>
	
	<section class="form_container">
	<div class="section_header"><h1 class="main_title">PrintBritannia File-proofer</h1></div>
	<p class="introduction">Avoid printing errors by checking your files before placing a printing order. Get instant results and solutions for any problem encountered. If you're unable to fix you file, request assistance from the technical team.</p>
	
	<div class="preview">
	
	<section>
	<?php
	if(isset($_SESSION['flag'])){
		echo "<h3>File preview</h3>
		<p><span class=\"prev\">Title:</span> $file1_name</p>
		<p><span class=\"prev\">Dimensions:</span> $file1_width x $file1_height pixels</p>";
		
		$flag = $_SESSION['flag'];
		if($flag == 1){
			$filepath = $_SESSION['filepath'];
			echo "<img src=".$filepath."  />";
		}elseif($flag == 0){
			echo "Error displaying file";
		}
		unset($_SESSION['flag']);
	}
	?>
	</section>
	<section>
	<?php
	if(isset($_SESSION['flag2'])){
		echo "<h3><br></h3>
		<p><span class=\"prev\">Title:</span> $file2_name</p>
		<p><span class=\"prev\">Dimensions:</span> $file2_width x $file2_height pixels</p>";
		$flag2 = $_SESSION['flag2'];
		if($flag2 == 1){
			$filepath2 = $_SESSION['filepath2'];
			echo "<img src=".$filepath2." />";
		}elseif($flag == 0){
			echo "Error displaying file";
		}
		unset($_SESSION['flag2']);
	}
	?>
	</section>
	</div>
	<?php 
	
	if(count($errors) > 0){
		$_SESSION['errors'] = $errors;
		echo "<div class=\"errors\" id=\"results\">";
		
	
	foreach($errors as $error) {
	echo "<p><img class=\"icon\" src=\"icons/error.png\" alt=\"Error\" height=\"15\" width=\"15\">$error</p>";
	}
	echo "</div>";
	}
	?>
	
	
	<?php 
	if(count($issues) > 0){
		$_SESSION['issues'] = $issues;
		echo "<div class=\"issues\" id=\"results\">";
		
	
	foreach($issues as $issue) {
	echo "<p><img class=\"icon\" src=\"icons/warning.png\" alt=\"Error\" height=\"15\" width=\"15\">$issue</p>";
	}
		echo "</div>";
	}
	?>
	
	
	
	<?php 
	if(count($checked) > 0){
		echo "<div class=\"checks\" id=\"results\">";
		
	
	foreach($checked as $check) {
	echo "<p><img class=\"icon\" src=\"icons/check.png\" alt=\"Error\" height=\"15\" width=\"15\">$check</p>";
	}
	echo "</div>";
	}
	?>
	
	
	
	
	</section>
	<section class="buttons"><a href="index.php">HOME</a><a href="contact.php">CONTACT SUPPORT</a></section>
</main>

<?php
require 'includes/footer.include.php';
?>
