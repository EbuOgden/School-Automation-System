<!DOCTYPE html>
<html>
<head>
    <title>Exam Schedule</title>
    <meta charset="utf-8">
    <link href="css/style.css" rel='stylesheet' type='text/css' />
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<div class="logout">
		<input type="button" onclick="location.href='admin.php'" value="Log Out" width="%45">
	</div>
    <div class="lecturer-form">
        <h2>Lecturer Process</h2>
        <form>
			<input type="button" onclick="location.href='adminAddLec.php'" value="Add">
			<input type="button" onclick="location.href='adminEditLec.php'" value="Edit">
            <input type="button" onclick="location.href='adminDelLec.php'" value="Delete">
        </form>
    </div>
    <div class="course-form">
        <h2>Lecture Process</h2>
        <form>
            <input type="button" onclick="location.href='adminAddCrs.php'" value="Add">
            <input type="button" onclick="location.href='adminEditCrs.php'" value="Edit">
			<input type="button" onclick="location.href='adminDelCrs.php'" value="Delete">
        </form>
    </div>
</body>
</html>
