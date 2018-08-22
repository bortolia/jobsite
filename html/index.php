<?php
  require_once "login.php";
  session_start();
  if(!isset($_SESSION['email'])){
    header('location: signin.php');
  }
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);
?>

<?php
  $userId = $_SESSION['userId'];
  $uploadQuery = "SELECT * FROM Resume WHERE userId = '$userId'";
  $uploadResult = $conn->query($uploadQuery);
  $rows = $uploadResult->num_rows;
  $uploadResult->data_seek(0);
  $row = $uploadResult->fetch_array(MYSQLI_NUM);


?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title><?php echo $_SESSION['fname'] .' '.substr($_SESSION['lname'], 0, 1) ?> | Welcome to Jobsearch</title>
    <!--<link href="../css/signin.css" rel="stylesheet">-->
    <!--<script src="../js/signin.js" type="text/javascript"></script>-->

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
<?php
/*  if($_SESSION['usercode'] == "1"){
    echo <<<_END
          <li class="nav-item active">
            <a class="nav-link" href="http://bortolia.myweb.cs.uwindsor.ca/60334/project/html/logout.php">LO Upload resume</a>
          </li>
_END;
}*/
?>          
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
/*
  if($_SESSION['usercode'] == "1"){
    
?>        
        <form class="form-inline mt-2 mt-md-0" method="get" action="searchresult.php">
          <input class="form-control mr-sm-2" type="text" placeholder="Search Job" aria-label="Search" name="searchJob">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
<?php
    
  }
  */
?>        
      </div>
    </nav>

    <div class="container pt-5">
      <div class="pb-2 mt-4 mb-2 border-bottom">
        <h1>Hello, <?php echo ' '.$_SESSION['fname'].'!';?></h1>
      </div>

<?php
  if($_SESSION['usercode'] == "1"){
?>
      <div id="theCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
          <li data-target="#theCarousel" data-slide-to="0" class="acive"></li>
          <li data-target="#theCarousel" data-slide-to="1"></li>
        </ol>

        <!-- The slideshow -->
        <div class="carousel-inner">
          <div class="carousel-item active">
          <img src="../pictures/carousel1.jpeg" alt="Job picture 1" class="img-fluid">             
          <div class="carousel-caption">
              <h1 class="d-none d-sm-block">Upload and update resume</h1>
              <h5 class="d-block d-sm-none">Upload and update resume</h5>
              Start the job search below
              <!--<p class="d-none d-sm-block"><a href="https://www.youtube.com/" class="btn btn-danger">Youtube</a></p>-->
            </div>
          </div>
          <div class="carousel-item">
            <img src="../pictures/carousel3.jpeg" alt="Job picture 2" class="img-fluid">
            <div class="carousel-caption">
              <h1 class="d-none d-sm-block">Test Slide 2</h1>
              <h5 class="d-block d-sm-none">Test Slide 2</h5>
              It works
            </div>
          </div>
        </div>

        <a href="#theCarousel" class="carousel-control-prev" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <span class="sr-only">Previous</span>
        </a>

        <a href="#theCarousel" class="carousel-control-next" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <span class="sr-only">Next</span>
        </a>
      </div>

<?php
} //line 92, restricting for recruiter view
?>

      <div class="jumbotron" <?php if($_SESSION['usercode'] == "2") echo 'style ="padding-top: 25px; padding-bottom: 25px;"';?>>
<?php

