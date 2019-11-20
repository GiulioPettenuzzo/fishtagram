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
if(!$_SESSION['auth'])
{

  header('location:login.php');
}
else {
include('connection.php');
  ini_set('mysql.connect_timeout', 3000);
  ini_set('default_socket_timeout', 3000);
  if(isset($_POST['sumit'])) {

      $titre = mysql_real_escape_string(strip_tags($_POST['name']));
      $annee = mysql_real_escape_string(strip_tags($_POST['dimension']));
      // $picture_tmp = $_FILES['img']['tmp_name'];
      $picture_name = $_FILES['image']['name'];
      $picture_type = addslashes($_FILES['image']['type']);
      $image = addslashes($_FILES['image']['tmp_name']);
      $name = addslashes($_FILES['image']['name']);

      $id = $_SESSION['id'];

      $image = file_get_contents($image);
      $image = base64_encode($image);


      $allowed_type = array('image/png', 'image/gif', 'image/jpg', 'image/jpeg');

      if(in_array($picture_type, $allowed_type)) {
          $path = 'upload/'.$picture_name;
        }
        else {
          $error[] = 'File type not allowed';
        }

        if(!is_numeric($annee)) {
          $error[] = $annee.' is not a number';
        }

        if(!empty($error)) {
          echo '<font color="red">';

        }
    else if(empty($error)) {
        $req="INSERT INTO `fish` (`name`, `dimension`, `photo`,`user`)  VALUES ('$titre', '$annee', '$image','$id')";
        move_uploaded_file($image, $path);


        $fishphoto = mysql_query($req);
        if(! $fishphoto ) {
           die('Could not get data: ' . mysql_error());
        }
      //  echo $picture_type;

        }
        if (isset($_POST['field'])){
          foreach($_POST['field'] as $selected){
            echo $selected."</br>";
            //query for reaching the fish id
            $sqlfish = "SELECT id FROM fish WHERE name='$titre' AND dimension='$annee' AND user='$id'";
            $queryfish = mysql_query($sqlfish);
            if(! $queryfish ) {
               die('Could not get data: ' . mysql_error());
            }
            $rowfish = mysql_fetch_Array($queryfish);
            //query for reaching the group id
            $sqlgroup = "SELECT id FROM groups WHERE name = '$selected'";
            $querygroup = mysql_query($sqlgroup);
            if(! $querygroup) {
               die('Could not get data: ' . mysql_error());
            }
            $rowgroup = mysql_fetch_Array($querygroup);
            //insert the value itno groupfish
            $idgroup = $rowgroup[0];
            $idfish = $rowfish[0];
            $sql = "INSERT INTO `fishgroup` (`fish`, `group`) VALUES ('$idfish', '$idgroup')";
            $sqlquery = mysql_query($sql);
            if(! $sqlquery ) {
               die('Could not get data: ' . mysql_error());
            }
          }
        }
header("location:commitprofile.php");
      }
  }

?>
<html>
<head>
    <title>New Fish</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>

  <h1><p align="center">cos'hai catturato?</p></h1>

<html>
</html>


<form action="" method="post" enctype="multipart/form-data">
    <table>
     <tr>
        <td><strong>nome pesce</strong></td>
        <td><input name="name" type="text"></td>
     </tr> <tr>
        <td><strong>dimensione</strong></td>
        <td><input name="dimension" type="number"></td>
     </tr><tr>
        <td><strong>foto</strong></td>
     <td><input type="file" name="image"></td>
     </tr>
    </table>
    <h1><p align="center"><font size="4">a quali sfide desideri aggiungere questo nuovo elemento?</p></h1>
      <?php
      include("connection.php");
      if(!$_SESSION['auth'])
      {

        header('location:login.php');
      }
      else {
        $myid = $_SESSION['id'];
        $sqlcheck="SELECT name FROM groups WHERE user='$myid'";
        $result=mysql_query($sqlcheck);
        if(! $result ) {
           die('Could not get data: ' . mysql_error());
        }
        if(mysql_num_rows($result)!=0){

          echo "<form action=''>";
            while($row=mysql_fetch_Array($result)){

                echo "  <input id='option' type='checkbox' name='field[]' value=".$row[0]." style=' display          : inline-block;
                  width            : 0.875em;
                  height           : 0.875em;
                  margin           : 0.25em 0.5em 0.25em 0.25em;
                  border           : 0.0625em solid rgb(192,192,192);
                  border-radius    : 0.25em;'>";
                echo "<br>";
            }
          echo "</form>";

        }
      }
       ?>
    <div>
    <style>
    [type=checkbox]:after {
        content: attr(value);
        margin: -3px 15px;
        vertical-align: top;
        white-space:nowrap;
        display: inline-block;
    }
    [type=checkbox]:checked{
    	background: #26ca28;
    }
    </style>
    </div>
    <tr><br>
       <input type="submit" name="sumit" value="aggiungi" style="font-size:12pt;color:white;
 background-color:#008CBA;" </td>
    </tr>
</form>
</body>
</html>
