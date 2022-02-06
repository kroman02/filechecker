<?php 
$self = htmlentities($_SERVER['PHP_SELF']);
?>
<html>
<head>
<title>PHP File Upload example</title>
</head>
<body>

<form action=<?php echo $self; ?> enctype="multipart/form-data" method="post">
Select image :
<input type="file" name="file[]" multiple><br/>
<input type="text" name="message">
<input type="text" name="sub" value="Put subject">
<input type="email" name="mail">
<input type="submit" value="Upload" name="Submit1"> <br/>


</form>
<?php
if(isset($_POST['Submit1']))
{ 
$_SESSION['banga'] = $_FILES['file']['name'][0];
$filepath = "includes/uploads/" . $_FILES['file']['name'][0];

if(move_uploaded_file($_FILES['file']['tmp_name'][0], $filepath)) 
{

echo "<img src=".$filepath." height=200 width=300 />";
} 
else 
{
echo "Error !!";
}
}

if(isset($_POST['Submit1'])){
$mex = $_POST['message'];
$add = $_POST['mail'];
$sub = $_POST['sub'];

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($mex,70);

// send email
mail($add,$sub,$msg);
};

?>

</body>
</html>