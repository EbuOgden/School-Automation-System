<!DOCTYPE html>
<?php
session_start();
?>
<html>
<head>
    <title>Exam Schedule</title>
    <meta charset="utf-8">
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<div class="logout">
		<input type="button" onclick="location.href='index.php'" value="Log Out" width="%45">
	</div>
	<div class="lecturer-form">
		<h1>Student Menu</h1>
	</div>
    <div class="lecturer-form">
        <table>
			<?php

				$studentID = $_SESSION['studentLoginId'];
				$servername = "localhost";
				$userId = "root";
				$password = "";
				$dbName = "examcontrolsystem";

				$conn = mysqli_connect($servername, $userId, $password, $dbName);

				$LectureID = array();
				$indexStudent = 0;

				$LectureIDFromListStudent = "SELECT LectureID FROM liststudentlecture WHERE StudentID = $studentID";
				$LectureIDFromList = mysqli_query($conn, $LectureIDFromListStudent);
				while($LectureIDFrom = mysqli_fetch_assoc($LectureIDFromList)){
					$LectureID[$indexStudent] = $LectureIDFrom['LectureID'];
					$indexStudent++;
				}

				$indexLecture = 0;
				$check = 0;

				$LectureIDCheck = array();

				for($check; $check < $indexStudent; $check++){
					$LectureIDCheckFromExamList = "SELECT LectureID FROM listexamlecture WHERE LectureID = $LectureID[$check]";
					$LectureIDCheckFrom = mysqli_query($conn, $LectureIDCheckFromExamList);
					while($LectureIDCheckF = mysqli_fetch_assoc($LectureIDCheckFrom)){
						$LectureIDCheck[$indexLecture] = $LectureIDCheckF['LectureID'];
						$indexLecture++;
						}
				}

				$check = 0;

				$ExamID = array();

				for($check; $check < $indexLecture; $check++){
					$ExamIDFromExamList = "SELECT ExamID FROM listexamlecture WHERE LectureID = $LectureIDCheck[$check]";
					$ExamIDFromExamL = mysqli_query($conn, $ExamIDFromExamList);
					while($ExamIDFromExam = mysqli_fetch_assoc($ExamIDFromExamL)){
						$ExamID[$check] = $ExamIDFromExam['ExamID'];
					}
				}

				$check = 0;

				if(!empty($ExamID)){
					echo "<tr> ";
					echo "<td> Course Code </td> ";
					echo "<td> &nbsp Course Name </td> ";
					echo "<td> &nbsp Exam Date </td> ";
					echo "<td> &nbsp Exam Time </td> ";
					echo "<td> &nbsp Exam Place </td> ";
					echo "</tr> ";
				}
				for($check; $check < $indexLecture; $check++){
					$PrintExamListLecture = "SELECT Code, Name FROM lecture WHERE ID = $LectureIDCheck[$check]";
					$PrintExamListExam = "SELECT ExamDate, ExamTime, ExamPlace FROM exam WHERE exam.ID = $ExamID[$check]";
					$PrintExamList = mysqli_query($conn, $PrintExamListLecture);
					$PrintExam = mysqli_query($conn, $PrintExamListExam);
					while ( ($PrintExamLecture = mysqli_fetch_array($PrintExamList)) && ($PrintExamExam = mysqli_fetch_array($PrintExam))) {
						echo "<tr> ";
						echo "<td> &nbsp" . $PrintExamLecture['Code'] . "</td>";
						echo "<td> &nbsp&nbsp&nbsp" . $PrintExamLecture['Name'] . "</td>";
						echo "<td> &nbsp" . $PrintExamExam['ExamDate'] . "</td>";
						echo "<td> &nbsp&nbsp&nbsp" . $PrintExamExam['ExamTime'] . "</td>";
						echo "<td> &nbsp&nbsp&nbsp&nbsp&nbsp" . $PrintExamExam['ExamPlace'] . "</td>";
						echo "</tr>";
					}
				}
				?>
				</table>
        </form>
    </div>
    <div class="course-form">
        <form method="POST">
            <input type="submit" name="addCourse" value="Add Course">
           	<input type="submit" name="deleteCourse" value="Delete Course" width="200px">
        </form>
    </div>
	<?php
	if(isset($_POST['addCourse'])){
		$studentID = $_SESSION['studentLoginId'];
		$_SESSION['studentID'] = $studentID;
		header("LOCATION: ../stdAddCrs.php");
	}

	if(isset($_POST['deleteCourse'])){
		$studentID = $_SESSION['studentLoginId'];
		$_SESSION['studentID'] = $studentID;
		header("LOCATION: ../stdDelCrs.php");
	}
	?>
</body>
</html>
