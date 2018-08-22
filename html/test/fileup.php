<?php    
  require_once '../login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);
?>

<!DOCTYPE html>
<html>
<head>
	<title>file upload</title>
</head>
<body>
	<form action="fileup.php" method="post" enctype="multipart/form-data">
		Select File: <input type='file' name='filename' size='10'>
		<input type='submit' name='submit' value='Upload'>
	</form>

<?php
	$userId = 5;
	if(isset($_POST['submit'])){

		$fileName = $_FILES['filename']['name'];
		$fileData = file_get_contents($_FILES['filename']['tmp_name']);
		$fileType = $_FILES['filename']['type'];
		$fileSize = $_FILES['filename']['size'];
		//$userId = 5;

		if(($fileType == 'application/pdf' || $fileType == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $fileType == 'application/msword') && $fileSize <= 2000000){

			$insertStmt = $conn->prepare("INSERT INTO Resume(name, file, fileType, userId) VALUES (?,?,?,?)");
      		$insertStmt->bind_param("sssi", $fileName, $fileData, $fileType, $userId);
      		$insertStmt->execute();
      		if(!$insertStmt->error)
      			echo 'Uploaded to database';
      		else
      			echo $insertStmt->error;
      		
		}
		else echo 'Wrong filetype or file was over 2mb.';
	}

?>


	<br><br>
	<form action="fileup.php" method="post" enctype="multipart/form-data">
		Update File: <input type='file' name='ufilename' size='10'>
		<input type='submit' name='update' value='Update'>
	</form>

<?php
	if(isset($_POST['update'])){

		$fileName = $_FILES['ufilename']['name'];
		$fileData = file_get_contents($_FILES['ufilename']['tmp_name']);
		$fileType = $_FILES['ufilename']['type'];
		$fileSize = $_FILES['ufilename']['size'];
		//$userId = 5;

		if(($fileType == 'application/pdf' || $fileType == 'application/vnd.openxmlformats-officedocument.wordprocessingml.document' || $fileType == 'application/msword') && $fileSize <= 2000000){

			$updateStmt = $conn->prepare("UPDATE `Resume` SET fileType = ?, name = ?, file = ? WHERE `userId` = ?");
			//$insertStmt = $conn->prepare("INSERT INTO Resume(name, file, fileType, userId) VALUES (?,?,?,?)");
      		$updateStmt->bind_param("sssi", $fileType, $fileName, $fileData, $userId);
      		$updateStmt->execute();
      		if(!$updateStmt->error)
      			echo 'Uploaded to database';
      		else
      			echo $updateStmt->error;
      		
		}
		else echo 'Wrong filetype or file was over 2mb.';
	}

?>

	<form action="showfile.php" method="get">
		<button name="id" value=<?php echo $userId;?>>Download</button>
	</form>

	<!--<a href="showfile.php?id=6">Download</a>-->

</body>
</html>