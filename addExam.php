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
    	<h1> Add Exam </h1>
		<form method="POST">
		<h2 style="color:white; text-align:center">Lecture List</h2>
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
			<h3 style="color:white">Exam Type</h3>
			<select class="style" style="width:150px" name="examTypeSelect">
				<?php
					$servername = "localhost";
					$userId = "root";
					$password = "";
					$dbName = "examcontrolsystem";

					$conn = mysqli_connect($servername, $userId, $password, $dbName);

					$titlesFromSql = "SELECT Name FROM examtype";
					$titlesFrom = mysqli_query($conn, $titlesFromSql);

					while($titles = mysqli_fetch_array($titlesFrom)){
						echo '<option>' .$titles['Name'].' </option>';
					}

					mysqli_close($conn);
				?>
			</select>
			<h3 style="color:white">Date</h3>
			<select class="style" style="width:50px" name="examDate">
				<option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option>
				<option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option>
				<option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
				<option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option><option>31</option>
			</select>
			<select class="style" style="width:50px" name="examDateMonth">
				<option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option>
				<option>09</option><option>10</option><option>11</option><option>12</option>
			</select>
			<select class="style" style="width:50px" name="examDateYear">
				<option>2015</option><option>2016</option><option>2017</option>
			</select>
			<h3 style="color:white">Time</h3>
			<select class="style" style="width:50px" name="examHour">
				<option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option><option>08</option>
				<option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option><option>16</option>
				<option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option><option>24</option>
			</select>:
			<select class="style" style="width:50px" name="examMin">
				<option>00</option><option>01</option><option>02</option><option>03</option><option>04</option><option>05</option><option>06</option><option>07</option>
				<option>08</option><option>09</option><option>10</option><option>11</option><option>12</option><option>13</option><option>14</option><option>15</option>
				<option>16</option><option>17</option><option>18</option><option>19</option><option>20</option><option>21</option><option>22</option><option>23</option>
				<option>24</option><option>25</option><option>26</option><option>27</option><option>28</option><option>29</option><option>30</option><option>32</option>
				<option>33</option><option>34</option><option>35</option><option>36</option><option>37</option><option>38</option><option>39</option><option>40</option>
				<option>41</option><option>42</option><option>43</option><option>44</option><option>45</option><option>46</option><option>47</option><option>48</option>
				<option>49</option><option>50</option><option>51</option><option>52</option><option>53</option><option>54</option><option>55</option><option>56</option>
				<option>57</option><option>58</option><option>59</option>
			</select><br/>
			<input type="text" class="text" name="examPlace" value="Exam Place" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Exam Place';}" >
            <div class="change-panel">
                <input type="submit" name="addExam" value="Add Exam">
                <input type="button" onClick="location.href='LecPanel.php'" value="Back">
            </div>
		</form>
<?php
		if(isset($_POST['addExam'])){
			addExam();
		}

		function addExam(){
			$examDateD = $_POST['examDate'];
			$examMonth = $_POST['examDateMonth'];
			$examYear = $_POST['examDateYear'];
			$examType = $_POST['examTypeSelect'];
			$examPlace = $_POST['examPlace'];
			$examHour = $_POST['examHour'];
			$examMin = $_POST['examMin'];

			if($examPlace === "Exam Place"){
				echo "<script type='text/javascript'>alert(' Please insert available exam place');</script>";
				exit();
			}

			$examDate = $examDateD . ' ' . $examMonth .' ' . $examYear;

			$examTime = $examHour . ' ' . $examMin;

			$lectureSelect = $_POST['lectureSelect'];

			$lectureSemesterControl = substr($lectureSelect, 10, 4);

			if(strcmp($lectureSemesterControl, "Fall") == 0){	$lectureSelectCode = substr($lectureSelect, 15, 6); $lectureSemester = substr($lectureSelect, 0, 14);	}

			if(strcmp($lectureSemesterControl, "Spri") == 0){	$lectureSelectCode = substr($lectureSelect, 17, 6); $lectureSemester = substr($lectureSelect, 0, 17);	}

			$servername = "localhost";
			$userId = "root";
			$password = "";
			$dbName = "examcontrolsystem";

			$conn = mysqli_connect($servername, $userId, $password, $dbName);

			$LectureIDFromSql = "SELECT ID, Code FROM lecture WHERE Code = '$lectureSelectCode' AND Semester = '$lectureSemester'";
			$LectureIDFromS = mysqli_query($conn, $LectureIDFromSql);
			$LectureIDFrom = mysqli_fetch_assoc($LectureIDFromS);
			$LectureID = $LectureIDFrom['ID'];
			$LectureCode = $LectureIDFrom['Code'];

			$ExamTypeIDFromSql = "SELECT ID FROM examtype WHERE Name = '$examType'";
			$ExamTypeIDFromS = mysqli_query($conn, $ExamTypeIDFromSql);
			$ExamTypeIDFrom = mysqli_fetch_assoc($ExamTypeIDFromS);
			$ExamTypeID = $ExamTypeIDFrom['ID'];

			$ExamTypeNameFromSql = "SELECT Name FROM examtype WHERE ID = $ExamTypeID";
			$ExamTypeNameFrom = mysqli_query($conn, $ExamTypeNameFromSql);
			$ExamTypeNameF = mysqli_fetch_assoc($ExamTypeNameFrom);
			$ExamTypeName = $ExamTypeNameF['Name'];

			$ExamCheckIfExist = "SELECT LectureID, TypeID from listexamlecture WHERE LectureID = $LectureID";
			$ExamCheckIf = mysqli_query($conn, $ExamCheckIfExist);
			$ExamCheckF = mysqli_fetch_assoc($ExamCheckIf);
			$ExamCheckLecture = $ExamCheckF['LectureID'];
			$ExamCheckType = $ExamCheckF['TypeID'];


			if(($ExamCheckLecture == $LectureID) && ($ExamCheckType == $ExamTypeID)){
				echo "<script type='text/javascript'>alert(' $ExamTypeName is already exist for $LectureCode');</script>";
				exit();
			}

			$InsertExam = "INSERT INTO exam(ExamDate, ExamPlace, ExamTime, TypeID) VALUES ('$examDate', '$examPlace', '$examTime', $ExamTypeID)";
			mysqli_query($conn, $InsertExam);


			$ExamIDFromSql = "SELECT ID FROM exam WHERE ExamDate = '$examDate' AND ExamPlace = '$examPlace'";
			$ExamIDFromS = mysqli_query($conn, $ExamIDFromSql);
			$ExamIDFrom = mysqli_fetch_assoc($ExamIDFromS);
			$ExamID = $ExamIDFrom['ID'];

			$InsertlistExamLecture = "INSERT INTO listexamlecture (LectureID, ExamID, TypeID) VALUES ($LectureID, $ExamID, $ExamTypeID)";

			if(mysqli_query($conn, $InsertlistExamLecture))
				echo "<script type='text/javascript'>alert('Insert Successfull');</script>";

			mysqli_close($conn);
		}
		?></body>
</html>
