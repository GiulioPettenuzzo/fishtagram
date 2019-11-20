<!DOCTYPE html>
<html>
<head>
    <title>fishtagram</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<ul class="topnav">
  <li><a class="active" href="#home">Register</a></li>

</ul>

<div style="padding:0 16px;">

</div>

</body>
</html>


<?php


  //connect to database
  include('connection.php');

  if(isset($_POST["register_btn"])){
    //session_start();
    $name = $_POST['username'];
    $surname = $_POST['usersurname'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    //composite the name
    $username = $name." ".$surname;
    if($password==$password2){
      $sqlcheck="SELECT * FROM user WHERE name='$username'";
      $result=mysql_query($sqlcheck);
      if(mysql_num_rows($result)!=0)
      {
        echo "spiacenti.. c'è gia un uttente con questo nome..";
      }
      else{
      $sql = "INSERT INTO user(name,password) VALUES('$username','$password')";
      if(mysql_query($sql)==true)
      {
        session_start();
        $_SESSION["message"] = "you are new logged in";
        $_SESSION["username"] = $username;
        $_SESSION['auth'] = 'true';
        $query2 = "SELECT id FROM user WHERE name='$username' AND password='$password'";
        $result2 = mysql_query($query2);
        $row=mysql_fetch_Array($result2);
        $id = $row[0];
        $_SESSION['id'] = $id;
        header("location: home.php");
      }
      else
      {
        echo "ops.. qualcosa è andato storto";
        $_SESSION['auth'] = 'false';
      }
    }

  }
}
else if(isset($_POST["log_in"]))
{
  header('location:login.php');
}
 ?>



<html>
<head>
    <p align="center"><title>Register, login and logout</title></p>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <h1><p align="center">deepfish</p></h1>
  </div>
<form method="post" action="registration.php">
  <table>
    <tr>
      <td>Nome:</td>
      <td><input type="text" name="username" class="textInput"</td>
    </tr>
    <tr>
      <td>Cognome:</td>
      <td><input type="text" name="usersurname" class="textInput"</td>
    </tr>
    <tr>
      <td>Password:</td>
      <td><input type="password" name="password" class="textInput"</td>
    </tr>
    <tr>
      <td>Password again:</td>
      <td><input type="password" name="password2" class="textInput"</td>
    </tr>
  </table>
<p align="center">
  <table>

    <tr>
      <td><input type="submit" name="register_btn" value="Register" style="font-size:12pt;color:white;
background-color:#008CBA;" </td>

      <td><input type="submit" name="log_in" value="return to log-in" style="font-size:12pt;color:white;
background-color:#008CBA;" </td>
    </tr>

  </table>
  </p>
</form>
</body>
</html>
