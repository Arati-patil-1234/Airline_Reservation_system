<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'airlines system') or die("could not connect to database");
$errors = array();
$p = 0;
if (isset($_POST['button'])) {

  $uname = mysqli_real_escape_string($db, $_POST['uname']);
  $password = mysqli_real_escape_string($db, $_POST['password']);

  $query = "SELECT * FROM users WHERE uname='$uname' AND password ='$password'";
  $results = mysqli_query($db, $query);
  if (mysqli_num_rows($results)) {
    if (isset($_SESSION['mesage'])) {
      $Time_ID = $_GET['Time_ID'];
      $Book = $_GET['Book'];
      $Day = $_GET['Day'];
      header("Location:booking.php?Book=$Book&Day=$Day&Time_ID=$Time_ID");
      unset($_SESSION['mesage']);
      $_SESSION['uname'] = $uname;
    } else {
      $_SESSION['uname'] = $uname;
      header("Location:index.php");
    }
  } else {
    array_push($errors, "Wrong user or password. Try again");
  }
}

if (isset($_POST['dbutton'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $query = "SELECT * FROM admin WHERE username='$username' AND password ='$password'";
  $results = mysqli_query($db, $query);
  if (mysqli_num_rows($results)) {
    header("Location:employeecrud.php");
  } else {
    array_push($errors, "Wrong user or password. Try again");
  }
}
if (isset($_POST['pbutton'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  $query = "SELECT * FROM admin WHERE username='$username' AND password ='$password'";
  $results = mysqli_query($db, $query);
  if (mysqli_num_rows($results)) {
    header("Location:eusersearch.php");
  } else {
    array_push($errors, "Wrong user or password. Try again");
  }
}

//logout
if (isset($_GET['homelogout'])) {
  session_destroy();
  unset($_SESSION['uname']);
  header("Location:index.php");
}
if (isset($_GET['searchlogout'])) {
  session_destroy();
  unset($_SESSION['uname']);
  header("Location:flightsearch.php");
}
if (isset($_SESSION['mesage'])) {
  array_push($errors, $_SESSION['mesage']);
}
