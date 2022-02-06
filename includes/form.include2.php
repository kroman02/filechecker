<?php 
$self = htmlentities($_SERVER['PHP_SELF']);
include 'get_pdf_dimensions.php';
//Variables
$errors = array();
$accepted_sizes = array("a6","a5","a4","Business Card");
$accepted_ext = array("jpg", "png", "tif", "pdf");

$testcount = 0;




//processing request
if(isset($_POST['submit'])){
	
	//check for required field SIZES
	if(!isset($_POST['size'])){
		$errors['No size selected'] = "Please select the size of your file.";
	}elseif(!in_array($_POST['size'], $accepted_sizes)){
		$errors['Invalid size'] = "Accepted sizes are A4, A5, A6, Business Card.";
	} else {
		$_SESSION['selected_size'] = $_POST['size'];
	}
	//check for required field FILE
	if(empty($_FILES['inputfile']['tmp_name'][0])){
		$errors['No file selected'] = "Please select a file to upload.";
	}elseif(count($_FILES['inputfile']['tmp_name']) > 2){
		$errors['File upload limit:'] = "You can upload maximum 2 files at a time.";
	}elseif($_FILES['inputfile']['size'][0] > 40000000){
		$errors['The file is too big'] = "Maxumim size allowed 40MB";
	}else{
		$path = strtolower(pathinfo($_FILES['inputfile']['name'][0], PATHINFO_EXTENSION));
		if(!in_array($path, $accepted_ext)){
			$errors['Invalid extension'] = "Extensions allowed: JPG, PNG, TIFF, PDF.";
		}else{
			
			$_SESSION['file1_extension'] = $path;
			$_SESSION['file1_name'] = $_FILES['inputfile']['name'][0];
			/*
			//FILE UPLOAD/*
			$filepath = "images/uploads" . $_FILES['inputfile']['name'][0];
			if(move_uploaded_file($_FILES['inputfile']['tmp_name'][0], $filepath)) {
			$flag = 1;
			$_SESSION['filepath'] = "images/uploads" . $_FILES['inputfile']['name'][0];
			}else{
			$flag = 0;
			}
			$_SESSION['flag'] = $flag;
			*/
			//END FILE UPLOAD
		}
		
	}
	
	//checking for second file
	if(count($_FILES['inputfile']['tmp_name']) == 2){
		if($_FILES['inputfile']['size'][1] > 40000000){
			$errors['The second file is too big'] = "Maximum size allowed 40MB";
		}else{
			$path2 = strtolower(pathinfo($_FILES['inputfile']['name'][1], PATHINFO_EXTENSION));
			if(!in_array($path2, $accepted_ext)){
				$errors['Invalid extension'] = "Extensions allowed: JPG, PNG, TIF, PDF.";
			}else{
				$_SESSION['file2_extension'] = $path2;
				$_SESSION['file2_name'] = $_FILES['inputfile']['name'][1];
				if(($path == "pdf" && $path2 != "pdf") || ($path2 == "pdf" && $path != "pdf")){
					$errors['Extension error'] = "Both files must be .PDF, or be in one combined PDF document.";
				}
			}
		}
	}
	
	
	
	
	//if no errors found, retrieve info & redirect user to results
	if(count($errors) == 0){
		
		//IF FILE IS PDF
		if($path == "pdf"){
			$box = "MediaBox";
			$pdfSizes = get_pdf_dimensions($_FILES['inputfile']['tmp_name'][0], $box);
			$_SESSION['pdf_width'] = $pdfSizes['width'];
			$_SESSION['pdf_height'] = $pdfSizes['height'];
			if(count($_FILES['inputfile']['tmp_name']) == 2){
				$pdfSizes2 = get_pdf_dimensions($_FILES['inputfile']['tmp_name'][1], $box);
				$_SESSION['pdf_width2'] = $pdfSizes2['width'];
				$_SESSION['pdf_height2'] = $pdfSizes2['height']; 
			}
		
		//IF FILE IS NOT PDF
		} else {
			
			
			$img_info = getimagesize($_FILES['inputfile']['tmp_name'][0]);
			$_SESSION['img_width'] = $img_info[0];
			$_SESSION['img_height'] = $img_info[1];
			if($path != "png" && $path != "tif"){
				$_SESSION['img_colour'] = $img_info['channels'];
			};
			//FILE 1 UPLOAD/*
			$filepath = "images/uploads" . $_FILES['inputfile']['name'][0];
			if(move_uploaded_file($_FILES['inputfile']['tmp_name'][0], $filepath)) {
			$flag = 1;
			$_SESSION['filepath'] = "images/uploads" . $_FILES['inputfile']['name'][0];
			}else{
			$flag = 0;
			}
			$_SESSION['flag'] = $flag;
			//END FILE UPLOAD
			
			if(count($_FILES['inputfile']['tmp_name']) == 2){
				$img_info2 = getimagesize($_FILES['inputfile']['tmp_name'][1]);
				$_SESSION['img_width2'] = $img_info2[0];
				$_SESSION['img_height2'] = $img_info2[1];
			if($path2 != "png" && $path2 != "tif"){
				$_SESSION['img_colour2'] = $img_info2['channels'];
			}
			//FILE 2 UPLOAD/*
			$filepath2 = "images/uploads" . $_FILES['inputfile']['name'][1];
			if(move_uploaded_file($_FILES['inputfile']['tmp_name'][1], $filepath2)) {
			$flag2 = 1;
			$_SESSION['filepath2'] = "images/uploads" . $_FILES['inputfile']['name'][1];
			}else{
			$flag2 = 0;
			}
				if(count($_FILES['inputfile']['tmp_name']) == 2){
				$_SESSION['flag2'] = $flag2;
				}
			//END FILE UPLOAD
			}
		}
	
	
		
		$_SESSION['submitted'] = $_POST['submit'];
		$_SESSION['file_count'] = count($_FILES['inputfile']['tmp_name']);
			
		header("Location: ./results.php");
	
	//closing submission
	}






}


?>


<div class="error-field">
<br>
<?php	
foreach($errors as $key => $error) {
echo "<p><span class=\"error\">$key: $error</span></p><br>";
}
?>

				
</div>

<!-- form that allows the user to upload a file for printing -->
<form id="mainform" action=<?php echo $self; ?> method="POST" enctype="multipart/form-data">
						
	
						
	<h2 class="steps">1. Select the size of your file:</h2><br>
	<input id="rb" type="radio" name="size" value="a6">
	 <label for="rb">A6</label><br>
	<input id="rb2" type="radio" name="size" value="a5">
	 <label for="rb2">A5</label><br>
	<input id="rb3" type="radio" name="size" value="a4">
	 <label for="rb3">A4</label><br>
	<input id="rb4" type="radio" name="size" value="Business Card">
	<label for="rb4">UK Business Card</label><br>
	<h2 class="steps">2. Select your file(s): </h2><p><span class="max">Select more files by holding CTRL | Maximum 2 files | Maximum size 40MB</span></p><br>
					
	
	<input type="file" name="inputfile[]" id="upload" multiple><br>
	
						
						
	<input type="submit"  name="submit" value="UPLOAD IMAGE">
	
</form>
				

			