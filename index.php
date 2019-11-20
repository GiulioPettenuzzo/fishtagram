<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
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
session_start();


   include('connection.php');

   if(! $conn ) {
      die('Could not connect: ' . mysql_error());
   }
   $group = "";
   $myid = $_SESSION['id'];

   $sqlcheck="SELECT name FROM groups WHERE user='$myid'";
   $result=mysql_query($sqlcheck);
   echo "<br>";
   echo "<form action='view.php' method='POST'>";
   echo "<strong>    LE TUE SFIDE :   </strong>";
   echo "<input type='submit' name='button' style='font-size:18pt;color:white;
   background-color:#008CBA;border:0px;' value='globale'>";
   echo " ";
   if(mysql_num_rows($result)!=0)
   {


       while($row=mysql_fetch_Array($result)){
       echo "<input type='submit' name='button' style='font-size:18pt;color:white;
 background-color:#008CBA;border:0px;' value=".$row[0].">";
      echo " ";

     }
   }
   echo "<input type='submit' name='button' style='font-size:18pt;color:white;
   background-color:#4CAF50;border:0px;' value='nuova sfida'>";
     echo "</form>";
     if(isset($_POST['button'])){
       $name = $_POST['button'];
    if($name == 'nuova sfida'){
        header("location:insertname.php");
      }}
   $sql = 'SELECT photo,name,dimension,user,date FROM fish ORDER BY date DESC';
   $retval = mysql_query( $sql, $conn );



   if(! $retval ) {
      die('Could not get data: ' . mysql_error());
   }
   else {
     $sqlfish = "SELECT user,sum(dimension) as dim FROM fish GROUP BY user ORDER BY dim DESC";
     $queryfish = mysql_query( $sqlfish, $conn );
     $sqlbigger = "SELECT name,max(dimension) FROM fish GROUP BY name";
     $querybigger = mysql_query($sqlbigger);


     //echo mysql_error($queryfish);

     echo "<html>
     <head>
     <meta charset='utf-8' />
     <div class='table-title'>
      <h1><strong><font color='#000000'><p align='center'>FISHTAGRAM SFIDA GLOBALE</p></strong></h1>
       <link rel='stylesheet' href='liststyle.css'></div>
     </head>
     <body>

<h1><p align='center'><font color='#666B85'>";$i=1;
while($rowfish = mysql_fetch_array($queryfish, MYSQL_NUM)){
  $id1 = $rowfish[0];
  $sql3 = "SELECT name FROM user WHERE id = '$id1'";
  $retval3 = mysql_query( $sql3, $conn );
  $row3 = mysql_fetch_array($retval3, MYSQL_NUM);
  $nome = $row3[0];
  echo $i.")  ";
  echo $nome."        ";
  echo $rowfish[1]."cm";
  $i++;
  echo "<br>";
}

echo"<br><p/></h1>";
echo "<h1><p align='center'>";
while($rowbigger = mysql_fetch_array($querybigger, MYSQL_NUM)){

     $dimensione = $rowbigger[1];
     $nomepesce = $rowbigger[0];
     $sqlselectuser = "SELECT user FROM fish WHERE dimension = $dimensione AND name = '$nomepesce'";
     $queryselectuser = mysql_query($sqlselectuser);
     if(! $queryselectuser ) {
        die('Could not get data: ' . mysql_error());
     }
     $rowselectuser = mysql_fetch_array($queryselectuser, MYSQL_NUM);

    $idbigger = $rowselectuser[0];
    $mysqluser = "SELECT name FROM user WHERE id = '$idbigger'";
    $retvaluser =  mysql_query( $mysqluser, $conn );
    $row4 = mysql_fetch_array($retvaluser, MYSQL_NUM);
    $nomepescatore = $row4[0];

    echo " - miglior ";
    echo $rowbigger[0].":  ";
    echo $rowbigger[1]."cm,  ";
    echo $nomepescatore."<br>";
}
echo
"</font></p></h1>

<table class='table-fill'>
<thead>
<tr>
<th class='text-left'>Foto</th>
<th class='text-left'>Nome pesce</th>
<th class='text-left'>Dimensione</th>
<th class='text-left'>Data&Ora</th>
<th class='text-left'>Pescatore</th>

</tr>
</thead>
<tbody class='table-hover'>
     ";
     while($row = mysql_fetch_array($retval, MYSQL_NUM)) {
       //recupero il nome utente
        $id = $row[3];
        $sql2 = "SELECT name FROM user WHERE id = '$id'";
        $retval1 = mysql_query( $sql2, $conn );
        $row2 = mysql_fetch_array($retval1, MYSQL_NUM);
        $nome = $row2[0];
         echo "


           <tr>

             <td><img height='130' width='130' src='data:image;base64,$row[0]'></td>
             <td><strong> $row[1]     </strong></td>
             <td><strong> $row[2] </strong>cm      </td>
             <td><strong> $row[4] </strong>      </td>
             <td><strong><form action='profile.php' method='GET'>
             <input type='submit' id='submitt' name='submitt' value='$row2[0]' class='submitlink' />

             </form></strong></td>

           </tr>";
   }
   echo "</tbody>
   </table>
   </body>
   </html>";
}



?>