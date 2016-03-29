<?php
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
		$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}	
	$sql="insert into calculate_info (date,";
	for($i=1;$i<21;$i++)
	{
		$sql.="menu".$i.',';
	}
	$sql=substr($sql,0,-1);
	$sql.=') values ( now(),';
	for($i=0;$i<20;$i++)
	{
		$sql.='0,';
	}
	$sql=substr($sql,0,-1);
	$sql.=')';
	if (mysqli_query($conn, $sql)) {
		echo"<script>window.history.back();</script>";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>