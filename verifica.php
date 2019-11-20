<!DOCTYPE html>
<html>
<head>
    <title>fishtagram</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<ul class="topnav">
  <li><a class="active" href="http://fishtagram.it/home.php">New Fish</a></li>
  <li><a href="http://fishtagram.it/globale.php">Sfide</a></li>
  <li><a href="http://fishtagram.it/commitprofile.php">Profilo</a></li>
  <li class="right"><a href="http://fishtagram.it/login.php">logout</a></li>
</ul>

</body>

</html>
<?php
session_start();
include('connection.php');
if(!$_SESSION['auth'])
{

  header('location:login.php');
}
else {
  if(isset($_POST['sumit'])){
    $name = $_POST['sumit'];
    $id =$_SESSION['id'];
    $group = $_SESSION['group'];
    if($name == 'si'){
      $sql = "DELETE FROM groups WHERE `user` = $id AND `name` ='$group'";
      $mysql = mysql_query($sql);
      if(! $mysql) {
         die('Could not get data: ' . mysql_error());
      }
      header("location:globale.php");
    }
    else if($name == 'no'){
      header("location:globale.php");
    }
  }
}
 ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>abbandono</title>
  </head>
  <body>
    <h1><p align="center"><font size="4">sicuro di voler abbandonare? non potrai piu rientrare..</p></h1>
    <form class="" action="verifica.php" method="post">
<p align="center">
      <input type="submit" name="sumit" value="no" style="font-size:12pt;color:white;
  background-color:#008CBA;" </td>
  <input type="submit" name="sumit" value="si" style="font-size:12pt;color:white;
  background-color:#008CBA;" </td></p>

    </form>

  </body>
</html>
