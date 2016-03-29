<?php
function json_encode2($data) {
    switch (gettype($data)) {
        case 'boolean':
            return $data?'true':'false';
        case 'integer':
        case 'double':
            return $data;
        case 'string':
            return '"'.strtr($data, array('\\'=>'\\\\','"'=>'\\"')).'"';
        case 'array':
            $rel = false; // relative array?
            $key = array_keys($data);
            foreach ($key as $v) {
                if (!is_int($v)) {
                    $rel = true;
                    break;
                }
            }

            $arr = array();
            foreach ($data as $k=>$v) {
                $arr[] = ($rel?'"'.strtr($k, array('\\'=>'\\\\','"'=>'\\"')).'":':'').json_encode2($v);
            }

            return $rel?'{'.join(',', $arr).'}':'['.join(',', $arr).']';
        default:
            return '""';
    }
}
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}
   $sql="select * from order_info where phone_number!=0";
   $result = $conn->query($sql);
   if ($result->num_rows > 0)
   {
      $num=0;
      while($row = $result->fetch_assoc())
      {
         $people[$num]=$row['people'];
         $time[$num]=$row['time'];
         $phone_number[$num]=$row['phone_number'];
         $name[$num]=$row['name'];
         $id_num[$num]=$row['id_num'];
         for($i=1;$i<=20;$i++)
         {
            $menu[$num][$i]=$row['menu'.$i];
         }
         $num++;
      }
   }
   $sql="select name from menu";
   $result = $conn->query($sql);
   if ($result->num_rows > 0)
   {
      $number=1;
      while($row = $result->fetch_assoc())
      {
         $menuname[$number]=$row['name'];
         // echo $menuname[$number];
         $number++;
      }
   }
   for($i=$num-1;$i>=0;$i--)
   {
      $return[$i]["number"]=$id_num[$i];
      $return[$i]["people"]=$people[$i];
      $return[$i]["time"]=$time[$i];
      $return[$i]["phone_number"]=$phone_number[$i];
      $return[$i]["name"]=$name[$i];
      for($j=1;$j<=20;$j++)
      {
        if($menu[$i][$j]>0)
          $return[$i][$menuname[$j]]=$menu[$i][$j];
      }
   }
   //echo json_encode2($return);
	$str=json_encode2($return);
	$str = iconv("EUC-KR", "UTF-8", $str);
	echo $str;   
mysqli_close($conn);
?>