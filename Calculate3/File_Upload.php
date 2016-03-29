<?php
// 4.1.0 이전의 PHP에서는, $_FILES 대신에 $HTTP_POST_FILES를
// 사용해야 합니다.
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}
$uploaddir = "imageFile\\";
$num=$_POST['num'];
$sql="select imagename_1, imagename_2, imagename_3 from menu where num=".$num;
$result_=$conn->query($sql);
$k=0;
// if($result_->num_rows>0)
// {
//   while($row=$result_->fetch_assoc())
//   {
//     for($i=1;$i<=3;$i++)
//     {
//       if($row["imagename_".$i]!=NULL)
//         unlink($row["imagename_".$i]);
//     }
//   }
// }

for($i=0;$i<1;$i++)
{
$uploadfile = $uploaddir.basename($_FILES['userfile']['name'][$i]);
echo $uploadfile."<br>";
echo $_FILES['userfile']['tmp_name'][$i]."<br>";
echo '<pre>';
if (move_uploaded_file($_FILES['userfile']['tmp_name'][$i], $uploadfile)) {
    echo "파일이 유효하고, 성공적으로 업로드 되었습니다.\n";
} else {
    print "파일 업로드 공격의 가능성이 있습니다!\n";
}
	$sql="update menu set imagename_".($i+1)."= '".basename($_FILES['userfile']['name'][$i])."' where num=".$num;
	echo $sql."<br>";
	mysqli_query($conn, $sql);

}
echo '자세한 디버깅 정보입니다:';
print_r($_FILES);
print "</pre>";
	
?>