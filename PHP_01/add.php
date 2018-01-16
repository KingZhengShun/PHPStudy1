<?php

	include("conn.php");//引入连接数据库文件；

	if (!empty($_POST['sub'])) {
		$title=$_POST['title'];
		$contents=$_POST['contents'];
		$sql="insert into `news` (`id`,`title`,`dates`,`contents`) value(null,'$title',now(),'$contents')";
		mysql_query($sql);
		echo "插入成功！";
	}
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="shortcut icon" href="">
		<title>信息展示页面</title>
		<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

		<style type="text/css">
		.form-horizontal{
			width: 600px;
			height: auto;
			margin: 50px auto;
			background: #f7f7f9;
			padding: 50px;
		}
		.btn-primary{
			display: block;
			margin-left: 105px;
		}
	</style>
</head>
<body>
	<form action="add.php" method="post" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label">标题：</label>
			<div class="col-sm-10">
				<input type="text" name="title" class="form-control">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label">信息：</label>
			<div class="col-sm-10">
				<textarea class="form-control" name="contents" rows="5"></textarea>
			</div>
		</div>
		<input type="submit" name="sub" class="btn btn-primary" value="Sumbit">
	</form>
</body>
</html>