<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include("conn.php");//引入连接数据库文件；

if(!empty($_GET['delete'])){
	$num=$_GET['delete'];
	echo $num;
	$sql="delete from `news` where `id`='$num'";
	mysql_query($sql);
	echo "删除成功";
}
?>