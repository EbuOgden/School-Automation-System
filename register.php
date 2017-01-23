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
		<h1>Student Register </h1>
		<form method="post">
            <li>
				<input type="text" class="text" name="StdRegId" value="User Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'User Name';}" ><a href="" class=" icon user"></a>
			</li>
			<li>
				<input type="password" value="Password" name="StdRegPasswd" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}"><a href="" class=" icon lock"></a>
			</li>
			<li>
				<input type="password" value="Password" name="StdRegPasswdRe" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}"><a href="" class=" icon lock"></a>
			</li>
			<li>
				<input type="text" class="text" name="StdRegEmail" value="E-Mail" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" ><a href="" class=" icon user"></a>
			</li>

            <div class ="change-panel">
			<input type="submit" name="Register" value="Register" ><a href="" class=" icon arrow"></a>
			<input type="button" onclick="location.href='index.php'" value="Back">
			</div>
		</form>
	</div>
	<!--//End-login-form-->
	<?php
	if(isset($_POST['Register'])){
			Register();
	}
	function Register(){
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbName = "examcontrolsystem";

		$studentRegId = $_POST['StdRegId'];
		$studentRegPassword = $_POST['StdRegPasswd'];
		$studentRegPasswordRe = $_POST['StdRegPasswdRe'];
		$studentRegEmail = $_POST['StdRegEmail'];

		if (!filter_var($studentRegEmail, FILTER_VALIDATE_EMAIL)) {
			echo "<script type='text/javascript'>alert('Please Enter Valid E-Mail');</script>";
			exit();
		}

		$studentRegId = stripslashes($studentRegId);//for sql injection
		$studentRegPasswordRe = stripslashes($studentRegPasswordRe);//for sql injection

		$studentRegPassword = md5($studentRegPassword);
		$studentRegPasswordRe = md5($studentRegPasswordRe);

		$conn = mysqli_connect($servername, $username, $password, $dbName);// db ye baglanti

		$checkStudentIdSql = "SELECT ID FROM student WHERE ID =$studentRegId";//db den ogrenci id cekme
		$StudentDbIdSql = mysqli_query($conn, $checkStudentIdSql);//id icin sql komut calistirma
		$StudentDbId = mysqli_fetch_assoc($StudentDbIdSql);//cekilen id yi StudentDbId ye atama

		$StudentRegister = "INSERT INTO student(ID, Pass, Email) VALUES ($studentRegId, '$studentRegPasswordRe', '$studentRegEmail')";

		if(strcmp($studentRegId, $StudentDbId['ID']) == 0){
			echo "<script type'text/javascript'>alert('$studentRegId is already using');</script>";
		}else if(strcmp($studentRegPassword, $studentRegPasswordRe) != 0){
			echo "<script type='text/javascript'>alert('Please Check Password');</script>";
		}
		else if(empty($studentRegId) || empty($studentRegPassword) || empty($studentRegPasswordRe) || empty($studentRegEmail)){
			echo "<script type='text/javascript'>alert('Please Fill All Boxes');</script>";
			exit;
		}
		else {
			mysqli_query($conn, $StudentRegister);
			header("LOCATION: ../index.php");
		}
		mysqli_close($conn);


	}

	?>
</body>
</html>
