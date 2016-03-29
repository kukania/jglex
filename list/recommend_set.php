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
   $abc='"';
   $conn = mysqli_connect($servername, $username, $password, $dbname);
   if (!$conn) {
     die("Connection failed: " . mysqli_connect_error());
} 
$conn->query("set session character_set_connection=utf8;");

$conn->query("set session character_set_results=utf8;");

$conn->query("set session character_set_client=utf8;");
	$male=$_GET['hc_male'];
	$female=$_GET['hc_female'];
	$kid=$_GET['hc_kid'];
	$sql="select name,price from menu Order By num";
	$result = $conn->query($sql);
	if ($result->num_rows > 0)
	{
		$i=1;
		while($row = $result->fetch_assoc())
		{
			$menu_name[$i]=$row['name'];
			$price[$i]=$row['price'];
			$menu_num[$i]=0;
			$i++;
		}
	}
	else{}
	$menu_num[3]=floor($male*1+$female*1+$kid*0.5);
	$menu_num[8]=$kid*1;
	$menu_num[9]=floor(($male+$female)*0.5);
	$menu_num[20]=floor(($male+$female)*0.5)+$kid;
	$return[0]['name']="좋닭세트";
	//echo $return[0]['name'];
	for($i=1;$i<21;$i++)
	{
		$return[0]['price']+=$price[$i]*floor($menu_num[$i]);
	}
	for($i=1;$i<21;$i++)
	{
		if($menu_num[$i]!=0)
			$return[0]['comp'].=$menu_name[$i].":".$menu_num[$i].",";
	}
	$return[0]['comp']=substr($return[0]['comp'],0,-1);
	$return[0]['msg']='개꿀세트^^';
	echo json_encode2($return);
	mysqli_close($conn);
?>