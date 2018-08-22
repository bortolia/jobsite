<?php
  session_start();
  if(isset($_SESSION['email'])){
    header('location: index.php');
  }
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>Sign In | Welcome to Jobsearch</title>
    <link href="../css/signin.css" rel="stylesheet">
    <script src="../js/signin.js" type="text/javascript"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  </head>

  <body>

<?php    
  require_once 'login.php';
  $conn = new mysqli($hn, $un, $pw, $db);
  if ($conn->connect_error) die($conn->connect_error);

/*  $typeQuery = "SELECT user_code, user_description FROM User_codes";
  $resultType = $conn->query($typeQuery);
  if (!$resultType) die ("Database access failed: " . $conn->error);

  $rows = $resultType->num_rows;
*/
?>

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
            <a class="nav-link" href="http://bortolia.myweb.cs.uwindsor.ca/60334/project/html/signin.php">Login</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="http://bortolia.myweb.cs.uwindsor.ca/60334/project/html/signup.php">Sign Up</a>
          </li>
<!--
          <li class="nav-item">
            <a class="nav-link disabled" href="#">Disabled</a>
          </li>
-->
        </ul>
<!--        
        <form class="form-inline mt-2 mt-md-0">
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">Search</button>
        </form>
-->
      </div>
    </nav>

    <main role="main" class="container">
      <div class="row">
      <div class="col-12">

      <form class="form-signin text-center" action="signin.php" method="post">
        <img class="mb-3" src="../pictures/logo.png" alt="logo" width="276" height="72">
        <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
        <span style="color: rgb(217,83,79)"><strong><div class="mt-2" id="failure"></div></strong></span>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="Email address" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" name="password" class="form-control" placeholder="Password" required>
        <!--<div class="checkbox mb-3">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>-->
        <button class="btn btn-lg btn-primary btn-block" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
      </form>

      </div>
    </div>
  </main>

  <?php
    if (isset($_POST['email']) && isset($_POST['password'])) {
      
      $email = get_post($conn, 'email');
      $password = get_post($conn, 'password');
      $salted = 'kjhd98a9s0'.$password.'87atdg69';
      $hashed = hash('ripemd128',$salted);

    if (!empty($_POST['email']) && !empty($_POST['password'])) {

      $signInQuery = "SELECT email, password, fname, lname, usercode, userId FROM User_profiles WHERE email='$email' AND password='$hashed'";
      $result = $conn->query($signInQuery);
      $rows = $result->num_rows;
      $result->data_seek(0);
      $row = $result->fetch_array(MYSQLI_NUM);

      if(!$result || $rows<= 0){
        echo '<script>failureSignIn();</script>';
      }
      elseif ($row[0]==$email && $row[1]==$hashed){
        //MOVED THIS ABOVE TO BE DONE AFTER THE QUERY TO CHECK THAT THEY ARE == IN THIS IF-STATEMENT
        //$result->data_seek(0);
        //$row = $result->fetch_array(MYSQLI_NUM);
        
        //echo 'Welcome '. $row[0]." and ".$row[1];
        session_start();
        $_SESSION['email'] = $row[0];
        $_SESSION['hashed'] = $row[1];
        $_SESSION['fname'] = $row[2];
        $_SESSION['lname'] = $row[3];
        $_SESSION['usercode'] = $row[4];
        $_SESSION['userId'] = $row[5];

        ?>
        <script>window.location.href ='index.php';</script>
        <?php
      }
      
    }
    else 
      echo '<h4>nah</h4>';
  }
    $result->close();
    $conn->close(); 
    
    function get_post($conn, $var){
      return $conn->real_escape_string($_POST[$var]);
    }
  ?>

  </body>
</html>