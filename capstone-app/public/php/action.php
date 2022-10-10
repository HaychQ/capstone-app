<?php
  session_start();
  $_SESSION['USER'] = 0;


  //////////////////////////////////////////////////////////////////////////////
  // connect to the db
  //////////////////////////////////////////////////////////////////////////////
  $database = new mysqli(
                              "localhost",
                              "postgres",
                              "Group4CapstoneProject",
                              "GroupProject") or die("Connection to database failed: " . $database->connect_error);


  //////////////////////////////////////////////////////////////////////////////
  // event handling
  //////////////////////////////////////////////////////////////////////////////
  if (isset($_POST['new_user'])) {

      // gathered data
      $key = htmlspecialchars(stripslashes(trim($_POST['key'])));
      $username = htmlspecialchars(stripslashes(trim($_POST['username'])));
      $password = htmlspecialchars(stripslashes(trim($_POST['password'])));

      // upload new user
      $sql = "INSERT INTO (key, username, password) VALUES ('".$key."', '".$username."', '".$password."');";
      $query = mysqli_query($database, $sql);
      if (!$query) {
          echo mysqli_error($database);
          return false;
      }
      else header("location: ../index.php");

  }
  if (isset($_POST['new_login'])) {

      // gather data
      $username = htmlspecialchars(stripslashes(trim(($_POST['username']))));
      $password = htmlspecialchars(stripslashes(trim(($_POST['password']))));

      // query db
      $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
      $query = mysqli_query($_SESSION['db'], $sql);
      if (!$query) {
          echo mysqli_error($database);
          return false;
      }
      else if (mysqli_num_rows($query) == 0 || mysqli_num_rows($query) > 1) {
          echo "There was an unexpected error with your credentials.";
      }
      else {

          // set user
          while ($data = mysqli_fetch_assoc($query))  {
            $_SESSION['USER'] = "{$data['apiKey']}";
          }



          header("location: ../index.php");
      }

  }


 ?>