if($_SESSION['usercode'] == "1"){//restricting for recruiter view
  if(!$uploadResult || $rows<=0){
    echo <<<_END
    <div class="row">
    <div class="col-12 col-md-6"
        <p><strong>Let's begin with you uploading your current resume.</strong></p>
        <p><strong>With a resume attached to your account, you can easily apply to any job offer on the site.</strong></p>
        <br>
    </div>
    <div class="col-12 col-md-6">
  <form action="index.php" method="post" enctype="multipart/form-data">
    <div class="text-center">
    Select File < 2mb:<br>(Only .pdf, .doc, .docx) <br><input type='file' class="btn btn-primary my-2 my-sm-0" name='filename' style="width: 300px">
    <button class="btn btn-outline-info my-2 my-sm-0" type="submit" name="submit">Upload</button>
    </div>
    </div>
  </form>      
  </div>
_END;
  }

  else{
    echo <<<_END
    
      <form action="searchresult.php" method="get" class="offset-md-2">
      <div class="form-row align-items-center">
        <div class="col-8">
          <label for="searchJob" class="sr-only">Seach Jobs</label>
          <input type="text" class="form-control mb-2" placeholder="Search job description, city, company..." name="searchJob" id="searchJob">
        </div>
        <div class="col-2">
          <button type="submit" class="btn btn-primary mb-2">Submit</button>
        </div>
      </div>
      </form>  
    <br>
    <div class="row">
    <div class="col-12 col-md-6"    
        <p><strong>If you ever need to update your resume, do it here!</strong></p>
        <p><strong>Having your resume up to date is quick, easy, and the best way to catch an employers attention.</strong></p>
        
        <form action="showfile.php" method="get" class="text-center">
          <button name="id" value="$userId" class="btn btn-outline-info">Download Current Resume</button><br><br>
        </form>
    </div>
    <div class="col-12 col-md-6">        
  <form action="index.php" method="post" enctype="multipart/form-data">
    <div class="text-center">
    Update Resume < 2mb:<br>(Only .pdf, .doc, .docx) <br><input type='file' class="btn btn-success my-2 my-sm-0" name='ufilename' style="width: 300px">
    <button class="btn btn-outline-success my-2 my-sm-0" name="update" type="submit">Update</button>
    </div>
    </div>
  </form> 
  </div>     
_END;

  }

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
          if(!$insertStmt->error){
            echo '<p class="text-center text-success"><strong>Uploaded resume to database</strong></p>';
          
          ?>
          <script>window.location.href ='index.php';</script>
          <?php
          }else
            echo '<p class="text-center text-danger"><strong>'.$insertStmt->error.'</strong></p>';
          
    }
    else echo '<p class="text-center text-danger"><strong>Wrong filetype or file was over 2mb.</strong></p>';
  }

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
            echo '<p class="text-center text-primary"><strong>Updated resume on database</strong></p>';
          else
            echo '<p class="text-center text-danger"><strong>'.$updateStmt->error.'</strong></p>';
          
    }
    else echo '<p class="text-center text-danger"><strong>Wrong filetype or file was over 2mb.</strong></p>';
  }

}//line 140, restricting jumbotron for recruiter view
elseif($_SESSION['usercode'] == "2"){
?>
  <div>
    <h3>New Posting</h3>

      <form method="post" id="newJobPost" action="index.php">
        <div class="form-group row">
          <label for="jobTitle" class="col-sm-2 col-form-label">Job Title</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="jobTitle" name="jobTitle" placeholder="Job Title" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="jobCompany" class="col-sm-2 col-form-label">Company</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="jobCompany" name="jobCompany" placeholder="Company" required>
          </div>
        </div>
        <div class="form-group row">
          <label for="selectProvince" class="col-sm-2 col-form-label">Province</label>
          <div class="col-sm-10">
            <select class="form-control" id="selectProvince" name="jobProvince" required>
              <option value="Alberta">Alberta</option>
              <option value="British Columbia">British Columbia</option>
              <option value="Manitoba">Manitoba</option>
              <option value="New Brunswick">New Brunswick</option>
              <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
              <option value="Northwest Territories">Northwest Territories</option>
              <option value="Nova Scotia">Nova Scotia</option>
              <option value="Nunavut">Nunavut</option>
              <option value="Ontario">Ontario</option>
              <option value="Prince Edward Island">Prince Edward Island</option>
              <option value="Quebec">Quebec</option>
              <option value="Saskatchewan">Saskatchewan</option>
              <option value="Yukon">Yukon</option>
            </select>
          </div>
        </div>
        <div class="form-group row">
          <label for="jobCity" class="col-sm-2 col-form-label">City</label>
          <div class="col-sm-10">
            <input type="text" class="form-control" id="jobCity" name="jobCity" placeholder="City" required>
          </div>
        </div>        
        <div class="form-group row">
          <label for="jobDescription" class="col-sm-2 col-form-label">Job Description</label>
          <div class="col-sm-10">
            <textarea class="form-control" id="jobDescription" name="jobDescription" rows="8" placeholder="Job Description" form="newJobPost" required></textarea>
          </div>
        </div>
<!--        <fieldset class="form-group">
          <div class="row">
            <legend class="col-form-label col-sm-2 pt-0">Radios</legend>
            <div class="col-sm-10">
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked>
                <label class="form-check-label" for="gridRadios1">
                  First radio
                </label>
              </div>
              <div class="form-check">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                <label class="form-check-label" for="gridRadios2">
                  Second radio
                </label>
              </div>
              <div class="form-check disabled">
                <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios3" value="option3" disabled>
                <label class="form-check-label" for="gridRadios3">
                  Third disabled radio
                </label>
              </div>
            </div>
          </div>
        </fieldset>
        <div class="form-group row">
          <div class="col-sm-2">Checkbox</div>
          <div class="col-sm-10">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="gridCheck1">
              <label class="form-check-label" for="gridCheck1">
                Example checkbox
              </label>
            </div>
          </div>
        </div>-->
        <div class="form-group row text-center">
          <div class="col-sm-12">
            <button type="submit" class="btn btn-primary col-sm-4 col-md-2" name="jobSubmit">Post Job+</button>
          </div>
        </div>
      </form>    

  </div>
<?php

  if(isset($_POST['jobSubmit'])){

    $title = get_post($conn, 'jobTitle');
    $company = get_post($conn, 'jobCompany');
    $province = get_post($conn, 'jobProvince');
    $city = get_post($conn, 'jobCity');
    $desc = get_post($conn, 'jobDescription');
    //$userId is already set with _SESSION

    if(!empty($_POST['jobTitle']) && !empty($_POST['jobCompany']) && !empty($_POST['jobProvince']) && !empty($_POST['jobCity']) && !empty($_POST['jobDescription'])){

      $insertJobStmt = $conn->prepare("INSERT INTO Job_posting(title, company, description, province, city, userId) VALUES (?,?,?,?,?,?)");
      $insertJobStmt->bind_param("sssssi", $title, $company, $desc, $province, $city, $userId);
      $insertJobStmt->execute();

      if(!$insertJobStmt->error){
        echo '<p class="text-center text-success"><strong>Successfully uploaded. View your posting.</strong></p>';
      }
      else
        echo '<p class="text-center text-danger"><strong>'.$insertJobStmt->error.'</strong></p>';
    }
  }

}


