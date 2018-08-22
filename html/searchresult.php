<?php
  require_once "login.php";
  session_start();
  if(!isset($_SESSION['email'])){
    header('location: signin.php');
  }
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  $userId = $_SESSION['userId'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<title><?php echo $_SESSION['fname'] .' '.substr($_SESSION['lname'], 0, 1) ?> | Jobsearch</title>

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
<!--          
          <li class="nav-item">
            <a class="nav-link" href="http://bortolia.myweb.cs.uwindsor.ca/60334/project/html/signin.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://bortolia.myweb.cs.uwindsor.ca/60334/project/html/signup.php">Sign Up</a>
          </li>
-->          
          
          <li class="nav-item">
            <a class="nav-link" href="http://bortolia.myweb.cs.uwindsor.ca/60334/project/html/logout.php">Logout</a>
          </li>

<!--          
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
          </li>
-->          
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
        <h5>Your search returned <span id="number"></span> result(s).</h5>
        <h6>Search for "ALL" to return all postings.</h6>
      </div>

      <div class="row" style="padding-top: 30px; padding-bottom: 30px;">

<?php

if($_GET['searchJob'] === "ALL"){

	//$searchField = $_GET['searchJob'];
	//$searchArray = explode(" ", $searchField);
	//$length = count($searchArray);

	//$newString = "";

	//for($i = 0; $i < $length ; $i++){
	//	$newString .= $searchArray[$i]."* ";
	//}
	$zero = 0;
	$searchAllQuery = "SELECT title, company, description, province, city, postId FROM Job_posting WHERE postId > $zero";

	$searchAllResult = $conn->query($searchAllQuery);

	if (!$searchAllResult) die($conn->error);

	$searchAllRows = $searchAllResult->num_rows;
	echo '<script>document.getElementById("number").innerHTML = '.$searchAllRows.';</script>';

	for($k = 0; $k < $searchAllRows ; $k++){
		echo '<div class="col-sm-4 text-center">';
		$searchAllResult->data_seek($k);
    	$searchAllRow = $searchAllResult->fetch_array(MYSQLI_NUM);

	    echo '<a href="jobview.php?postId='.$searchAllRow[5].'">';
	    echo '<p class="h2">'.$searchAllRow[0].'</p>';
	    echo '<p class="h4">'.$searchAllRow[1].'</p>';
	    echo '<p class="h6" style="padding-bottom: 20px;">Location: '.$searchAllRow[4].', '.$searchAllRow[3].'</p>';
	    echo '</a>';
	    echo '</div>';

	}

}

elseif(isset($_GET['searchJob']) && $_GET['searchJob'] != "ALL"){

	$searchField = $_GET['searchJob'];
	$searchArray = explode(" ", $searchField);
	$length = count($searchArray);

	$newString = "";

	for($i = 0; $i < $length ; $i++){
		$newString .= $searchArray[$i]."* ";
	}

	$searchQuery = "SELECT title, company, description, province, city, postId FROM Job_posting WHERE MATCH(title, company, description, province, city) AGAINST('".$newString."' IN BOOLEAN MODE)";

	$searchResult = $conn->query($searchQuery);

	if (!$searchResult) die($conn->error);

	$searchRows = $searchResult->num_rows;
	echo '<script>document.getElementById("number").innerHTML = '.$searchRows.';</script>';

	for($j = 0; $j < $searchRows ; $j++){
		echo '<div class="col-sm-4 text-center">';
		$searchResult->data_seek($j);
    	$searchRow = $searchResult->fetch_array(MYSQLI_NUM);

	    echo '<a href="jobview.php?postId='.$searchRow[5].'">';
	    echo '<p class="h2">'.$searchRow[0].'</p>';
	    echo '<p class="h4">'.$searchRow[1].'</p>';
	    echo '<p class="h6" style="padding-bottom: 20px;">Location: '.$searchRow[4].', '.$searchRow[3].'</p>';
	    echo '</a>';
	    echo '</div>';

	}

}

?>
		</div>
	</div>

</body>
</html>