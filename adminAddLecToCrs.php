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
			<h4>Select Lecturer</h4>
			<select class="style-select" name="lecturerSelect">
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
            <div class="change-panel">
                <input type="submit" name="addLecturer" value="Add Lecturer">
                <input type="button" onClick="location.href='adminAddCrs.php'" value="Back">
            </div>
	</div>
		</form>
		<?php

		if(isset($_POST['addLecturer']))
			addLecturer();

		function addLecturer(){
			session_start();
			$lecturerTitle = substr($_POST['lecturerSelect'], 0, 6);

			if(strcmp($lecturerTitle, "Doctor") == 0){
				$lecturerTitleName = $lecturerTitle;
				$lecturerName = substr($_POST['lecturerSelect'], 7);
			}
			else if(strcmp($lecturerTitle, "Profes") == 0){
				$lecturerTitleName = substr($_POST['lecturerSelect'], 0, 9);
				$lecturerName = substr($_POST['lecturerSelect'], 10);
			}
			else if(strcmp($lecturerTitle, "Assist") == 0){
				$lecturerTitleName = substr($_POST['lecturerSelect'], 0, 19);
				$lecturerName = substr($_POST['lecturerSelect'], 20);
			}

			$servername = "localhost";
			$userId = "root";
			$password = "";
			$dbName = "examcontrolsystem";

			$conn = mysqli_connect($servername, $userId, $password, $dbName);

			$TitleIdFromSql = "SELECT ID FROM title WHERE TitleName = '$lecturerTitleName'";
			$TitleIdFrom = mysqli_query($conn, $TitleIdFromSql);
			$TitleId = mysqli_fetch_assoc($TitleIdFrom);
			$Title = $TitleId['ID'];

			$LecturerIdFromSql = "SELECT ID FROM lecturer WHERE lecturer.Name = '$lecturerName' AND lecturer.TitleID = $Title";//select lecturer id sql
			$LecturerIdFromSq = mysqli_query($conn, $LecturerIdFromSql);// sql query
			$LecturerIdFrom = mysqli_fetch_assoc($LecturerIdFromSq);// return value
			$LecturerId = $LecturerIdFrom['ID'];// assign value

			$CodeFrom = $_SESSION['CodeFrom'];
			$SemesterFrom = $_SESSION['SemesterFrom'];

			$LectureIDFromSql = "SELECT ID FROM lecture WHERE Code = '$CodeFrom' AND Semester = '$SemesterFrom'";
			$LectureIDFrom = mysqli_query($conn, $LectureIDFromSql);
			$LectureIDFr = mysqli_fetch_assoc($LectureIDFrom);
			$LectureID = $LectureIDFr['ID'];

			$InsertLecturer = "INSERT INTO listlecturelecturer(LectureID, LecturerID) VALUES ($LectureID, $LecturerId)";

			if(mysqli_query($conn, $InsertLecturer)){
				header("LOCATION: ../adminPanel.php");
			}
			mysqli_close($conn);

		}
		?>

</body>
</html>
