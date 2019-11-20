<html>
<head>
    <title>OnCrack</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<ul class="topnav">
  <li><a class="active" href="http://fishtagram.it/home.php">New Fish</a></li>
  <li><a href="http://fishtagram.it/globale.php">Sfide</a></li>
  <li><a href="http://fishtagram.it/commitprofile.php">Profilo</a></li>
  <li class="right"><a href="http://fishtagram.it/login.php">logout</a></li>
</ul>


<div style="padding:0 16px;">

</div>

</body>
</html>

<?php
session_start();
if(!$_SESSION['auth'])
{
  header('location:login.php');
}
else{
include('connection.php');
$username = $_SESSION['username'];
if(isset($_POST['submit'])){
  
  $namegroup = $_POST['namegroups'];
  $_SESSION['namegroup'] = $namegroup;
  header('location:sfidecreator.php');
}
}
 ?>



<html>
<head>

<title>Ricerca:</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="header">
    <h1><p align="center">crea nuova sfida</p></h1>
  </div>

<form method="post" action="insertname.php">
<table>
<tr><td>nome sfida:</td>
<td><input type="text" name="namegroups"></td></tr>
<tr><td><input type="submit" name="submit" value="next"style="font-size:12pt;color:white;
background-color:#008CBA;" ></td></tr>
</table>
</form>
</body>
</html>
