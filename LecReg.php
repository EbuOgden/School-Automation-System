<!DOCTYPE html>
<html>

<head>
	<title>Exam Schedule</title>
    <meta charset="utf-8">
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

	<div class="login-form">
		<h1>Lecturer Register </h1>
		<form method="post">
			<li>
				<input type="password" value="Password" name="LecRegPasswd" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}"><a href="" class=" icon lock"></a>
			</li>
			<li>
				<input type="password" value="Password" name="LecRegPasswdRe" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}"><a href="" class=" icon lock"></a>
			</li>

            <div class ="change-panel">
			<input type="submit" name="lecturerRegister" value="Register" ><a href="" class=" icon arrow"></a>
			</div>
		</form>
	</div>
	<!--//End-login-form-->

	<?php
	session_start();

	if(isset($_POST['lecturerRegister'])){
		lecturePassword();
	}

	function lecturePassword(){
		$LecRegPasswd = $_POST['LecRegPasswd'];
		$LecRegPasswdRe = $_POST['LecRegPasswdRe'];
		$LecturerID = $_SESSION['LecturerIDFrom'];

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbName = "examcontrolsystem";

		$LecRegPasswdRe = md5($LecRegPasswdRe);

		$conn = mysqli_connect($servername, $username, $password, $dbName);

		$InsertLecturerPasswd = "UPDATE lecturer SET Pass='$LecRegPasswdRe' WHERE ID = $LecturerID";

		if((strcmp($LecRegPasswd, "Password") == 0) || (strcmp($LecRegPasswdRe, "Password") == 0)){
			echo "<script type='text/javascript'>alert('Please Fill All Boxes');</script>";
			exit;
		}

		if(mysqli_query($conn, $InsertLecturerPasswd)){
			$_SESSION['LecturerID'] = $LecturerID;
			header("LOCATION: ../LecPanel.php");
		}

		mysqli_close($conn);

	}

	?>
</body>
</html>
