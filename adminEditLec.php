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
    	<h1> Editing a Lecturer </h1>
		<form method="post">
            <select class="style-select" name="titleSelect">
				<?php
				$servername = "localhost";
				$userId = "root";
				$password = "";
				$dbName = "examcontrolsystem";

				$conn = mysqli_connect($servername, $userId, $password, $dbName);
				
				$lecturersFromSql = "SELECT lecturer.Name, title.TitleName FROM lecturer INNER JOIN title ON lecturer.TitleID = title.ID";
				$lecturersFrom = mysqli_query($conn, $lecturersFromSql);

				while($lecturers = mysqli_fetch_array($lecturersFrom)){
					echo '<option>' .$lecturers['TitleName'].' '.$lecturers['Name'].' </option>';
				}

				mysqli_close($conn);
				?>
			</select>
			<select class="style" style="width:150px" name="titleSelectList">
				<?php
				$servername = "localhost";
				$userId = "root";
				$password = "";
				$dbName = "examcontrolsystem";

				$conn = mysqli_connect($servername, $userId, $password, $dbName);

				$titlesFromSql = "SELECT TitleName FROM title";
				$titlesFrom = mysqli_query($conn, $titlesFromSql);

				while($titles = mysqli_fetch_array($titlesFrom)){
					echo '<option>' .$titles['TitleName'].' </option>';
				}

				mysqli_close($conn);

				?>
			</select>
			<input type="text" class="text" name="lecturerEnter" value="Lecturer Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Lecturer Name';}" >
            <div class="change-panel">
                <input type="submit" name="editLecturer" value="Edit Lecturer">
                <input type="button" onClick="location.href='adminPanel.php'" value="Back">
            </div>
		</form>
		<?php

		if(isset($_POST['editLecturer']))
			editLecturer();

		function editLecturer(){
			$lecturernamelength = strlen($_POST['titleSelect']);
			$lecturerTitle = substr($_POST['titleSelect'], 0, 6);
			$lecturerNewName = $_POST['lecturerEnter'];
			$lecturerNewTitleName = $_POST['titleSelectList'];

			if(strcmp($lecturerTitle, "Doctor") == 0){
				$lecturerName = substr($_POST['titleSelect'], 7, $lecturernamelength);
			}
			else if(strcmp($lecturerTitle, "Profes") == 0){
				$lecturerName = substr($_POST['titleSelect'], 10, $lecturernamelength);
			}
			else if(strcmp($lecturerTitle, "Assist") == 0){
				$lecturerName = substr($_POST['titleSelect'], 20, $lecturernamelength);
			}

			$servername = "localhost";
			$userId = "root";
			$password = "";
			$dbName = "examcontrolsystem";

			$conn = mysqli_connect($servername, $userId, $password, $dbName);

			$LecturerIdFromSql = "SELECT ID FROM lecturer WHERE lecturer.Name = '$lecturerName'";//select lecturer id sql
			$LecturerIdFromSq = mysqli_query($conn, $LecturerIdFromSql);// sql query
			$LecturerIdFrom = mysqli_fetch_assoc($LecturerIdFromSq);// return value
			$LecturerId = $LecturerIdFrom['ID'];// assign value

			$LecturerNewTitleIDFromSql = "SELECT ID FROM title WHERE title.TitleName = '$lecturerNewTitleName'";
			$LecturerNewTitleIDFromSq = mysqli_query($conn, $LecturerNewTitleIDFromSql);
			$LecturerNewTitleIDFrom = mysqli_fetch_assoc($LecturerNewTitleIDFromSq);
			$LecturerNewTitleID = $LecturerNewTitleIDFrom['ID'];

			$lecturerNewNameIdFor = str_replace(' ', '', $lecturerNewName);
			$lecturerNewNameId = strtolower($lecturerNewNameIdFor);

			$LecturerNewValues = "UPDATE lecturer SET lecturer.Name='$lecturerNewName', lecturer.Username = '$lecturerNewNameId', lecturer.TitleID = $LecturerNewTitleID WHERE lecturer.ID = '$LecturerId'";
			if(mysqli_query($conn, $LecturerNewValues)){
				header("LOCATION: ../adminPanel.php");
			}
			else
				echo "FAIL";

			mysqli_close($conn);

		}
		?>

</body>
</html>
