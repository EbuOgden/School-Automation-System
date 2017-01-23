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
    	<h1> Delete Course </h1>
		<form method="post">
            <select class="style-select" name="lectureSelect">
				<?php
				session_start();
				$servername = "localhost";
				$userId = "root";
				$password = "";
				$dbName = "examcontrolsystem";

				$conn = mysqli_connect($servername, $userId, $password, $dbName);
				
				$lecturesFromSql = "SELECT Code, Name, Semester FROM lecture";
				$lecturesFrom = mysqli_query($conn, $lecturesFromSql);

				while($lectures = mysqli_fetch_array($lecturesFrom)){
					echo '<option>' .$lectures['Semester'].' '.$lectures['Code'].' '.$lectures['Name'].' </option>';
				}

				mysqli_close($conn);
				?>
			</select>
			<div class="change-panel">
                <input type="submit" name="addLecture" value="Delete Lecture">
                <input type="button" onClick="location.href='stdMenu.php'" value="Back">
            </div>
		</form>
		<?php
		if(isset($_POST['addLecture']))
			delLecture();

		function delLecture(){
			$studentID = $_SESSION['studentID'];
			$lectureSelect = $_POST['lectureSelect'];

			$lectureSemesterControl = substr($lectureSelect, 10, 4);

			if(strcmp($lectureSemesterControl, "Fall") == 0)
				$lectureSelectCode = substr($lectureSelect, 15, 6);

			if(strcmp($lectureSemesterControl, "Spri") == 0)
				$lectureSelectCode = substr($lectureSelect, 17, 6);

			$servername = "localhost";
			$userId = "root";
			$password = "";
			$dbName = "examcontrolsystem";

			$conn = mysqli_connect($servername, $userId, $password, $dbName);

			$LectureIDFromSql = "SELECT ID FROM lecture WHERE Code = '$lectureSelectCode'";
			$LectureIDFrom = mysqli_query($conn, $LectureIDFromSql);
			$LectureIDFr = mysqli_fetch_assoc($LectureIDFrom);
			$LectureID = $LectureIDFr['ID'];

			$LectureIDControlInt = array();
			$ListLectureID = array();
			$index = 0;

			$LectureControlFromSql = "SELECT LectureID, ID FROM liststudentlecture WHERE StudentID = $studentID";
			$LectureControlFrom = mysqli_query($conn, $LectureControlFromSql);
			while($LectureControl = mysqli_fetch_array($LectureControlFrom)){
				$LectureIDControlInt[$index] = $LectureControl['LectureID'];
				$ListLectureID[$index] = $LectureControl['ID'];
				$index++;
			}
			$check = 0;

			$LectureCodeControl = array();

			for($check; $check < $index; $check++){
				$LectureCodeControlFromSql = "SELECT Code FROM lecture WHERE ID = $LectureIDControlInt[$check]";
				$LectureCodeControlFrom = mysqli_query($conn, $LectureCodeControlFromSql);
				$LectureCodeControlF = mysqli_fetch_array($LectureCodeControlFrom);
				$LectureCodeControl[$check] = $LectureCodeControlF['Code'];
			}

			$check = 0;

			$counter = 0;
			$deleteLec = 0;

			for($check; $check < $index; $check++){
				if($LectureCodeControl[$check] == $lectureSelectCode){
					$counter++;
					$deleteLec = $check;
					break;
				}

			}

			$check = 0;
			for($check; $check < $index; $check++){
				$LectureDeleteFromList = "DELETE FROM liststudentlecture WHERE ID = $ListLectureID[$deleteLec]";
				if($counter < 1){
					echo "<script type='text/javascript'>alert('You did not took $lectureSelectCode');</script>";
					exit();
				}
				else if($counter == 1){
					mysqli_query($conn, $LectureDeleteFromList);
					echo "<script type='text/javascript'>alert('Delete Successfull');</script>";
					exit();
				}
			}

			mysqli_close($conn);
		}
		?>
</body>
</html>
