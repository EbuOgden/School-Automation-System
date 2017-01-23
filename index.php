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
		<h1>Sign In</h1>
		<h2><a href="register.php">Register</a></h2>
		<form method="post">
            <li>
				<input type="text" class="text" name="StdLoginId" value="User Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = '';}" ><a href="#" class=" icon user"></a>
			</li>
			<li>
				<input type="password" value="Password" name="StdLoginPasswd" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}"><a href="#" class=" icon lock"></a>
			</li>

            <div class ="change-panel">
                <input type="button" onclick="location.href='admin.php'" value="Admin">

				<input type="submit" name="submitEnter" value="Sign In" ><a href="" class=" icon arrow"></a>
			</div>
		</form>
	</div>
	<!--//End-login-form-->
	<?php
	if(isset($_POST['submitEnter'])){
			@checkLoginId();
	}
	function checkLoginId(){
		session_start();

		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbName = "examcontrolsystem";

		$studentLoginId = $_POST['StdLoginId'];
		$studentLoginPassword = $_POST['StdLoginPasswd'];

		$studentLoginId = stripslashes($studentLoginId);
		$studentLoginPassword = stripslashes($studentLoginPassword);

		$conn = mysqli_connect($servername, $username, $password, $dbName);// db ye baglanti

		$checkLecturerUsernameSql = "SELECT Username FROM lecturer WHERE Username = '$studentLoginId'";
		$checkLecturerUsername = mysqli_query($conn, $checkLecturerUsernameSql);
		$LecturerUsername = mysqli_fetch_assoc($checkLecturerUsername);

		$checkLecturerPasswordSql = "SELECT Pass FROM lecturer WHERE Username = '$studentLoginId'";
		$checkLecturerPassword = mysqli_query($conn, $checkLecturerPasswordSql);
		$LecturerPassword = mysqli_fetch_assoc($checkLecturerPassword);

		$checkLecturerIDSql = "SELECT ID FROM lecturer WHERE Username = '$studentLoginId'";
		$checkLecturerID = mysqli_query($conn, $checkLecturerIDSql);
		$LecturerID = mysqli_fetch_assoc($checkLecturerID);

		if((strlen($LecturerUsername['Username']) != 0))			$lecturerIdLengthControl = TRUE;

		if((strlen($LecturerPassword['Pass']) != 0))			$lecturerPassLengthControl = TRUE;

		if((strcmp($studentLoginId, "User Name") == 0) || (strcmp($studentLoginPassword, "Password") == 0)){
			echo "<script type='text/javascript'>alert('Please Fill All Boxes');</script>";
			exit;
		}

		if((strcmp($studentLoginId, $LecturerUsername['Username'] == 0)) && ($studentLoginPassword ===  $LecturerPassword['Pass']) && ($LecturerPassword['Pass'] === "1234") && ($lecturerIdLengthControl == TRUE) && ($lecturerPassLengthControl == TRUE)){
			$_SESSION['LecturerIDFrom'] = $LecturerID['ID'];
			header("LOCATION: ../LecReg.php");
		}

		$studentLoginPassword = md5($studentLoginPassword);

		if((strcmp($studentLoginId, $LecturerUsername['Username'] == 0)) && ($studentLoginPassword ===  $LecturerPassword['Pass']) && ($lecturerIdLengthControl == TRUE) && ($lecturerPassLengthControl == TRUE)){
			$_SESSION['LecturerIDFrom'] = $LecturerID['ID'];
			header("LOCATION: ../LecPanel.php");
		}

		$checkStudentIdSql = "SELECT ID FROM student WHERE ID = $studentLoginId";
		$StudentDbIdSql = mysqli_query($conn, $checkStudentIdSql);
		$StudentDbId = mysqli_fetch_assoc($StudentDbIdSql);

		$checkStudentPasswdSql = "SELECT Pass FROM student WHERE ID ='$studentLoginId'";
		$StudentDbPasswordSql = mysqli_query($conn, $checkStudentPasswdSql);
		$StudentDbPassword = mysqli_fetch_assoc($StudentDbPasswordSql);

		if((strcmp($StudentDbPassword['Pass'], $studentLoginPassword)) == 0  && (strcmp($StudentDbId['ID'],$studentLoginId) == 0)){
				$_SESSION['studentLoginId'] = $studentLoginId;
				header("LOCATION: ../stdMenu.php");
		}
		else{
			echo "<script type='text/javascript'>alert('Wrong ID or Password');</script>";
			exit;
		}
		mysqli_close($conn);

	}

	?>
</body>
</html>
