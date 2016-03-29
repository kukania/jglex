<?php header("Content-Type:text/html;charset=utf-8");?>
<?php
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}   
   $table_num=$_GET['tableNum'];
   $check=$_GET['check'];//현금:0 or 카드:1
   echo $check."<br>";
   $complete=$_GET['complete'];
   $price=$_GET['money'];
   $sql="select ";
   for($i=1;$i<=20;$i++)
   {
      $sql.="menu".$i.",";
   }
   $sql=substr($sql,0,-1);
   $sql.=" from order_info where table_num=".$table_num."&&cash_ok=0 ";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       for($i=1;$i<=20;$i++)
       {
          $menu[$i]=$row["menu".$i];
       }
    }
} else {
    echo "01 results<br>";
}


  $sql="select menu1 from calculate_info where date=date_format(now(),'%Y-%m-%d')";
  $result = $conn->query($sql);
   if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      $aaa=$row['menu1'];
    }
} else {
    echo "02 results<br>";
}
  if($aaa==NULL)
  {
    $sql="insert calculate_info (date,cash,card";
    for($i=1;$i<=20;$i++)
    {
      $sql.=",menu".$i;
    }
    $sql.=") values (now(),0,0";
    for($i=1;$i<=20;$i++)
    {
      $sql.=',0';
    }
    $sql.=")";
    mysqli_query($conn, $sql);
  }



  if($check==0)
  {
    $sql="update calculate_info set cash=cash+".$price." where date=date_format(now(),'%Y-%m-%d')";
    mysqli_query($conn, $sql);
  }
  else
  {
    $sql="update calculate_info set card=card+".$price." where date=date_format(now(),'%Y-%m-%d')";
    mysqli_query($conn, $sql);
  }
  if($complete==1)
  { $sql="update order_info set cash_ok=1 where table_num=".$table_num;
   if (mysqli_query($conn, $sql)) {
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
   $sql="update calculate_info set ";
   for($i=1;$i<=20;$i++)
   {
      $sql.="menu".$i."="."menu".$i."+".$menu[$i].',';
   }
   $sql=substr($sql,0,-1);
   $sql.=" where date=date_format(now(),'%Y-%m-%d')";
   if (mysqli_query($conn, $sql)) {
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}


}

  mysqli_close($conn);
?>