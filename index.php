<html>
	<head>
	
		<script type="text/javascript">
			function test(){
				alert("test");
				document.write("<h1>hello world</h1>")
			}
		</script>
		<link rel="stylesheet" type="text/css" href="1.css">
	
	</head>
	<body>


		<!--    这是文字    -->
		<h1>HELLO!</h1>
		<h2>WORLD!</h2>
		<p id="one" class="center">monday</p>
		<p id="two" class="center">tuesday</p>
		<p id="three">wednesday</p>
		<p>this <span class="center">is</span> a good <span class="left">day!</span></p>
		

		<!--    这是内容    -->
		<script src="1.js"></script>
		
		<form action="action_page.php" method="post">
			<input type="text" name="username" onfocus="this.value=" onblur="if(!value){value=defaultValue;}">
			<input type="submit" value="Submit!">
			<input type="reset" value="Reset">
		</form>
		<br>
		
		<form name="form1" method="post" action="action_page.php" target="nm_iframe">
			<input type="text" onfocus="this.value=">
			<input type="submit" name="query" value="Submit!">
		</form>

		<iframe id="id_iframe" name="nm_iframe" style="display:none;"></iframe>

		<br>
		<input type="button" onclick="message()" value="Click!">
		<a href="login.php"><input type="button" value="Jump!"></a>
		<a href="/a/login.php"><input type="button" value="Jump2!"></a>
		<a href="testsql.php"><input type="button" value="Jump3!"></a>
	</body>
</html>