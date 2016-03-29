<?php
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}	
	$id_num$_POST['id_num'];
	$sql="update order_info set isok=1 where id_num=".$id_num;
	if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


 $conn->close();
?>