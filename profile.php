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
if (isset($_GET['submitt'])){
  $username = $_GET['submitt'];


  include('connection.php');

  $userquery = mysql_query("SELECT id FROM user WHERE name='$username'") or die ("La Query non è stata completata, riprova.");
  if (mysql_num_rows($userquery) != 1){
      die ("L'utente non esiste!");
  }
$row1 = mysql_fetch_array($userquery, MYSQL_NUM);
$id=$row1[0];

  $sql = "SELECT photo,name,dimension FROM fish WHERE user = '$id' ORDER BY date DESC";
  $retval = mysql_query( $sql, $conn );

  if(! $retval ) {
     die('Could not get data: ' . mysql_error());
  }
  else {
    echo "<html>
    <head>
    <meta charset='utf-8' />
      <link rel='stylesheet' href='liststyle.css'>
    </head>
    <body>
    <div class='table-title'>
<h3><font color='#666B85'>$username</font></h3>
</div>
<table class='table-fill'>
<thead>
<tr>
<th class='text-left'>Foto</th>
<th class='text-left'>Nome pesce</th>
<th class='text-left'>Dimensione</th>

</tr>
</thead>
<tbody class='table-hover'>
    ";
    while($row = mysql_fetch_array($retval, MYSQL_NUM)) {
        echo "
          <tr>
            <td><img height='100 width='100' src='data:image;base64,$row[0]'></td>
            <td><strong>PESCE : $row[1]   -  </strong></td>
            <td><strong>DIMENSIONE : $row[2] </strong>cm     </td>
          </tr>";
  }
  echo "</tbody>
  </table>
  </body>
  </html>";
}
}
 ?>
