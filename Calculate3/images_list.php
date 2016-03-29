<?
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}   
 $sql= "select id, title, width, height from  images order by id DESC " ;
 $result=mysql_query($sql,$conn );
 $row=mysql_fetch_array($result);
 echo "<a href=test.php>그림 올리기</a>";
 echo( "<table bordr=1 width=90% align=center>
< tr> <td>이미지</td>
   <td>제목</td>
< /tr>
 ");
 
 while($row){
     echo ( "<tr><td><a href=view.html?id=$row[id]><img src=./view.html?id=$row[id]
 width=$row[width] height=$row[height] ></a></td>
< td>$row[title]</td> ");
   $row=mysql_fetch_array($result);
   }
   echo( "</table>");
?>