?>
<!--        
        <form>
        <label for="theButtons" class="offset-md-4">Select a size:&nbsp&nbsp</label><div class="btn-group" id="theButtons">
          <button type="button" class="btn btn-danger btn-sm" id="1">Small</button>
          <button type="button" class="btn btn-danger btn-sm" id="2">Medium</button>
          <button type="button" class="btn btn-danger btn-sm" id="3">Large</button>
          <a href="https://www.google.ca/" class="btn btn-danger btn-sm">Google</a>
        </div>

          <div class="form-label-group">
            <input type="email" id="inputEmail" class="form-control mt-3 col-md-4 offset-md-4" placeholder="Email address" required autofocus>
            <label for="inputEmail" class="col-md-4 offset-md-4">Email address</label>
          </div>

          <input type="submit" name="Submit" class="btn btn-primary btn-lg offset-md-5 col-md-2">
        </form>
-->
      </div>

<?php
  if($_SESSION['usercode'] == "2"){

    echo <<<_END
      <div class="pb-2 mt-4 mb-2 border-bottom">
        <h2>View Your Job Postings</h2>
      </div>
_END;

?>
  <div class="row" style="padding-top: 30px; padding-bottom: 30px;">
    
<?php
  
  $currentPosts = "SELECT title, company, postId FROM Job_posting WHERE userId = '$userId'";
  $currentResult = $conn->query($currentPosts);
  if (!$currentResult) die($conn->error);

  $currRows = $currentResult->num_rows;
  for($j = 0 ; $j < $currRows ; $j++){
    echo '<div class="col-sm-4 text-center" style="
    padding-bottom: 20px;">';
    $currentResult->data_seek($j);
    $currRow = $currentResult->fetch_array(MYSQLI_NUM);

    echo '<a href="jobview.php?postId='.$currRow[2].'">';
    echo '<p class="h2">'.$currRow[0].'</p>';
    echo '<p class="h4">'.$currRow[1].'</p>';
    echo '</a>';
    echo '</div>';

  }

?>    
  </div>

<?php


  }
?>

<!-- OLD TEST COLUMNS
      <div class="row">
        
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <h4>Column 1</h4>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.
          <br><br>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <h4>Column 2</h4>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.
          <br><br>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <h4>Column 3</h4>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
          <br><br>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <h4>Column 4</h4>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.
          <br><br>
        </div> 
      <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12 d-block d-sm-none">
          <h4>Column 5 SECRET</h4>
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. In pellentesque massa placerat duis.
          <br><br>
        </div>              
      </div>
-->      
    </div>
<?php
    function get_post($conn, $var){
      return $conn->real_escape_string($_POST[$var]);
    }
?>


  </body>
</html>
