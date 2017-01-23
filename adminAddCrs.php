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
    	<h1> Add Course </h1>
		<form method="post">
			<h6 style="text-align:center"> Semester </h6>
            <select class="style-select-lecture" name="semesterSelect" style="width:150px">
				<option>2014-2015 Spring</option>
				<option>2015-2016 Fall</option>
				<option>2015-2016 Spring</option>
			</select>
			<input type="text" class="text" name="lectureCodeEnter" value="Lecture Code" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Lecture Code';}" ><br/>
			<input type="text" class="text" name="lectureEnter" value="Lecture Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Lecture Name';}" ><br/><br/><br/>
            <div class="change-panel">
                <input type="submit" name="addLecture" value="Add Lecture">
                <input type="button" onClick="location.href='adminPanel.php'" value="Back">
            </div>
	</div>
		</form>
		<?php

		if(isset($_POST['addLecture']))
			addLecture();

		function addLecture(){
			session_start();
			$semesterSelect = $_POST['semesterSelect'];
			$lectureCode = $_POST['lectureCodeEnter'];
			$lectureName = $_POST['lectureEnter'];

			$lectureCodeControl = strlen($lectureCode);

			$lectureCode = strtoupper($lectureCode);

			$servername = "localhost";
			$userId = "root";
			$password = "";
			$dbName = "examcontrolsystem";

			$conn = mysqli_connect($servername, $userId, $password, $dbName);

			$CheckLectureIfExistSql = "SELECT Code FROM lecture WHERE lecture.Code = '$lectureCode'";
			$CheckLectureIfExist = mysqli_query($conn, $CheckLectureIfExistSql);
			$CheckLectureIf = mysqli_fetch_assoc($CheckLectureIfExist);
			$CheckLecture = $CheckLectureIf['Code'];

			$CheckLectureSemesterIfExistSql = "SELECT Semester from lecture WHERE lecture.Semester = '$semesterSelect'";
			$CheckLectureSemesterIfExist = mysqli_query($conn, $CheckLectureSemesterIfExistSql);
			$CheckLectureSemesterIf = mysqli_fetch_assoc($CheckLectureSemesterIfExist);
			$CheckLectureSemester = $CheckLectureSemesterIf['Semester'];

			$InsertLecture = "INSERT INTO lecture(Code, Name, Semester) VALUES ('$lectureCode', '$lectureName', '$semesterSelect')";

			if(($lectureCodeControl < 6) || ($lectureCodeControl > 6)){
				echo "<script type='text/javascript'>alert('Lecture Code must be 6 character');</script>";
			}
			else if((strcmp($CheckLecture, $lectureCode) == 0) && (strcmp($CheckLectureSemester, $semesterSelect) == 0)){
				echo "<script type='text/javascript'>alert('$lectureName is already exist');</script>";
			}

			else if((strcmp($lectureCode, "") == 0) || (strcmp($lectureName, "") == 0)){
				echo "<script type='text/javascript'>alert('Please Fill All Boxes');</script>";
			}
			else{
				mysqli_query($conn, $InsertLecture);
				$_SESSION['CodeFrom'] = $lectureCode;
				$_SESSION['SemesterFrom'] = $semesterSelect;
				header("LOCATION: ../adminAddLecToCrs.php");
			}

			mysqli_close($conn);

		}
		?>

</body>
</html>
