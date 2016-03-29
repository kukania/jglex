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
?>
<?php
	//database set
	$servername="db.gooddark.com";
	$username="jglex";
	$password="jglex123123";
	$dbname="dbjglex";
	$abc="'";
	$conn = mysqli_connect($servername, $username, $password, $dbname);
	$sql="select * from menu where category=";
	$category=$_GET['category'];
	$sql.=$category;
	$result = $conn->query($sql);
	$i=0;
  	if ($result->num_rows > 0){
  		while($row=$result->fetch_assoc()){
  			foreach($row as $key=>$value){
  				$returnValue[$i][$key]=$value;
  			}
			$i++;
  		}
  	}
	$str=json_encode2($returnValue);
	$str = iconv("EUC-KR", "UTF-8", $str);
	echo $str;
?>

<?php mysqli_close($conn);?>