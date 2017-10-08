<?php
	echo $_POST["stock"];
	 if(isset($_POST["stock"])&&$_POST["stock"]==""):
		$message = "Please enter a symbol";
		echo "<script type='text/javascript'>alert('$message');</script>";
	?>
	<?php else:

	?>
	<?php endif;?>

<html>
<body >
<div style="
    text-align: center;
    width: 350px;
    margin: 0 auto;
    background: lightgray;
	padding: 10px;
	border: solid darkgray;">
<h1><i>Stock Search</i></h1>
<hr>
<form action="index.php" method="POST">
<div class="symbol" style="">Enter Stock Ticker Symbol:*<input type="text" name="stock"><br/></div>
<input type="submit" name="submit">
<input type="reset" name="clear" value="Clear">
</form>
<div style="text-align: left;">*- <i>Mandatory fields.</i></div>
</div>
</body>
</html>