<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Sign Up | Welcome to Jobsearch</title>
    <link href="../css/signup.css" rel="stylesheet">
    <script src="../js/signup.js" type="text/javascript"></script>
  </head>
  <body>

<div class="container">
  <div class="row">
<?php    
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

  $typeQuery = "SELECT user_code, user_description FROM User_codes";
  $resultType = $conn->query($typeQuery);
  if (!$resultType) die ("Database access failed: " . $conn->error);

  $rows = $resultType->num_rows;
?>


    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top mb-2">
      <a class="navbar-brand" href="#">
        <img src="../pictures/logo.png" alt="logo" width="115" height="30">
      </a>
    </nav>


    
      <div class="col-12">
        <form class="form-signin text-center" action="signup2.php" method="post">
          <img class="mb-2" src="../pictures/logo.png" alt="logo" width="276" height="72">
          <h1 class="h3 mb-3 font-weight-normal">Please sign up</h1>
          <span style="color: rgb(66,139,202)"><strong><div class="mt-2" id="success"></div></strong></span>
          <label for="inputFName" class="sr-only">firstName</label>
          <input type="text" id="inputFName" name="fname" class="form-control" placeholder="First name" required autofocus>
          <label for="inputLName" class="sr-only">lastName</label>
          <input type="text" id="inputLName" name="lname" class="form-control" placeholder="Last name" required>      
          <label for="inputEmail" class="sr-only">Email address</label>
          <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required>
          <label for="inputPassword" class="sr-only">Password</label>
          <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>

          <label for="formSelect">User type: </label>
          <select class="form-control" id="formSelect" name="usertype">
          <?php
            for($i = 0; $i < $rows; $i++){
              $resultType->data_seek($i);
              $row = $resultType->fetch_array(MYSQLI_NUM);
              echo "<option value=".$row[0].">".$row[1]."</option>"; //reads dynamically from database
            }
          ?>
          </select>

          <!--<div class="checkbox mb-3">
            <label>
              <input type="checkbox" value="remember-me"> Remember me
            </label>
          </div>-->
          <button class="btn btn-lg btn-primary btn-block mt-4" type="submit">Join</button>
          <p class="mt-4 mb-2 text-muted">&copy; 2017-2018</p>
        </form>
        </div>
      </div>
    </div>

<?php


  if (isset($_POST['fname'])  &&  
      isset($_POST['lname'])  &&  
      isset($_POST['usertype']) &&
      isset($_POST['email'])  &&
      isset($_POST['password']))
  {
    $fname = get_post($conn, 'fname');
    $lname = get_post($conn, 'lname');
    $usertype = get_post($conn, 'usertype');
    $email = get_post($conn, 'email');
    $password = get_post($conn, 'password');

    if(!empty($_POST['fname'])  &&
      !empty($_POST['lname']) &&
      !empty($_POST['usertype'])  &&
      !empty($_POST['email']) &&
      !empty($_POST['password']))
    {

//new insert statement with prepare implimentation
      $insertStmt = $conn->prepare("INSERT INTO User_profiles(fname, lname, usercode, email, password) VALUES (?,?,?,?,?)");
      $insertStmt->bind_param("sssss", $fname, $lname, $usertype, $email, $password);
      $insertStmt->execute();
      if(!$insertStmt->error){
        echo '<script>successSignUp();</script>';
        /*echo <<<_END
        <script>document.getElementById("success").innerHTML = "Success, login above.";</script>
_END;*/

/*
        echo <<<_END
        <div class="col-xl-12 text-center">
        <span style="color: rgb(66,139,202)"><p><strong>Success, login above.</strong></p></span>      
        </div>
_END;*/

      }

      else
        echo '<span style="color:red;">INSERT failed: '. $conn->error.'</span><br>';

    }
    else
      echo '<span style="color:red;">*Please fill all fields*</span>';

  }

?>

    <?php
  
      $resultType->close();
      $resultInsert->close();
      $conn->close();

    function get_post($conn, $var){
      return $conn->real_escape_string($_POST[$var]);
    }

    ?>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </body>
</html>