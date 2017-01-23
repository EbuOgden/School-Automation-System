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
    	<h1> Edit Course </h1>
		<form method="post">
            <select class="style-select" name="lectureSelect">
				<?php
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
			<h5>New Lecture Semester</h5>
			<select class="style-select-lecture-edit" style="width:150px" name="semesterSelect">
				<option>2014-2015 Spring</option>
				<option>2015-2016 Fall</option>
				<option>2015-2016 Spring</option>
			</select><br/><br/><br/>
			<input type="text" class="text" name="lectureCodeEnter" value="New Lecture Code" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'New Lecture Code';}" ><br/>
			<input type="text" class="text" name="lectureEnter" value="New Lecture Name" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'New Lecture Name';}" >
            <div class="change-panel">
                <input type="submit" name="editLecture" value="Edit Lecture">
                <input type="button" onClick="location.href='adminPanel.php'" value="Back">
            </div>
		</form>
		<?php

		if(isset($_POST['editLecture']))
			editLecture();

		function editLecture(){
			$lectureSelect = $_POST['lectureSelect'];
			$newSemesterSelect = $_POST['semesterSelect'];
			$lectureNewCode = $_POST['lectureCodeEnter'];
			$lectureNewName = $_POST['lectureEnter'];

			$lectureNewCode = stripslashes($lectureNewCode);// for sql injection
			$lectureNewName = stripslashes($lectureNewName);// for sql injection

			$lectureSemesterControl = substr($lectureSelect, 10, 4);

			if(strcmp($lectureSemesterControl, "Fall") == 0){
				$lectureSelectCode = substr($lectureSelect, 15, 6);
				if(strcmp($lectureNewCode, "New Lecture Code") == 0){
					$lectureNewCode = $lectureSelectCode;

				}
				if(strcmp($lectureNewName, "New Lecture Name") == 0){
					$lectureNewName = substr($lectureSelect, 22);
				}
			}

			if(strcmp($lectureSemesterControl, "Spri") == 0){
				$lectureSelectCode = substr($lectureSelect, 17, 6);
				if(strcmp($lectureNewCode, "New Lecture Code") == 0){
					$lectureNewCode = $lectureSelectCode;
				}
				if(strcmp($lectureNewName, "New Lecture Name") == 0){
					$lectureNewName = substr($lectureSelect, 24);
				}
			}

			$servername = "localhost";
			$userId = "root";
			$password = "";
			$dbName = "examcontrolsystem";

			$conn = mysqli_connect($servername, $userId, $password, $dbName);

			$LectureIDFromSql = "SELECT ID FROM lecture WHERE Code = '$lectureSelectCode'";
			$LectureIDFrom = mysqli_query($conn, $LectureIDFromSql);
			$LectureIDFr = mysqli_fetch_assoc($LectureIDFrom);
			$LectureID = $LectureIDFr['ID'];

			$LectureUpdate = "UPDATE lecture SET Name='$lectureNewName', Semester='$newSemesterSelect', Code='$lectureNewCode' WHERE ID = $LectureID";
			if(mysqli_query($conn, $LectureUpdate))
				header("LOCATION: ../adminPanel.php");

			else
				echo "FAIL";


			mysqli_close($conn);

		}
		?>

</body>
</html>
