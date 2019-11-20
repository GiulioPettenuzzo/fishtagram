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


<div style="padding:0 16px;">

</div>

</body>
</html>

<?php
include('connection.php');
session_start();
if(!$_SESSION['auth'])
{
  header('location:login.php');
}
else {

 if(!empty($_SESSION['userarray'])){
   $array=$_SESSION['userarray'];
 }
 else {
   $array = array();
 }
if(isset($_POST["add"])){
  //session_start();
  $name = $_POST['name'];
  $surname = $_POST['surname'];
  $username = $name." ".$surname;

  //for debug
  //array_push($array,$username);
  //echo array_pop($array);


  $sqlcheck="SELECT * FROM user WHERE name='$username'";
  $result=mysql_query($sqlcheck);
  if(mysql_num_rows($result)!=0)
  {
    if(!in_array($username,$array)){
    array_push($array,$username);
    $_SESSION['userarray'] = $array;
    //echo print_r($array);
    //  while(!empty($array)){
    //    $currentname = array_pop($array);
    //    echo "<h1><strong><p align='center'>$currentname</p></strong></h1><br>";
    //    array_push($array,$currentname);
    //  }
     for($i=0;$i<count($array);$i++){
       $currentname = $array[$i];
       echo "<h1><strong><p align='center'>$currentname</p></strong></h1><br>";
     }
  }
  else {
      echo "<h1><strong><p align='center'>'utente gia inserito'</p></strong></h1><br>";
  }
  }
  else {
    echo "spiacenti, l'utente cercato non è iscritto al sito";
  }
}
else if(isset($_POST['create'])){
  $id = $_SESSION['id'];
  $nomegruppo = $_SESSION['namegroup'];
  $query = "INSERT INTO groups(name,user) VALUES ('$nomegruppo','$id')";
  mysql_query($query);

  for($i=0;$i<count($array);$i++){
    $currentuser = $array[$i];
    $getid = "SELECT id FROM user WHERE name='$currentuser'";
    $current = mysql_query($getid);
    if(! $current ) {
       die('Could not get data: ' . mysql_error());
    }
    $row=mysql_fetch_Array($current);
    $currentid = $row[0];
    $queryuser = "INSERT INTO groups(name,user) VALUES ('$nomegruppo','$currentid')";
    $fine = mysql_query($queryuser);
    if(! $fine ) {
       die('Could not get data: ' . mysql_error());
    }

    $_SESSION['userarray']=array();
  }
  header('location:globale.php');
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
    <h1><p align="center">aggiungi membro...</p></h1>
  </div>

<form method="post" action="sfidecreator.php">
<table>
  <tr>
    <td>nome :</td>
    <td><input type="text" name="name" class="textInput"</td>
  </tr>
  <tr>
    <td>cognome :</td>
    <td><input type="text" name="surname" class="textInput"</td>
  </tr>
<tr><td><input type="submit" id="new" name="add" value="aggiungi"style="font-size:12pt;color:white;
background-color:#008CBA;" ></td>
<td><input type="submit" id="new" name="create" value="crea sfida"style="font-size:12pt;color:white;
background-color:#008CBA;" ></td>
</tr>

</table>
</form>
</body>
</html>
