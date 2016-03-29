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
  date_default_timezone_set('Asia/Seoul');
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
}   
$conn->query("set session character_set_connection=utf8;");

$conn->query("set session character_set_results=utf8;");

$conn->query("set session character_set_client=utf8;");

  // $sql="select count(num) from menu";
  // $result = $conn->query($sql);
  //  if ($result->num_rows > 0) {
  //      while($row = $result->fetch_assoc()) {
  //         $count=$row['count(num)'];
  //      }
  //  } else {
  //  }
  //  echo $count;
  $cate[1]="닭 요리";
  $cate[2]="사리";
  $cate[3]="음료";
  $cate[4]="기타";
   $sql="select * from menu order by num";
   $result = $conn->query($sql);
  if ($result->num_rows > 0)
  {
    $count=0;
    while($row = $result->fetch_assoc())
    {
      $count++;
      $name[$count]=$row['name'];
      $price[$count]=$row['price'];
      $num[$count]=$row['num'];
      $margin[$count]=$row['margin'];
      $category[$count]=$cate[$row['category']];
    }
  }
  for($i=1;$i<=$count;$i++)
  {
    $return[$i]["num"]=$num[$i];
    $return[$i]["name"]=$name[$i];
    $return[$i]["price"]=$price[$i];
    $return[$i]["margin"]=$margin[$i];
    $return[$i]["category"]=$category[$i];
  }
  echo json_encode2($return);
	//$str=json_encode2($return);
	//$str = iconv("EUC-KR", "UTF-8", $str);
	//echo $str;   
mysqli_close($conn);
?>