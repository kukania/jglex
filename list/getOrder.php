<?php header("Content-Type:text/html;charset=utf-8");?>
<?php
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
	$abc="'";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}
	$length=$_GET['length'];
	$tablenum=$_GET['tableNum'];
	$sql_sl="select id_num from order_info where cash_ok=0&&check_ok=0&&table_num=".$tablenum;
	$result = $conn->query($sql_sl);
	if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
		$ack=$row["id_num"];
	}
}
	echo $ack;
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
		if($manu=="닭갈비 포장(생닭)")
			$a[1]=$many;
		else if($manu=="닭갈비 포장(조리된)")
			$a[2]=$many;
		else if($manu=="좋은 날엔 닭갈비")
			$a[3]=$many;
		else if($manu=="닭갈비+1")
			$a[4]=$many;
		else if($manu=="닭갈비 정식")
			$a[5]=$many;
		else if($manu=="허브 치킨가스")
			$a[6]=$many;
		else if($manu=="닭가슴살 냉채")
			$a[7]=$many;
		else if($manu=="어린이 치킨가스")
			$a[8]=$many;
		else if($manu=="모듬 사리")
			$a[9]=$many;
		else if($manu=="우동 사리")
			$a[10]=$many;
		else if($manu=="라면 사리")
			$a[11]=$many;
		else if($manu=="떡 사리")
			$a[12]=$many;
		else if($manu=="고구마 사리")
			$a[13]=$many;
		else if($manu=="볶음밥")
			$a[14]=$many;
		else if($manu=="공기밥")
			$a[15]=$many;
		else if($manu=="양배추 샐러드")
			$a[16]=$many;
		else if($manu=="소주/맥주")
			$a[17]=$many;
		else if($manu=="막걸리")
			$a[18]=$many;
		else if($manu=="청하")
			$a[19]=$many;
		else if($manu=="음료수")
			$a[20]=$many;
	}
	$price_sql="select price from menu";
	$result = $conn->query($price_sql);
	if ($result->num_rows > 0) {
		$j=1;
	    while($row = $result->fetch_assoc()) {
	    	$price[$j]=$row["price"];
	    	$j++;
	    }
	} else {
	    echo "0 results";
	}
	$tprice=0;
	for($i=1;$i<=20;$i++)
	{
		$tprice+=$a[$i]*$price[$i];
	}
	// echo $ack."<br>";
	if($ack==NULL)
	{	
		$sql = "INSERT INTO order_info (table_num,isok,price,";
		for($i=1; $i<=20;$i++)
		{
			$sql.="menu".$i.',';
		}
		$sql=substr($sql,0,-1);
		$sql.=",cash_ok,check_ok ) VALUES (";
		$sql.=$tablenum.",0,".$tprice.',';


		for($i=1;$i<=20;$i++)
		{
			$sql.=$a[$i].',';
			//echo $i.$a[$i]." ";
		}
		$sql=substr($sql,0,-1);
		$sql.=",0,0)";
	}
	else
	{
		$sql="update order_info set ";
		for($i=1;$i<=20;$i++)
		{
			$sql.="menu".$i."=menu".$i."+".$a[$i].',';
		}
		$sql.="price=price+".$tprice;
		$sql.=" where cash_ok=0&&check_ok=0&&table_num=".$tablenum;
	}
	// echo $sql;
	if (mysqli_query($conn, $sql)) {
	    echo "<script>location.href='index.html';</script>";
	} else {
	    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
	}

mysqli_close($conn);
?>