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
			<input type="text" class="text" name="examPlace" value="New Exam Place" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'New Exam Place';}" >
            <div class="change-panel">
                <input type="submit" name="editExam" value="Edit Exam">
                <input type="button" onClick="location.href='LecPanel.php'" value="Back">
            </div>
		</form>
<?php
		if(isset($_POST['editExam'])){
			editExam();
		}

		function editExam(){
			$examDateD = $_POST['examDate'];
			$examMonth = $_POST['examDateMonth'];
			$examYear = $_POST['examDateYear'];
			$examType = $_POST['examTypeSelect'];
			$examPlace = $_POST['examPlace'];
			$examHour = $_POST['examHour'];
			$examMin = $_POST['examMin'];

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

			$LectureIDFromSql = "SELECT ID FROM lecture WHERE Code = '$lectureSelectCode' AND Semester = '$lectureSemester'";
			$LectureIDFromS = mysqli_query($conn, $LectureIDFromSql);
			$LectureIDFrom = mysqli_fetch_assoc($LectureIDFromS);
			$LectureID = $LectureIDFrom['ID'];

			$ExamTypeIDFromSql = "SELECT ID FROM examtype WHERE Name = '$examType'";
			$ExamTypeIDFromS = mysqli_query($conn, $ExamTypeIDFromSql);
			$ExamTypeIDFrom = mysqli_fetch_assoc($ExamTypeIDFromS);
			$ExamTypeID = $ExamTypeIDFrom['ID'];

			$SelectExamIDFromSql = "SELECT ExamID FROM listexamlecture WHERE LectureID = $LectureID";
			$SelectExamIDF = mysqli_query($conn, $SelectExamIDFromSql);
			$SelectExamID = mysqli_fetch_assoc($SelectExamIDF);
			$ExamID = $SelectExamID['ExamID'];

			$SelectExamFromSql = "SELECT * FROM exam WHERE ID = $ExamID";
			$SelectExamFrom = mysqli_query($conn, $SelectExamFromSql);
			$SelectExam = mysqli_fetch_array($SelectExamFrom);

			if(($examPlace === "New Exam Place" ))
				$examPlace = $SelectExam['ExamPlace'];

			$UpdateExam = "UPDATE exam SET ExamDate='$examDate', ExamPlace='$examPlace', ExamTime='$examTime', TypeID = $ExamTypeID WHERE ID = $ExamID";

			if(mysqli_query($conn, $UpdateExam)){
				echo "<script type='text/javascript'>alert('Update Successfull');</script>";
			}

			mysqli_close($conn);
		}
		?></body>
</html>
