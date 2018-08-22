<?php
	require_once '../login.php';
  	$conn = new mysqli($hn, $un, $pw, $db);
  	if ($conn->connect_error) die($conn->connect_error);


  	if(isset($_GET['id'])){

  		$id = $_GET['id'];
  		$stmt = "SELECT userId, name, file, fileType FROM Resume WHERE userId='$id'";
  		$result = $conn->query($stmt);
  		if (!$result) die ("Database access failed: " . $conn->error);

  		$rows = $result->num_rows;//num of rows in the table
  		$result->data_seek(0);
  		$row = $result->fetch_array(MYSQLI_NUM);

  		$imageData = $row[2];
  		$fname = $row[1];
  		$type = $row[3];
  		header("content-type: $type");
  		header("Content-Disposition: attachment; filename=\"$fname\"");
  		echo $imageData;
  	}
  		

?>