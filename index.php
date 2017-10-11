
<html>
<head>
<style>
.table_heading{
	background: darkgray;
}
.table_data{
	background: lightgray;
}
.tab{
	border: 1px solid lightgray;
	align: center;
	margin-top: 10px;
}
</style>
</head>
<body>
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
<?php if(isset($_POST["submit"])): ?>
	<?php if(isset($_POST["stock"])&&$_POST["stock"]==""):
		$message = "Please enter a symbol";
		echo "<script type='text/javascript'>alert('$message');</script>";
	?>
	<?php else:
	$curl = curl_init();?>
	<?php if ($_POST["stock"]):
		$url="https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".$_POST["stock"]."&apikey=B7Q03XG89RUCBSPJ";
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl,CURLOPT_RETURNTRANSFER,1);
		$result = curl_exec($curl);
		curl_close($curl);
		$obj=json_decode($result,true);
		$num=2;
		foreach($obj["Time Series (Daily)"] as $key => $val)
		{
			if($num==2){$day1=$key.""; $num--;}
			elseif($num==1){$day2=$key.""; $num--;}
			else break;
		}
		?>
		<div >
		<table class="tab" align="center" >
		<tr>
		<td class="table_heading">Stock Ticker Symbol</td>
		<td class="table_data"><?php echo $obj["Meta Data"]["2. Symbol"];?>
		</tr>
		<tr>
		<td class="table_heading">Close</td>
		<td class="table_data"><?php echo $obj["Time Series (Daily)"][$day1]["4. close"];?>
		</tr>
		<tr>
		<td class="table_heading">Open</td>
		<td class="table_data"><?php echo $obj["Time Series (Daily)"][$day1]["1. open"];?>
		</tr>
		<tr>
		<td class="table_heading">Previous Close</td>
		<td class="table_data"><?php echo $obj["Time Series (Daily)"][$day2]["4. close"];?>
		</tr>
		<tr>
		<td class="table_heading">Change</td>
		<td class="table_data">
		<?php 
		$change = $obj["Time Series (Daily)"][$day1]["4. close"] - $obj["Time Series (Daily)"][$day2]["4. close"];
			if($change>0): echo round($change,4);?><img src="Green_Arrow_Up.png" style="height:10px; width:10px">
		<?php else: echo round($change,4); ?><img src="Red_Arrow_Down.png" style="height:10px; width:10px">
	<?php endif;?>
		</tr>
		<tr>
		<td class="table_heading">Change Percent</td>
		<td class="table_data"><?php echo round(($change/$obj["Time Series (Daily)"][$day1]["4. close"])*100,2)."%"?>
		</tr>
		<tr>
		<td class="table_heading">Day's Range</td>
		<td class="table_data"><?php echo $obj["Time Series (Daily)"][$day1]["3. low"]."-".$obj["Time Series (Daily)"][$day1]["2. high"];?>
		</tr>
		<tr>
		<td class="table_heading">Volume</td>
		<td class="table_data"><?php echo number_format($obj["Time Series (Daily)"][$day1]["5. volume"]);?>
		</tr>
		<tr>
		<td class="table_heading">Timestamp</td>
		<td class="table_data"><?php echo $day1;?>
		</tr>
		<tr>
		<td class="table_heading">Indicators</td>
		<td class="table_data"><?php echo $obj["Meta Data"]["2. Symbol"];?>
		</tr>
		</div>
	
	<?php endif;?>
	<?php endif;?>
<?php endif;?>
</body>
</html>