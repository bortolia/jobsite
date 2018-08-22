<?php
  require_once "login.php";
  session_start();
  if(!isset($_SESSION['email'])){
    header('location: signin.php');
  }
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  $userId = $_SESSION['userId'];
  $fname = $_SESSION['fname'];
  $lname = $_SESSION['lname'];
  $email = $_SESSION['email'];

  $postId = $_GET['postId'];
  $_SESSION['postId'] = $postId;
  $postId = $_SESSION['postId'];

  if($_SESSION['usercode'] == "1"){

  	$checkQuery = "SELECT * FROM Job_applications WHERE userId = '$userId' AND postId = '$postId'";
  	$checkResult = $conn->query($checkQuery);
  	if (!$checkResult) die($conn->error);
  	$checkRows = $checkResult->num_rows;
  	$checkResult->data_seek(0);
  	$checkRow = $checkResult->fetch_array(MYSQLI_NUM);


  	$resumeIdQuery = "SELECT resumeId FROM Resume WHERE userId = '$userId'";
  	$resumeIdResult = $conn->query($resumeIdQuery);
  	if (!$resumeIdResult) die($conn->error);
  	$resumeIdRows = $resumeIdResult->num_rows;
  	$resumeIdResult->data_seek(0);
  	$resumeIdRow = $resumeIdResult->fetch_array(MYSQLI_NUM);
  	$resumeId = $resumeIdRow[0];


  	if(isset($_POST['applied'])){
  		/*echo $postId;
  		echo $resumeId;
  		echo $fname;
  		echo $lname;
  		echo $email;
  		echo $userId;*/
		$applicStmt = $conn->prepare("INSERT INTO Job_applications (postId, resumeId, fname, lname, email, userId) VALUES (?,?,?,?,?,?)");
	  	$applicStmt->bind_param("iisssi", $postId, $resumeId, $fname, $lname, $email, $userId);
	  	$applicStmt->execute();

	  	if(!$applicStmt->error){
	  		echo "<script>window.location.href ='jobview.php?postId=$postId';</script>";
	  	}

  	}
//do this after button
/*  	$applicStmt = "INSERT INTO Job_applications (postId, resumeId, fname, lname, email, userId) VALUES (?,?,?,?,?,?)";
  	$applicStmt->bind_param("iisssi", $postId, $resumeId, $fname, $lname, $email, $userId);
  	$applicStmt->execute();

  	if(!$applicStmt->error){
  		echo 'yeah';
  	}*/

  }

  if(isset($_GET['postId'])){
  	
  	$jobViewQuery = "SELECT title, company, description, province, city FROM Job_posting WHERE postId='$postId'";

  	$jobViewResult = $conn->query($jobViewQuery);
  	if (!$jobViewResult) die($conn->error);

  	$jobViewRows = $jobViewResult->num_rows;
  	// set up database query
  	$jobViewResult->data_seek(0);
    $jobViewRow = $jobViewResult->fetch_array(MYSQLI_NUM);
    $formatDesc = preg_replace('/\v+|\\\r\\\n/','<br/>',$jobViewRow[2]);

  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<title><?php echo $jobViewRow[0];?> | Jobsearch</title>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</head>

<body>

    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
      <a class="navbar-brand" href="#"><img src="../pictures/logo.png" alt="logo" width="115" height="30"></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <a class="nav-link" href="http://bortolia.myweb.cs.uwindsor.ca/60334/project/html/index.php">Home <span class="sr-only">(current)</span></a>
          </li>          
          <li class="nav-item">
            <a class="nav-link" href="http://bortolia.myweb.cs.uwindsor.ca/60334/project/html/logout.php">Logout</a>
          </li>
        </ul>
<?php
  if($_SESSION['usercode'] == "1"){
?>        
        <form class="form-inline mt-2 mt-md-0" method="get" action="searchresult.php">
          <input class="form-control mr-sm-2" type="text" placeholder="Search Job" aria-label="Search" name="searchJob">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
<?php
}
?>        
      </div>
    </nav>

    <div class="container pt-5">
      <div class="pb-2 mt-4 mb-2 border-bottom">
        <h1>Hello, <?php echo ' '.$_SESSION['fname'].'!';?></h1>
      </div>
<?php
	if($_SESSION['usercode'] == "1"){	
		if($checkRows <= 0){
			
echo <<<_END
<div class="row">
<form action="jobview.php?postId=$postId" method="post" class="text-center" style="padding-left: 15px;">
<button name="applied" type="submit" value="applied" class="btn btn-outline-primary">Apply To This Job</button><br><br>
</form>
</div>
_END;
		}
		else
			echo '<p class="text-success h5">*Thank you for your application*</p>';
	}

?>

	  <div class="row" style="padding-top: 0px; padding-bottom: 30px;">
<?php
/*
	if($_SESSION['usercode'] == "1"){	
		if($checkRows <= 0){
			
echo <<<_END
<div class="row>
<form action="jobview.php" method="post" class="text-center">
<button name="applied" value="applied" class="btn btn-outline-success">Apply To This Job</button><br><br>
</form>
</div>
_END;
		}
	}
*/


	/*
	$jobViewResult->data_seek(0);
    $jobViewRow = $jobViewResult->fetch_array(MYSQLI_NUM);
    $formatDesc = preg_replace('/\v+|\\\r\\\n/','<br/>',$jobViewRow[2]);
	*/

echo <<<_END
	<div class="col-md-7 text-left">
	<p class="h2">$jobViewRow[0]</p>
	<p class="h4">$jobViewRow[1]</p>
	<p class="h6">Location: $jobViewRow[4], $jobViewRow[3]</p>
	<br>
	<p class="h6" style="margin-bottom: 30px;">$formatDesc</p>
	</div>
_END;
?>
<?php
if($_SESSION['usercode'] == "2"){

	$tableQuery = "SELECT fname, lname, email, resumeId, userId FROM Job_applications WHERE postId ='$postId'";
	$tableResult = $conn->query($tableQuery);

	if (!$tableResult) die($conn->error);

	$tableRows = $tableResult->num_rows;

?>
	<div class="col-md-5">
		<p class="h2">Job Applicants</p>
		<table class="table table-striped" style="padding-left: 0px; padding-right: 0px;">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
		      <th scope="col">First</th>
		      <th scope="col">Last</th>
		      <th scope="col">Email</th>
		      <th scope="col">Resume</th>
		    </tr>
		  </thead>
		  <tbody>

<?php
	
	for($i = 0; $i < $tableRows; $i++){

		$tableResult->data_seek($i);
    	$tableRow = $tableResult->fetch_array(MYSQLI_NUM);
    	$num = $i+1;
    	$userIdForResume = $tableRow[4];

		echo <<<_END
		<tr>
		<th scope="col">$num</th>
		<td>$tableRow[0]</td>
		<td>$tableRow[1]</td>
		<td>$tableRow[2]</td>
		<td>
        <form action="showfile.php" method="get" class="text-center" style="max-height: 40px;">
          <button name="id" value="$userIdForResume" class="btn btn-outline-info">Download</button><br><br>
        </form>
		</td>
		</tr>
_END;
	}


?>

<!--		    <tr>
		      <th scope="row">1</th>
		      <td>Mark</td>
		      <td>Otto</td>
		      <td>@mdo</td>
		    </tr>
		    <tr>
		      <th scope="row">2</th>
		      <td>Jacob</td>
		      <td>Thornton</td>
		      <td>@fat</td>
		    </tr>
		    <tr>
		      <th scope="row">3</th>
		      <td>Larry</td>
		      <td>the Bird</td>
		      <td>@twitter</td>
		    </tr>-->
		  </tbody>
		</table>
	</div>


<?php
}
?>	
	  </div>
	</div>    


</body>
</html>