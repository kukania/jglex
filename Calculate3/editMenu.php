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
  $name=$_POST['name'];
  $price=$_POST['price'];
  $margin=$_POST['margin'];
  $category=$_POST['category'];
  $num=$_GET['num'];
  // $sql="update menu set name='".$name."', price=".$price.", margin=".$margin." where num=".$num;
  $sql="update menu set name='".$name."', price=".$price.", margin=".$margin.", category=".$category." where num=".$num;
  mysqli_query($conn, $sql);
   mysqli_close($conn);
?>