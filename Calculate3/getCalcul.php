<?php header("Content-Type:text/html;charset=utf-8");?>
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

   $sql="select count(num) from menu";
  $result = $conn->query($sql);
   if ($result->num_rows > 0) {
       while($row = $result->fetch_assoc()) {
          $count=$row['count(num)'];
       }
   } else {
   }


   $startday=$_GET['date_from'];
   $endday=$_GET['date_to'];
   $option=$_GET['option'];
	//echo date('N', strtotime($startday))."<br>";
   // echo $startday."//".$endday."//".$option."<br>";
   $sql="select * from calculate_info where date_format('".$startday."','%Y-%m-%d') <= date&&date <= date_format('".$endday."','%Y-%m-%d')";
   // echo $sql."<br>";
   $result = $conn->query($sql);
   if ($result->num_rows > 0)
   {
      $j=0;
         while($row = $result->fetch_assoc())
       {
         $date[$j]=$row['date'];
         for($i=1;$i<=$count;$i++)
         {
            $menu[$j][$i]=$row['menu'.$i];
         }
         $cash[$j]=$row['cash'];
         $card[$j]=$row['card'];
         $j++;
      }
   }
   // echo $j."<br>";
   if($option==1)
   {
      $num=0;
      for($i=0;$i<$j;$i++)
      {
         $num++;
         for($z=1;$z<=$count;$z++)
         {
            $k[$i][$z]=$menu[$i][$z];
         }
         $k[$i][21]=$cash[$i];
         $k[$i][22]=$card[$i];
      }
   }
   else if($option==2)
   {
      $num=0;
      $a=date('N', strtotime($startday));
      //echo $a."<br>";
      for($i=0;$i<$j;$i++)
      {
         for($z=1;$z<=$count;$z++)
         {
            $k[$num][$z]+=$menu[$i][$z];
         }
         $k[$num][21]+=$cash[$i];
         $k[$num][22]+=$card[$i];
         $a++;
         if($a==8)
         {
            $a=0;
            $num++;
         }
      }
      if($k[$num][21]+$k[$num][22]!=null)
         $num++;
   }
   else if($option==3)
   {
      $num=0;
      $a=substr($date[0],5,2);
      for($i=0;$i<$j;$i++)
      {
         if($a!=substr($date[$i],5,2))
         {
            $num++;
         }
         $a=substr($date[$i],5,2);
         for($z=1;$z<=$count;$z++)
         {
            $k[$num][$z]+=$menu[$i][$z];
         }
         $k[$num][21]+=$cash[$i];
         $k[$num][22]+=$card[$i];
      }
      if($k[$num][21]+$k[$num][22]!=null)
         $num++;
   }
   else if($option==4)
   {
      $num=0;
      $a=substr($date[0],0,4);
      for($i=0;$i<$j;$i++)
      {
         if($a!=substr($date[$i],0,4))
         {
            $num++;
         }
         $a=substr($date[$i],0,4);
         for($z=1;$z<=$count;$z++)
         {
            $k[$num][$z]+=$menu[$i][$z];
         }
         $k[$num][21]+=$cash[$i];
         $k[$num][22]+=$card[$i];
      }
      if($k[$num][21]+$k[$num][22]!=null)
         $num++;
   }
   else
   {
      $num=0;
      $a=substr($date[0],5,2);
      for($i=0;$i<$j;$i++)
      {
         if($a+substr($date[$i],5,2)==7||($a+substr($date[$i],5,2)==13&&$a!=12)||$a+substr($date[$i],5,2)==19)
         {
            $num++;
         }
         $a=substr($date[$i],5,2);
         for($z=1;$z<=$count;$z++)
         {
            $k[$num][$z]+=$menu[$i][$z];
         }
         $k[$num][21]+=$cash[$i];
         $k[$num][22]+=$card[$i];
      }
      if($k[$num][21]+$k[$num][22]!=null)
         $num++;
   }




   // echo $num."<br>";
   // for($i=0;$i<$j;$i++)
   // {
   //    for($z=1;$z<=$count;$z++)
   //    {
   //       echo $k[$i][$z]." ";
   //    }
   //    echo $k[$i][21]." ";
   //    echo $k[$i][22]."<br>";
   // }


   for($i=0;$i<$num;$i++)
   {
      for($z=1;$z<=$count;$z++)
      {
         $return[$i]["menu".$z]=$k[$i][$z];
      }
      $return[$i]["cash"]=$k[$i][21];
      $return[$i]["card"]=$k[$i][22];
   }
   echo json_encode($return);
   mysqli_close($conn);
?>