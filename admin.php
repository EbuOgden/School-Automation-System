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
            <h1>Admin Sign In</h1>
            <form method="post">
                <li>
                    <input type="text" class="text" name="adminID" value="User Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'User Name';}" ><a href="#" class=" icon user"></a>
                        </li>
                <li>
                    <input type="password" value="Password" name="pass" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Password';}"><a href="#" class=" icon lock"></a>
                        </li>

                <div class="change-panel">
                    <input type="submit" name="enterAdmin" value="Sign In" ><a href="#" class=" icon arrow"></a>
                    <input type="button" onclick="location.href='index.php'" value="Back">
                </div>
            </form>
        </div>

		<?php

	if(isset($_POST['enterAdmin'])){
		loginAdmin();
	}

	function loginAdmin(){
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbName = "examcontrolsystem";

		$adminID = $_POST['adminID'];
		$adminPassword = $_POST['pass'];

		$adminPassword = md5($adminPassword);

		$conn = mysqli_connect($servername, $username, $password, $dbName);

		$adminCheckSql = "SELECT ID, Pass FROM admin";
		$adminCheck = mysqli_query($conn, $adminCheckSql);
		$admin = mysqli_fetch_assoc($adminCheck);

		if((strcmp($admin['ID'], $adminID) == 0) && (strcmp($admin['Pass'], $adminPassword) == 0)){
			header("Location: ../adminPanel.php");
		}
		else
			echo "<script type='text/javascript'>alert('Wrong ID or Password');</script>";

		mysqli_close($conn);
	}
	?>
    </body>
</html>
