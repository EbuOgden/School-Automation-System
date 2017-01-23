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
    	<h1> Deleting a Lecturer </h1>
		<form method="post">
            <select class="style-select" name="lectureSelect">
				<?php
				$servername = "localhost";
				$userId = "root";
				$password = "";
				$dbName = "examcontrolsystem";

				$conn = mysqli_connect($servername, $userId, $password, $dbName);

				$lecturesFromSql = "SELECT Name, Semester, Code FROM lecture";
				$lecturesFrom = mysqli_query($conn, $lecturesFromSql);

				while($lectures = mysqli_fetch_array($lecturesFrom)){
					echo '<option>' .$lectures['Semester'].' '.$lectures['Code'].' '.$lectures['Name'].'</option>';
				}

				mysqli_close($conn);
				?>
			</select>

            <div class="change-panel">
                <input type="submit" name="deleteLecture" value="Delete Lecture">
                <input type="button" onClick="location.href='adminPanel.php'" value="Back">
            </div>
		</form>
		<?php

		if(isset($_POST['deleteLecture']))
			deleteLecture();

		function deleteLecture(){
			$lectureSemesterControl = substr($_POST['lectureSelect'], 10, 4);

			if(strcmp($lectureSemesterControl, "Fall") == 0){
				$lectureSemester = substr($_POST['lectureSelect'], 0, 14);
				$lectureSelectCode = substr($_POST['lectureSelect'], 15, 6);
			}

			if(strcmp($lectureSemesterControl, "Spri") == 0){
				$lectureSemester = substr($_POST['lectureSelect'], 0, 16);
				$lectureSelectCode = substr($_POST['lectureSelect'], 17, 6);
			}

			$servername = "localhost";
			$userId = "root";
			$password = "";
			$dbName = "examcontrolsystem";

			$conn = mysqli_connect($servername, $userId, $password, $dbName);

			$LectureIdFromSql = "SELECT ID FROM lecture WHERE lecture.Semester = '$lectureSemester' AND lecture.Code = '$lectureSelectCode'";//select lecture id sql
			$LectureIdFromSq = mysqli_query($conn, $LectureIdFromSql);// sql query
			$LectureIdFrom = mysqli_fetch_assoc($LectureIdFromSq);// return value
			$LectureId = $LectureIdFrom['ID'];// assign value

			$ListExamLectureId = "SELECT ID FROM listexamlecture WHERE LectureID = '$LectureId'";//select examlecture id sql
			$ListExamLecture = mysqli_query($conn, $ListExamLectureId);// sql query
			$ListExamLec = mysqli_fetch_assoc($ListExamLecture);//return value
			$ListExam = $ListExamLec['ID'];//assign value

			$ListExamDelete = "DELETE FROM listexamlecture WHERE ID ='$ListExam'";// delete exam sql
			mysqli_query($conn, $ListExamDelete);//sql query

			$ListLectureId = "SELECT ID FROM listlecturelecturer WHERE LectureID = '$LectureId'";// select lecturelecturer id sql
			$ListLecture = mysqli_query($conn, $ListLectureId);// sql query
			$ListLec = mysqli_fetch_assoc($ListLecture);// return value
			$List = $ListLec['ID'];//assign value

			$ListLectureDelete = "DELETE FROM listlecturelecturer WHERE ID = $List";
			mysqli_query($conn, $ListLectureDelete);

			$LectureDelete = "DELETE FROM lecture WHERE lecture.ID = '$LectureId'";
			if(mysqli_query($conn, $LectureDelete)){
				header("LOCATION: ../adminPanel.php");
			}
			else
				echo "FAIL";

			mysqli_close($conn);

		}
		?>

</body>
</html>
