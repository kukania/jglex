<?php header("Content-Type:text/html;charset=utf-8");?>
<?php
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
   $abc='"';
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   
   if (!$conn)
   {
     die("Connection failed: " . mysqli_connect_error());
   }
   $length=$_GET['length'];
   $tablenum=$_GET['tableNum'];
   for($i=1;$i<=20;$i++)
      $a[$i]=0;
   for($i=0; $i<$length;$i++)
   {
      $manuC='manu'.$i;
      $manyC='many'.$i;
      $manu=$_POST[$manuC];
      $many=$_POST[$manyC];
      $a[substr($manu, 4)]=$many;//a[]->덮어씌울 값
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
   $sql="select ";
   for($i=1;$i<=20;$i++)
   {
      $sql.="menu".$i.",";
   }
   $sql=substr($sql,0,-1);
   $sql.=" from order_info where cash_ok=0&&table_num=".$tablenum;
   $result = $conn->query($sql);
   if ($result->num_rows > 0) 
   {
       while($row = $result->fetch_assoc()) {
         for($i=1;$i<=20;$i++)
         {
            $b[$i]=$row["menu".$i];//들어가 있는 값
            $c[$i]=$a[$i]-$b[$i];//차이
            $tprice+=$a[$i]*$price[$i];
         }
       }
   $sql="update order_info set ";
   for($i=1;$i<=20;$i++)
   {
       $sql.="menu".$i."=".$a[$i].",";
   }
   $sql.="price=".$tprice.",check_ok=1 where cash_ok=0&&table_num=".$tablenum;
   }
   else
   {
      $sql="INSERT INTO order_info (table_num,isok,price,";
      for($i=1; $i<=20;$i++)
      {
        $sql.="menu".$i.',';
        $tprice+=$a[$i]*$price[$i];
      }
      $sql.="cash_ok,check_ok) VALUES (".$tablenum.",0,".$tprice.",";
      for($i=1;$i<=20;$i++)
      {
        $sql.=$a[$i].",";
        $c[$i]=$a[$i];
      }
      $sql.="0,1)";
   }
   
   if (mysqli_query($conn, $sql)) {
   } else {
       echo "Error: " . $sql . "<br>" . mysqli_error($conn);
   }
    $valu["table"]=$tablenum;
    $valu["price"]=$tprice;
   for($i=1;$i<=20;$i++)
   {
      $valu["menu".$i]=$c[$i];
   }
   echo json_encode($valu);
   mysqli_close($conn);
?>