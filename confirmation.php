<?php

require 'includes/header.include.php';

?>
<main>
	
	<section class="form_container">
	<div class="section_header"><h1 class="main_title">PrintBritannia File-proofer</h1></div>
	<p class="introduction"></p>
	<div class="conf">
	<?php 
		if(isset($_SESSION['sent'])){
			echo "<h1 class=\"confirm\">Your message has been sent!<h1><br>";
			echo "<p><span class=\"thanks\">Thank you for contacting us, we'll get back to you by e-mail as soon as we can.</span></p>";
		}else{
			echo "<h1>Access denied</h1>";
		}
	?>
	</div>
	<section class="buttons"><a href="index.php">HOME</a><a href="#">Back to website</a></section>
	
	</section>
</main>

<?php
require 'includes/footer.include.php';
?>