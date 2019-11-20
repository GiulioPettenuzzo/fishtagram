<!DOCTYPE html>
<html>
<head>
    <title>fishtagram</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<ul class="topnav">
  <li><a class="active" href="#home">log-in</a></li>


</ul>

<div style="padding:0 16px;">

</div>

</body>
</html>
<?php
$_SESSION['auth']='flase';
if(isset($_POST["register_btn"]))
{
  include('connection.php');
  $surname = $_POST['surname'];
  $name = $_POST['name'];
  $password = $_POST['password'];
  $username = $name." ".$surname;
  $query="SELECT * FROM user WHERE name='$username' AND password='$password'";
  $result=mysql_query($query);
  if(mysql_num_rows($result)==1)
  {
    session_start();
    $_SESSION['auth']='true';
    $_SESSION["username"] = $username;
    $query2 = "SELECT id FROM user WHERE name='$username' AND password='$password'";
    $result2 = mysql_query($query2);
    $row=mysql_fetch_Array($result2);
    $id = $row[0];
    $_SESSION['id'] = $id;
    header('location:home.php');
  }
  else
  {
    echo "username o password errati";
    $_SESSION['auth']='false';
  }
}
else if(isset($_POST["sing_up"]))
{
  header('location:registration.php');
}
 ?>

<html>
<head>
    <title>fishtagram</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="header">
  <h1><p align="center">fishtagram</p></h1>
</div>

<form method="post" action="login.php">
  <table>
    <tr>
      <td>nome :</td>
      <td><input type="text" name="name" class="textInput"</td>
    </tr>
    <tr>
      <td>cognome: </td>
      <td><input type="text" name="surname" class="textInput"</td>
    </tr>
    <tr>
      <td>Password:</td>
      <td><input type="password" name="password" class="textInput"</td>
    </tr>
  </table>
<p align="center">
  <table>
    <tr>
      <td><input type="submit" name="register_btn" value="log in" style="font-size:12pt;color:white;
background-color:#008CBA;" </td>

      <td><input type="submit" name="sing_up" value="register" style="font-size:12pt;color:white;
background-color:#008CBA;" </td>
    </tr>
  </table>
  </p>
</form>
</body>
</html>
