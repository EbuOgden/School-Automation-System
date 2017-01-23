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
    	<h1> Delete Exam </h1>

		<form method="POST">
		<h3 style="color:white; text-align:center">Exam List </h3>
            <select class="style-select" name="lectureSelect">
				<?php
					$servername = "localhost";
					$userId = "root";
					$password = "";
					$dbName = "examcontrolsystem";

					$exam = array();
					$index = 0;

					$conn = mysqli_connect($servername, $userId, $password, $dbName);

					$examLectureListSql = "SELECT LectureID from listexamlecture";
					$examLectureList = mysqli_query($conn, $examLectureListSql);
					while($examLecture = mysqli_fetch_assoc($examLectureList)){
						$exam[$index] = $examLecture['LectureID'];
						$index++;
					}

					$i = 0;
					for($i; $i <= $index; $i++){
						$lecturesFromSql = "SELECT Code, Name, Semester FROM lecture WHERE ID = $exam[$i]";
						$lecturesFrom = mysqli_query($conn, $lecturesFromSql);

						while($lectures = mysqli_fetch_array($lecturesFrom)){
							echo '<option>' .$lectures['Semester'].' '.$lectures['Code'].' '.$lectures['Name'].' </option>';
							}
					}

					mysqli_close($conn);
				?>
			</select>
            <div class="change-panel">
                <input type="submit" name="deleteExam" value="Delete Exam">
                <input type="button" onClick="location.href='LecPanel.php'" value="Back">
            </div>
		</form>
<?php
		if(isset($_POST['deleteExam'])){
			deleteExam();
		}

		function deleteExam(){
			$lectureSelect = $_POST['lectureSelect'];

			$lectureSemesterControl = substr($lectureSelect, 10, 4);

			if(strcmp($lectureSemesterControl, "Fall") == 0){	$lectureSelectCode = substr($lectureSelect, 15, 6); $lectureSemester = substr($lectureSelect, 0, 14);	}

			if(strcmp($lectureSemesterControl, "Spri") == 0){	$lectureSelectCode = substr($lectureSelect, 17, 6); $lectureSemester = substr($lectureSelect, 0, 17);	}

			$servername = "localhost";
			$userId = "root";
			$password = "";
			$dbName = "examcontrolsystem";

			$conn = mysqli_connect($servername, $userId, $password, $dbName);

			$LectureIDFromSql = "SELECT ID FROM lecture WHERE Code = '$lectureSelectCode' AND Semester = '$lectureSemester'";
			$LectureIDFromS = mysqli_query($conn, $LectureIDFromSql);
			$LectureIDFrom = mysqli_fetch_assoc($LectureIDFromS);
			$LectureID = $LectureIDFrom['ID'];

			$SelectExamIDFromSql = "SELECT ExamID FROM listexamlecture WHERE LectureID = $LectureID";
			$SelectExamIDF = mysqli_query($conn, $SelectExamIDFromSql);
			$SelectExamID = mysqli_fetch_assoc($SelectExamIDF);
			$ExamID = $SelectExamID['ExamID'];

			$DeleteExamList = "DELETE FROM listexamlecture WHERE ExamID = $ExamID";

			mysqli_query($conn, $DeleteExamList);

			$DeleteExam = "DELETE FROM exam WHERE ID = $ExamID";

			if(mysqli_multi_query($conn, $DeleteExam)){
				echo "<script type='text/javascript'>alert('Delete Successfull');</script>";
			}

			mysqli_close($conn);
		}
		?></body>
</html>
