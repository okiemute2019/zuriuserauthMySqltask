<?php

require_once "../config.php";

//register users
function registerUser($fullnames, $email, $password, $gender, $country){
    //create a connection variable using the db function in config.php
    $conn = db();
   //check if user with this email already exist in the database
    $selectquery = "SELECT * FROM students WHERE email = '$email';";
    $getrecord = mysqli_query($conn,$selectquery);

    if (mysqli_num_rows($getrecord) > 0){
      echo "User with this email already exists!";
    } else {
      $insertquery = "INSERT INTO students (full_names,country,email,gender,password) VALUES ('$fullnames','$country','$email','$gender','$password');";
      if (mysqli_query($conn,$insertquery)){
        echo "User Successfully Registered!";
        $loginlink = '../forms/login.html';
        echo "<br/><br/><a href=".$loginlink.">Back to Login</a>";
      } else {
        echo "Error: ".$insertquery."<br>".mysqli_error($conn);
        $loginlink = '../forms/login.html';
        echo "<br/><br/><a href=".$loginlink.">Back to Login</a>";
      }
    }
    mysqli_close($conn);
}


//login users
function loginUser($email, $password){

    //create a connection variable using the db function in config.php
    $conn = db();
    echo "<h1 style='color: red'> LOG ME IN (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    $selectquery = "SELECT * FROM students WHERE email = '$email' AND password = '$password';";

    if ($getrecord = mysqli_query($conn,$selectquery)){
      while ($row = mysqli_fetch_row($getrecord)) {
        //if it does, check if the password is the same with what is given
        //if true then set user session for the user and redirect to the dasbboard
        if($row[3] == $email && $row[5] == $password){
            session_start();
            $_SESSION['username'] = $row[1];
            $_SESSION['email'] = $row[3];
          }
      } // end of while for row check
            if(isset($_SESSION)){
              header('Location:../dashboard.php');
            } else {
              echo "Wrong username or password!";
              $loginlink = '../forms/login.html';
              echo "<br/><br/><a href=".$loginlink.">Back to Login</a>";
            }
    } else {
      $message = "User does not Exist!";
      echo $message;
      $loginlink = '../forms/login.html';
      echo "<br/><br/><a href=".$loginlink.">Back to Login</a>";
    }
    mysqli_close($conn);
}


function resetPassword($email, $password){
    //create a connection variable using the db function in config.php
    $conn = db();
    echo "<h1 style='color: red'>RESET YOUR PASSWORD (IMPLEMENT ME)</h1>";
    //open connection to the database and check if username exist in the database
    $selectquery = "SELECT * FROM students WHERE email = '$email'";
    $getrecord = mysqli_query($conn,$selectquery);
    //if it does, replace the password with $password given
    if (mysqli_num_rows($getrecord) > 0){
      $updatequery = "UPDATE students SET password = '$password' WHERE email = '$email';";
      if (mysqli_query($conn,$updatequery)){
      echo "Password reset successful!";
      $loginlink = '../forms/login.html';
      echo "<br/><br/><a href=".$loginlink.">Back to Login</a>";
      } else {
      echo "Error resetting Password: ".mysqli_error($conn);
      $loginlink = '../forms/login.html';
      echo "<br/><br/><a href=".$loginlink.">Back to Login</a>";
      }
    } else {
      echo "User does not Exist!";
      $loginlink = '../forms/login.html';
      echo "<br/><br/><a href=".$loginlink.">Back to Login</a>";
    }
    mysqli_close($conn);
}

function getusers(){
    $conn = db();
    $sql = "SELECT * FROM Students";
    $result = mysqli_query($conn, $sql);
    echo"<html>
    <head></head>
    <body>
    <center><h1><u> ZURI PHP STUDENTS </u> </h1>
    <table border='1' style='width: 700px; background-color: magenta; border-style: none'; >
    <tr style='height: 40px'><th>ID</th><th>Full Names</th> <th>Email</th> <th>Gender</th> <th>Country</th> <th>Action</th></tr>";

    if(mysqli_num_rows($result) > 0){
        while($data = mysqli_fetch_assoc($result)){
            //show data
            echo "<tr style='height: 30px; text-align: center'>".
                "<td style='width: 50px; background: blue'>" . $data['id'] . "</td>
                <td style='width: 150px'>" . $data['full_names'] .
                "</td> <td style='width: 150px'>" . $data['email'] .
                "</td> <td style='width: 150px'>" . $data['gender'] .
                "</td> <td style='width: 150px'>" . $data['country'] .
                "</td>".


                "<td style='width: 150px; padding-top: 10px'><form action='action.php' method='post'><input type='hidden' name='id'" .
                 "value=" . $data['id']. ">"." <button type='submit', name='delete'> DELETE </button></form></td>".
                "</tr>";
        }
        echo "</table><br /><a href='../dashboard.php'>Back</a></center></body></html>";
    }
    //return users from the database
    //loop through the users and display them on a table
}

 function deleteaccount($id){
     $conn = db();
     //delete user with the given id from the database
     //check if user with this email already exist in the database
      $deletequery = "DELETE FROM students WHERE id = $id;";

      if (mysqli_query($conn,$deletequery)){
        echo "User data deleted Successfully!";
        echo "<br /><a href='../dashboard.php'>Back</a>";
      } else {
        echo "Error: ".$deletequery."<br>".mysqli_error($conn);
        echo "<br /><a href='../dashboard.php'>Back</a>";
      }
      mysqli_close($conn);
 }
