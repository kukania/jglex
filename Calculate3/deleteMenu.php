<?php header("Content-Type:text/html;charset=utf-8");?>
<?php
  date_default_timezone_set('Asia/Seoul');
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123;
	$dbname="dbjglex";
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}   
  $num=$_GET['num'];
  $sql="delete from menu where num=".$num;
  echo $sql."<br>";
  mysqli_query($conn, $sql);
  $sql="update menu set num=num-1 where num>".$num;
  echo $sql;
  mysqli_query($conn, $sql);
   mysqli_close($conn);
?>