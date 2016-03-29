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
	$date=$_GET['date'];
	$sql="select * from reservationcheck";//이미 예약된 정보
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
   	{
      	$num=0;
      	while($row = $result->fetch_assoc())
      	{
      		$table_num[$num]=$row['table_num'];//예약 테이블 수
          $name[$num]=$row['name'];//
          $phone_number[$num]=$row['phone_number'];//
          $number[$num]=$row['number'];//
          $time[$num]=$row['time'];//
          $time_[$num]=substr($time[$num], 0,10);
          $menu[$num]=$row['menu'];
          $menu[$num]=str_replace("menu1", "닭갈비정식", $menu[$num]);
          $menu[$num]=str_replace("menu2", "좋은날엔 닭갈비", $menu[$num]);
          $menu[$num]=str_replace("menu3", "허브치킨가스", $menu[$num]);
          $menu[$num]=str_replace("menu4", "닭가슴살냉채", $menu[$num]);
          $menu[$num]=str_replace("menu5", "닭갈비철판볶음밥", $menu[$num]);
      		$num++;
      	}
   	}
	$k=0;
	for($i=0;$i<$num;$i++)
	{
		if($date==$time_[$i])
		{
			$return[$k]['name']=$name[$i];
			$return[$k]['phone_number']=$phone_number[$i];
			$return[$k]['people']=$number[$i];
			$return[$k]['table_num']=$table_num[$i];
			$return[$k]['time']=$time[$i];
      $return[$k]['menu']=$menu[$i];
			$k++;
		}
	}
	echo json_encode2($return);
	//$str=json_encode2($return);
	//$str = iconv("EUC-KR", "UTF-8", $str);
	//echo $str;	
mysqli_close($conn);
?>