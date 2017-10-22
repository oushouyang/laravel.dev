<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>标题</title>
</head>
<body>
	<h1>视图的赋值操作</h1>
	<hr />
	<h2>1. 视图里面如何书写变量的输出？ a. 原生</h2>
	<h3><?php echo $title;?></h3>
	<hr>
	<h3><?= $title;?></h3>
	<hr>
	<h2>2. 视图里面如何书写变量的输出？b.标签语法</h2>
	<!-- 插值表达式 vuejs 也是这种方式-->
	<h2>{{ $title }}</h2>
</body>
</html>