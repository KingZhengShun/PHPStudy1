<?php

	include("conn.php");//引入连接数据库文件；
	$edite=$_GET['edite'];
	
	if (!empty($edite)) {		
		$sql1="select * from `news` where `Id`='$edite'";
		$query=mysql_query($sql1);
		$rs=mysql_fetch_array($query);
		$title=$rs['title'];
		$contents=$rs['contents'];
	}

	if (!empty($_POST['sub'])) {
		$title=$_POST['title'];
		$contents=$_POST['contents'];
		$sql="update `news` set `title`='$title',`contents`='$contents' where `Id`='$edite' limit 1";
		mysql_query($sql);
		echo "<script>alert('更新成功!');location.href='index.php';</script>";
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
	<form action="edite.php" method="post" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label">标题：</label>
			<div class="col-sm-10">				
				<input type="text" name="title" class="form-control" value="<?php echo $title ?>">
			</div>
		</div>
		<div class="form-group">
			<label for="inputPassword" class="col-sm-2 control-label">信息：</label>
			<div class="col-sm-10">
				<textarea class="form-control" name="contents" rows="5"><?php echo $contents ?></textarea>
			</div>
		</div>
		<input type="submit" name="sub" class="btn btn-primary" value="Sumbit">
	</form>
</body>

</html>
