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
  $num=$_GET['num'];
  $sql="select * from menu where num=".$num;
  $result = $conn->query($sql);
  if ($result->num_rows > 0)
  {
    while($row = $result->fetch_assoc())
    {
      $return["name"]=$row['name'];
      $return["num"]=$row['num'];
      $return["price"]=$row['price'];
      $return["margin"]=$row['margin'];
      $return["category"]=$row['category'];
    }
  }
  echo json_encode2($return);
	$str=json_encode2($return);
	$str = iconv("EUC-KR", "UTF-8", $str);
	echo $str;
   mysqli_close($conn);
?>