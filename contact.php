<?php

require 'includes/header.include.php';
$self = htmlentities($_SERVER['PHP_SELF']);
if(isset($_POST['sendm'])){
	$er_list = $_POST['er_list'];
	$uemail = $_POST['uemail'];
	$packet = 'List of errors: '.$er_list.' User e-mail: '.$uemail;
	
	if(isset($_POST['desc'])){
		$packet .= '   '.$_POST['desc'];
	}
	
	// use wordwrap() if lines are longer than 70 characters
	$msg = wordwrap($packet,200);
	$address = "kory.graphic@gmail.com";
	$subject = "Customer message";
	// send email
	mail($address,$subject,$msg);
	unset($_SESSION['errors']);
	unset($_SESSION['issues']);
	$_SESSION['sent'] = $_POST['sendm'];
	header("Location: ./confirmation.php");
	
};
	

?>





<main>
	<section class="form_container">
	<div class="section_header"><h1 class="main_title">PrintBritannia File-proofer</h1></div>
	<p class="introduction">Request assistance from our technical team by sending a message including the issues concerning your files. Add a short description if needed.</p>
	
	<form id="contactform" action=<?php echo $self; ?> method="POST">
	
						
	
						
	<label for="er_list">List of errors gathered</label>
	<textarea id="er_list" name="er_list" class="er_list" rows="7" cols="50" placeholder="No errors found" readonly ><?php			
	if(isset($_SESSION['issues'])){
		$file1 = $_SESSION['file1_name'];
		echo "File name: $file1 \n";
		foreach($_SESSION['issues'] as $key => $value){
		
		if($key[0] == "_"){
			$key[0] = " ";
			echo "$key \n";
			}
		}
	}
	
	if(isset($_SESSION['errors'])){
		
		
		foreach($_SESSION['errors'] as $key => $value){
		
		if($key[0] == "_"){
			$key[0] = " ";
			echo "$key \n";
			}
		}
	}
	
	if(isset($_SESSION['file2_name'])){
		if(isset($_SESSION['issues'])){
			$file2 = $_SESSION['file2_name'];
			echo "File name: $file2 \n";
			foreach($_SESSION['issues'] as $key => $value){
		
				if($key[0] == "."){
					$key[0] = " ";
					echo "$key \n";
				}
			}
		unset($_SESSION['file2_name']);
		}
	}
	
	if(isset($_SESSION['errors'])){
		
		
		foreach($_SESSION['errors'] as $key => $value){
		
		if($key[0] == "."){
			$key[0] = " ";
			echo "$key \n";
			}
		}
	}
	
	
	
	?>
	</textarea >
	<br>
	
	<label for="uemail">Your e-mail address</label>
	<input type="email" id="uemail" name="uemail" required>
	
	<br>
	<label for="desc">Additional description</label>
	<textarea id="desc" name="desc" rows="7" cols="50"></textarea>
	
	<input type="submit"  name="sendm" value="SEND MESSAGE">
	<section class="button"><a href="index.php">HOME</a></section>
	</section>
</form>
	
	
	
	
	
</main>

<?php
require 'includes/footer.include.php';
?>
