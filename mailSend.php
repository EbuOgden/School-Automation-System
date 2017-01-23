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
    	<h1> Edit Exam </h1>
		<form method="POST">
		<h2 style="color:white; text-align:center">Exam List</h2>
            <select class="style-select" name="lectureSelect">
				<?php
					$servername = "localhost";
					$userId = "root";
					$password = "";
					$dbName = "examcontrolsystem";

					$exam = array();
					$index = 0;

					$conn = mysqli_connect($servername, $userId, $password, $dbName);// db ye baglanti

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
                <input type="submit" name="sendMail" value="Send Mail">
                <input type="button" onClick="location.href='LecPanel.php'" value="Back">
            </div>
		</form>
<?php
		if(isset($_POST['sendMail'])){
			@sendMail();
		}
		
		function sendMail(){
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

			$Students = array();
			$index = 0;

			$SelectStudentsIDFromSql = "SELECT StudentID FROM liststudentlecture WHERE LectureID = $LectureID";
			$SelectStudentsID = mysqli_query($conn, $SelectStudentsIDFromSql);
			while($SelectStudents = mysqli_fetch_array($SelectStudentsID)){
				$Students[$index] = $SelectStudents['StudentID'];
				$index++;
			}

			$StudentEmail = array();
			$counter = 0;

			for($counter; $counter < $index; $counter++){
				$SelectStudentsEmailFromSql = "SELECT Email FROM student WHERE ID = $Students[$counter]";
				$SelectStudentsEmailFrom = mysqli_query($conn, $SelectStudentsEmailFromSql);
				$SelectStudentEmail = mysqli_fetch_array($SelectStudentsEmailFrom);
				$StudentEmail[$counter] = $SelectStudentEmail['Email'];
			}

			$SelectExamFromSql = "SELECT ExamPlace, ExamTime, ExamDate FROM exam WHERE ID = $ExamID";
			$SelectExamFrom = mysqli_query($conn, $SelectExamFromSql);
			$SelectExam = mysqli_fetch_array($SelectExamFrom);
			$ExamPlace = $SelectExam['ExamPlace'];
			$ExamDate = $SelectExam['ExamDate'];
			$ExamTime = $SelectExam['ExamTime'];

			$counter = 0;

			for($counter; $counter < $index; $counter++){
				$to = $StudentEmail[$counter];
				$subject = "Exam Announcement";
				$message = "Exam Place = $ExamPlace /-/ Exam Date = $ExamDate /-/ Exam Time = $ExamTime";
				$header  = "From:scrubs_83@hotmail.com \r\n";
				mail ($to,$subject,$message,$header);
			}

			echo "<script type='text/javascript'>alert('Mail Posted Successfully');</script>";



			mysqli_close($conn);
		}
		?>
</body>
</html>
