<?php

	@mysql_connect("localhost:3306","root","root") or die("mysql连接失败！");
	@mysql_select_db("php100") or die("db连接失败");
	mysql_query("set names 'utf8'");
?>