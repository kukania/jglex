<?php
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
	$abc='"';
	$ip=$_SERVER['REMOTE_ADDR'];
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}	
	$sql="delete from order_info where ip=".$abc.$ip.$abc;
	if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
	mysqli_close($conn);
?>