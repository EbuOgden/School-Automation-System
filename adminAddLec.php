<?php
error_reporting(E_ALL ^ E_NOTICE);
ini_set('error_reporting', E_ALL ^ E_NOTICE);
?>
<!DOCTYPE html>
<html>

<head>
	<title>Exam Schedule</title>
    <meta charset="utf-8">
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
	<div class="add-lecturer">
	<form method="post">
    	<h1> Adding a Lecturer </h1>
            <select class="style-select" name="titleSelect" style="width:100px">
			<?php
			$servername = "localhost";
			$userId = "root";
			$password = "";
			$dbName = "examcontrolsystem";

			$conn = mysqli_connect($servername, $userId, $password, $dbName);

			$AddTitleFromSql = "SELECT TitleName FROM title";
			$AddTitleFrom = mysqli_query($conn, $AddTitleFromSql);

			while($AddTitle = mysqli_fetch_array($AddTitleFrom)){
				echo '<option>' .$AddTitle['TitleName'].' </option>';
			}

			mysqli_close($conn);
			?>
			<input type="text" name="lectName" align="center" class="text" value="Lecturer Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Lecturer Name';}" >
			</select>
            <div class="change-panel">
            <input type="submit" name="addLecturer" value="Add Lecturer">
            <input type="button" onClick="location.href='adminPanel.php'" value="Back">
            </div>
		</form>
	</div>
		<?php
		if(isset($_POST['addLecturer']))
			lectureAdd();

		function lectureAdd(){
			$selectedTitle = $_POST['titleSelect'];
			$lecturerName = $_POST['lectName'];

			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbName = "examcontrolsystem";

			$conn = mysqli_connect($servername, $username, $password, $dbName);

			$TitleIdFromSql = "SELECT ID FROM title WHERE TitleName = '$selectedTitle'";
			$TitleIdFrom = mysqli_query($conn, $TitleIdFromSql);
			$TitleId = mysqli_fetch_assoc($TitleIdFrom);
			$Title = $TitleId['ID'];

			$lecturerNameIdFor = str_replace(' ', '', $lecturerName);
			$lecturerNameId = strtolower($lecturerNameIdFor);


			$InsertLecturer = "INSERT INTO lecturer(Username, Name, Pass, TitleId) VALUES ('$lecturerNameId', '$lecturerName', '1234', $Title)";
			if(mysqli_query($conn, $InsertLecturer)){
				header("LOCATION: ../adminPanel.php");
			}

			mysqli_close($conn);
		}
		?>
</body>
</html>
