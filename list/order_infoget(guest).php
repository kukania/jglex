<?php header("Content-Type:text/html;charset=utf-8");?>
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
   $tablenum=$_GET['tableNum'];
   $sql="select ";
   for($i=1;$i<=20;$i++)
   {
      $sql.="menu".$i.",";
   }
   $tprice=0;
   $sql.="price, isok, id_num from order_info where cash_ok=0&&table_num=".$tablenum;
   $result = $conn->query($sql);
   if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
       for($i=1;$i<=20;$i++)
       {
          $menu[$i]=$row["menu".$i];
       }
       $price[$j]=$row["price"];
       $tprice+=$price[$j];
	   $isok=$row["isok"];
       $id_num=$row["id_num"];
    }
} else {
}
   //echo $sql;
   $manu[1]="�߰��� ����(����)";
   $manu[2]="�߰��� ����(������)";
   $manu[3]="���� ���� �߰���";
   $manu[4]="�߰���+1";
   $manu[5]="�߰��� ����";
   $manu[6]="��� ġŲ����";
   $manu[7]="�߰����� ��ä";
   $manu[8]="��� ġŲ����";
   $manu[9]="��� �縮";
   $manu[10]="�쵿 �縮";
   $manu[11]="��� �縮";
   $manu[12]="�� �縮";
   $manu[13]="������ �縮";
   $manu[14]="������";
   $manu[15]="�����";
   $manu[16]="����� ������";
   $manu[17]="����/����";
   $manu[18]="���ɸ�";
   $manu[19]="û��";
   $manu[20]="�����";
   $return["idNum"]=$id_num;
   $return["isOk"]=$isok;
   for($i=1;$i<=20;$i++)
   {
      if($menu[$i]!=0)
      {
         $return["menu".$i]=$menu[$i];
      }
   }
   $return["price"]=$tprice;
   if($tprice!=0)
    echo json_encode($return);
   mysqli_close($conn);
?>