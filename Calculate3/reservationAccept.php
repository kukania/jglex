<?php
  date_default_timezone_set('Asia/Seoul');
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}
	$num_=$_GET['tableNum'];//필요 테이블
	$pk=$_GET['pk'];//체크할 키
	$sql="select table_num from reservationcheck";//이미 들어가 있는 예약
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
   	{
      	$num=0;
      	while($row = $result->fetch_assoc())
      	{
      		$table_num[$num]=$row['table_num'];//예약 테이블 수
        	$key[$num]=$row['order_key'];//예약 키
        	$num++;
      	}
   	}

	$sql="select * from order_info where id_num=".$pk;
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
   	{
      	while($row = $result->fetch_assoc())
      	{
      		$time=$row['time'];//시간
      		$name=$row['name'];//이름
      		$phone_number=$row['phone_number'];//번호
      		$number=$row['people'];//사람수
      		$menu="";
      		for($i=1;$i<=20;$i++)
      		{
      			$qwewq=$row['menu'.$i];
      			if($qwewq>0)
      				$menu.="menu".$i.":".$row['menu'.$i].",";
      		}
      		$menu=substr($menu, 0,-1);
      	}
   	}
   	for($i=0;$i<$num;$i++)
	{
		$sql="select time from order_info where id_num=".$key[$i];
		$result = $conn->query($sql);
		if ($result->num_rows > 0)
   		{
      		while($row = $result->fetch_assoc())
      		{
      			$time_[$i]=$row['time'];
      		}
   		}
	}
	$check=0;
	for($i=0;$i<$num;$i++)
	{
		if(strtotime($time)-strtotime($time_[$i])<=3600||strtotime($time)-strtotime($time_[$i])>=-3600)
		{
			$check+=$table_num[$i];
		}
	}
	if($check<=5-$num_)
	{
		$sql="insert into reservationcheck (table_num,name,phone_number,number,time,menu) values (".$num_.",'".$name."','".$phone_number."',".$number.",'".$time."','".$menu."')";
		mysqli_query($conn, $sql);
		echo $sql;
		$sql="delete from order_info where id_num=".$pk;
		mysqli_query($conn, $sql);
	}
	else
	{
		echo 0;
		$sql="delete from order_info where id_num=".$pk;
		mysqli_query($conn, $sql);
	}
	mysqli_close($conn);
?>