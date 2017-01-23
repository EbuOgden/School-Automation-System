<!DOCTYPE html>
<html>

<head>
	<title>Exam Schedule</title>
    <meta charset="utf-8">
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="logout">
		<input type="button" onclick="location.href='index.php'" value="Log Out" width="%45">
	</div>

	<div class="lecturer-form">
		<h1 style="text-align:left; color: #fff; font-size:1.8em; font-weight:500; font-family :
		'Sansation Regular', sans-serif; position:absolute; top:7%; left:35%;
		margin:34px 0;">Lecturer Menu</h1>
		<form method="POST">
			<input type="submit" name="addExam" value="Add">
			<input type="submit" name="editExam" value="Edit">
			<input type="submit" name="deleteExam" value="Delete">
			<input type="submit" name="mailSend" value="Mail">
		</form>
    </div>
	<!--//End-login-form-->
	<?php
	if(isset($_POST['addExam']))
		header("LOCATION: ../addExam.php");

	if(isset($_POST['editExam']))
		header("LOCATION: ../editExam.php");

	if(isset($_POST['deleteExam']))
		header("LOCATION: ../deleteExam.php");

	if(isset($_POST['mailSend']))
		header("LOCATION: ../mailSend.php");
	?>
</body>
</html>
