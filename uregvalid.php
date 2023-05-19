<?php

session_start();
$errors = array();
add_into_database();
function add_into_database()
{
  $db = mysqli_connect('localhost', 'root', '', 'airlines system') or die("could not connect to database");
  if (isset($_POST['signup'])) {
    $username = mysqli_real_escape_string($db, $_POST['name']);
    $uname = mysqli_real_escape_string($db, $_POST['uname']);
    $dob = mysqli_real_escape_string($db, $_POST['dob']);
    $eid = mysqli_real_escape_string($db, $_POST['eid']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $cpassword = mysqli_real_escape_string($db, $_POST['cpassword']);
    $checkuni = "SELECT * FROM us WHERE `uname`='$uname' OR `email`='$eid' LIMIT 1";
    $results = mysqli_query($db, $checkuni);
    $user = mysqli_fetch_assoc($results);
    $p = 0;
    if ($user) {
      if ($user['uname'] === $uname) {
        array_push($GLOBALS['errors'], "User already exists. Try Login");
        $p = 1;
      }
    }
    if ($password != $cpassword) {
      array_push($GLOBALS['errors'], "password doesn't match");
      $p = 1;
    }
    if ($p == 0) {
      $query = "INSERT INTO users (`name`,`uname`,`dob`,`email`,`password`)
           VALUES ('$username','$uname','$dob','$eid','$password')";
      mysqli_query($db, $query);
      $_SESSION['register'] = "Registered Sucessfully! Please Login.";
      sendmail();
      header("Location:signin.php");
    }
  }
}


// in progress
function sendmail()
{
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "railway pantry system";
  $headers = "MIME-Version: 1.0" . "\r\n";
  $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
  $headers .= 'From: irctc12102020@gmail.com' . "\r\n";
  $bodymsg = "registration Successfull!!";
  mail('our email', "Order Successfull!!", $bodymsg, $headers);
}
