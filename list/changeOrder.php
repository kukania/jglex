<?php
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}	
	$length=$_GET['length'];
	for($i=1;$i<=20;$i++)
	{
		$a[$i]=0;
	}
	for($i=0; $i<$length;$i++)
	{
		/*$manuC='manu'.$i;
		$manyC='many'.$i;
		$manu=$_POST[$manuC];
		echo $manu;
		$many=$_POST[$manyC];
		echo $many;
		echo "<br>";*/
		$manuC='manu'.$i;
		$manyC='many'.$i;
		$manu=$_POST[$manuC];
		$many=$_POST[$manyC];
		$a[substr($manu,-1)]=$many;
	}
	//update order_info menu'$manu'=$many where ip=$ip;
	$sql="update order_info set "
	for($i=0;$i<$length;$i++)
	{
		$sql.="menu".$i.'='$a[$i].',';
	}
	$sql=substr($sql,0,-1);
	$sql.="where ip=".$ip;
	echo $sql;
	if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
	mysqli_close($conn);
?>