<?php
	include("conn.php");//引入连接数据库文件；
	$sql="select * from `news` order by id desc limit 10";
	$query=mysql_query($sql);

	?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
		<link rel="shortcut icon" href="">
		<title>信息展示页面</title>
		<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<style>
		section{
			padding: 25px;
			width: 750px;
			margin: auto;
			background: #f7f7f9;
		}

		.media-object{
			width: 64px;
			height: 64px;
		}
		.btn{
			background: #eeeeee;
		}
	</style>

</head>
<body>
	<section>
		<a href="add.php" class="btn">添加内容</a><hr>
		<?php
		while ($rs=mysql_fetch_array($query)) {
			?>
			<div class="media">
				<div class="media-left media-middle">
					<a href="#">
						<img class="media-object" src="image/header.jpg" alt="...">
					</a>
				</div>
				<div class="media-body">
					<h4 class="media-heading"><?php echo $rs['title'] ?>;</h4>
					<p><?php echo $rs['contents'] ?>;</p>					
				</div>
				
				<a href="delete.php?delete=<?php echo $rs['Id'] ?>" class="btn">删除内容</a>
				<a href="edite.php?edite=<?php echo $rs['Id'] ?>" class="btn">编辑内容</a>

			</div>
			<hr>

			<?php
		}
		?>
	</section>
</body>
</html>