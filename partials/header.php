<?php
session_start();
echo '
<nav class="navbar navbar-expand-lg bg-dark mx=-1">
  <div class="container-fluid">
    <a class="navbar-brand text-white" href="index.php">Navbar scroll</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
        <li class="nav-item">
          <a class="nav-link active text-white" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="aboutus.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled text-white" href="contactus.php">Contact</a>
        </li>
      </ul>
      <div class="  mx-2 ">';
      if(isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true)
      {
        echo '<div class="flex row">
        <p class="text-light my-0 mx-2">Welcome '. $_SESSION['useremail']. ' </p>
        <a href="partials/logout.php" class="btn btn-outline-success text-white" >LOGOUT</a></div>';

      }
      else
      {
        echo'<button class="btn btn-outline-success text-white " data-bs-toggle="modal" data-bs-target="#loginmodal">Login</button>
        <button class="btn btn-outline-success text-white" data-bs-toggle="modal" data-bs-target="#signupmodal">Signup</button>';
      }
      echo'  
      </div>
    </div>
  </div>
</nav>';
  include 'partials/loginmodal.php';
  include 'partials/signupmodal.php';
  if(isset($_GET['signupsuccess'])&&$_GET['signupsuccess']=="true")
  {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
          <strong>Success!</strong> You can now login.
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
  }
  

?>