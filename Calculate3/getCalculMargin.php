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

   $sql="select num,margin from menu";
   $result = $conn->query($sql);
   if ($result->num_rows > 0) 
   {
      while($row = $result->fetch_assoc()) 
      {
         $num=$row['num'];
         $menuMargin[$num]=$row['margin'];
      }
   }

   $startday=$_GET['date_from'];
   $endday=$_GET['date_to'];
   $option=$_GET['option'];
   $charge=$_GET['charge'];
   $sql="select * from calculate_info where date_format('".$startday."','%Y-%m-%d') <= date&&date <= date_format('".$endday."','%Y-%m-%d')";
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
            $margin[$j]+=$menu[$j][$i]*$menuMargin[$i];
         }
         $cash[$j]=$row['cash'];
         $card[$j]=$row['card'];
         $j++;
      }
   }

   if($option==1)
   {
      $num=0;
      for($i=0;$i<$j;$i++)
      {
         $num++;
         $k[$i][0]=$date[$i];
         $k[$i][1]=$cash[$i];
         $k[$i][2]=$card[$i];
         $k[$i][3]=$margin[$i];
      }
   }
   else if($option==2)
   {
      $num=0;
      $a=date('N', strtotime($startday));
      for($i=0;$i<$j;$i++)
      {
         $qwe=mktime(0,0,0,substr($date[$i],5,2),substr($date[$i],8,2),substr($date[$i], 0,4));
         $k[$num][0]=substr($date[$i],0,4).".".date('W',$qwe);
         $k[$num][1]+=$cash[$i];
         $k[$num][2]+=$card[$i];
         $k[$num][3]+=$margin[$i];
         $a++;
         if($a==7)
         {
            $a=0;
            $num++;
         }
      }
      if($k[$num][1]+$k[$num][2]!=null)
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
         $k[$num][0]=substr($date[$i],0,4).".".$a;
         $k[$num][1]+=$cash[$i];
         $k[$num][2]+=$card[$i];
         $k[$num][3]+=$margin[$i];
      }
      if($k[$num][1]+$k[$num][2]!=null)
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
         $k[$num][0]=$a;
         $k[$num][1]+=$cash[$i];
         $k[$num][2]+=$card[$i];
         $k[$num][3]+=$margin[$i];
      }
      if($k[$num][1]+$k[$num][2]!=null)
         $num++;
   }
   else
   {
      $num=0;
      $a=substr($date[0],5,2);
      for($i=0;$i<$j;$i++)
      {
         if($a+substr($date[$i],5,2)==7||($a+substr($date[$i],5,2)==13)||$a+substr($date[$i],5,2)==19)
         {
            $num++;
         }
         $a=substr($date[$i],5,2);
         if($a<4)
            $q=1;
         else if($a<7)
            $q=2;
         else if($a<10)
            $q=3;
         else
            $q=4;
         $k[$num][0]=substr($date[$i],0,4).".".$q;
         $k[$num][1]+=$cash[$i];
         $k[$num][2]+=$card[$i];
         $k[$num][3]+=$margin[$i];
      }
      if($k[$num][1]+$k[$num][2]!=null)
         $num++;
   }






   for($i=0;$i<$num;$i++)
   {
      $return[$i]["num"]=$i+1;
      $return[$i]["date"]=$k[$i][0];
      $return[$i]["sales"]=$k[$i][1]+$k[$i][2];
      $return[$i]["cash"]=$k[$i][1];
      $return[$i]["card"]=$k[$i][2];
      $return[$i]["cashMargin"]=round($k[$i][3]*$k[$i][1]/($k[$i][1]+$k[$i][2]));
      $return[$i]["cardMargin"]=round($k[$i][3]*$k[$i][2]/($k[$i][1]+$k[$i][2])*$charge);
      $return[$i]["margin"]=$k[$i][3];
   }
   echo json_encode($return);
   mysqli_close($conn);
?>