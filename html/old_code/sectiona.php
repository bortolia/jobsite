<!DOCTYPE html>
<html>
<head>
	<title>Profiles Form - Section A</title>
</head>
<body>

<?php
	require_once 'login.php';
	$conn = new mysqli($hn, $un, $pw, $db);
	if ($conn->connect_error) die($conn->connect_error);

	$typeQuery = "SELECT user_code, user_description FROM User_codes";
	$resultType = $conn->query($typeQuery);
	if (!$resultType) die ("Database access failed: " . $conn->error);

	$rows = $resultType->num_rows;

	if (isset($_POST['fname'])	&&	
      isset($_POST['lname'])	&&	
      isset($_POST['usertype'])	&&
      isset($_POST['email'])	&&
      isset($_POST['password']))
	{
		$fname = get_post($conn, 'fname');
		$lname = get_post($conn, 'lname');
		$usertype = get_post($conn, 'usertype');
		$email = get_post($conn, 'email');
		$password = get_post($conn, 'password');

		if(!empty($_POST['fname'])	&&
			!empty($_POST['lname'])	&&
			!empty($_POST['usertype'])	&&
			!empty($_POST['email'])	&&
			!empty($_POST['password']))
		{

//new insert statement with prepare implimentation
			$insertStmt = $conn->prepare("INSERT INTO User_profiles(fname, lname, usercode, email, password) VALUES (?,?,?,?,?)");
			$insertStmt->bind_param("sssss", $fname, $lname, $usertype, $email, $password);
			$insertStmt->execute();
			if(!$insertStmt->error)
				echo '<span style="color:green;">Inserted record successfully.</span>';

			else
				echo '<span style="color:red;">INSERT failed: '. $conn->error.'</span><br>';
		}
		else
			echo '<span style="color:red;">*Please fill all fields*</span>';

	}

?>

	<form action="sectiona.php" method="post">
	First name:<input type="text" name="fname" required><br>
	Last name:<input type="text" name="lname" required><br>

	User Type:<select name="usertype">
<?php
	for($i = 0; $i < $rows; $i++){
		$resultType->data_seek($i);
		$row = $resultType->fetch_array(MYSQLI_NUM);
		echo "<option value=".$row[0].">".$row[1]."</option>"; //reads dynamically from database
	}
?>
	</select><br>
	
	E-mail:<input type="email" name="email" required><br>
	Password:<input type="password" name="password" required><br>
	<input type="submit" value="Submit"><br>
	</form>

<?php
	
	$resultType->close();
	$resultInsert->close();
	$conn->close();

function get_post($conn, $var){

	return $conn->real_escape_string($_POST[$var]);
}

?>

</body>
</html>