<?php
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
   $abc='"';
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
} 


  $price_sql="select price from menu";
   $result = $conn->query($price_sql);
   if ($result->num_rows > 0) {
      $j=1;
       while($row = $result->fetch_assoc()) {
          $_price[$j]=$row["price"];
          $j++;
		 
       }
   } else {
       echo "0 results";
   }


   $sql="select table_num,";
   for($i=1;$i<=20;$i++)
   {
      $sql.="menu".$i.",";
   }
   $sql.="price from order_info where cash_ok=0&&check_ok=0";
   $result = $conn->query($sql);
   $num=0;
   if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       $num++;
       $table[$num]=$row["table_num"];
      for($i=1;$i<=20;$i++)
      {
        $menu[$num][$i]=$row["menu".$i];
      }
      $price[$num]=$row["price"];

      $sql_="select ";
      for($i=1;$i<=20;$i++)
      {
         $sql_.="menu".$i.",";
      }
      $sql_.="price from order_info where cash_ok=0&&check_ok=1&&table_num=".$table[$num];
      $result_=$conn->query($sql_);
      if($result_->num_rows>0)
      {
         while($row=$result_->fetch_assoc())
         {
            for($i=0;$i<=20;$i++)
            {
               $menu_[$i]=$row["menu".$i];
            }
            $price_=$row["price"];
         }
      }
       if($price_!=NULL)
       {
          $price[$num]+=$price_;
          $sql_="update order_info set ";
          for($i=1;$i<=20;$i++)
          {
            $sql_.="menu".$i."="."menu".$i."+".$menu[$num][$i].',';
          }

          $sql_.="price=".$price[$num]." where cash_ok=0&&check_ok=1&&table_num=".$table[$num];
          if (mysqli_query($conn, $sql_)){}
          else{echo "Error: " . $sql_ . "<br>" . mysqli_error($conn);}

          $sql_="delete from order_info where check_ok=0&&cash_ok=0&&table_num=".$table[$num];
          if (mysqli_query($conn, $sql_)){}
          else{echo "Error: " . $sql_ . "<br>" . mysqli_error($conn);}
       }
       else
       {
          $sql_="update order_info set check_ok=1 where cash_ok=0&&table_num=".$table[$num];
          if (mysqli_query($conn, $sql_)) {}
          else {echo "Error: " . $sql_ . "<br>" . mysqli_error($conn);}
       }
    }
} else {
    
}
    $sql="select table_num,price from order_info where cash_ok=0";
    $result = $conn->query($sql);
    if($result->num_rows>0)
    {
      while($row=$result->fetch_assoc())
      {
        $q=$row["table_num"];
        $z[$q]=$row["price"];
      }
    }
    $sql="select * from edit_order";
    $result = $conn->query($sql);
    if($result->num_rows>0)
      {
         while($row=$result->fetch_assoc())
         {
            $t=$row["table_num"];
            $flag=0;
            for($j=1;$j<=$num;$j++)
            {
              if($t==$table[$j])
                $flag=$j;
            }
            if($flag!=0)
            {
              for($p=1;$p<=20;$p++)
             {
                $a=$row["menu".$p];
                $menu[$flag][$p]+=$a;
              }
              $price[$flag]+=$z[$t];
            }
            else
            {
              $num++;
              $table[$num]=$t;
              $price[$num]=0;
              for($p=1;$p<=20;$p++)
             {
                $a=$row["menu".$p];
                $menu[$num][$p]+=$a;
              }
              $price[$num]+=$z[$t];
            }
         }
      }
      $sql="delete from edit_order";
      mysqli_query($conn, $sql);


   for($j=1;$j<=$num;$j++)
   {
      $return[$j]["table"]=$table[$j];
      for($i=1;$i<20;$i++)
      {
         if($menu[$j][$i]!=0)
         {
            $return[$j]['menu'.$i]=$menu[$j][$i];
         }
      }
      $return[$j]["price"]=$price[$j];
   }
   
   echo json_encode($return);
   mysqli_close($conn);
?>