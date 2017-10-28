<html>
<head>
<style>
.table_heading{
	background: darkgray;
	text-align: left;
	font-weight: bold;
	padding-right:30px;
}
.table_data{
	background: lightgray;
	text-align: center;
	padding-left: 20px;
	padding-right:20px;
}
.tab{
	border: 1px solid lightgray;
	align: center;
	margin-top: 10px;
	width:100%;
}
.rss_tab{
	width:100%;
}
#rss_table {
	width:100%;
}
#graph {
	width:100%;
}
#st {
	width:100%;
}
</style>
<script src="https://code.highcharts.com/highcharts.src.js"></script>
<script src="https://code.highcharts.com/modules/annotations.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script>
function clearAll(){
	document.getElementById("stock").value="";
	document.getElementById("table").innerHTML="";
}
function shownews(){
	if(document.getElementById("arrow_img").src.indexOf("Gray_Arrow_Down")!=-1){
		document.getElementById("arrow_img").src='Gray_Arrow_Up.png'
		document.getElementById("message").innerHTML='Click to hide stock news'
	}else{
		document.getElementById("arrow_img").src='Gray_Arrow_Down.png'
		document.getElementById("message").innerHTML='Click to show stock news'
	}
}
function draw_G1(symbol,value){
	var xmlhttp = new XMLHttpRequest();
	var ar={"SMA":"Simple Moving Average (SMA)",
	"MACD":"Moving Average Covergence/Divergence (MACD)",
	"CCI":"Commodity Channel Index (CCI)",
	"ADX":"Average Directional movement indeX (ADX)",
	"EMA":"Exponential Moving Average (EMA)",
	"RSI":"Relative Strength Index (RSI)",

	}
	url="https://www.alphavantage.co/query?function="+value+"&symbol="+symbol+"&interval=daily&time_period=10&series_type=close&apikey=B7Q03XG89RUCBSPJ"
	xmlhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
			xmlDoc=this.responseText;
			var myObj = JSON.parse(xmlDoc);
	var x =[]
	var dataOfSymbol=[]
	var i=0;
	var mon=""
	var numMonths=0
	for(var a in myObj["Technical Analysis: "+String(value)]){
		var d=String(a).split('-')
		if(i==0) mon=d[1]
		if(numMonths<6){
			if(mon!=d[1]){
				numMonths=numMonths+1
				mon=d[1]
			}
		}else{
			break;
		}
		x[i]=d[1]+"/"+d[2]
		dataOfSymbol[i]=parseFloat(myObj["Technical Analysis: "+String(value)][a][String(value)])
		i=i+1
	}
	x.reverse()
	dataOfSymbol.reverse()
	Highcharts.chart('graph', {
    chart: {
		borderColor: 'darkgray',
        borderWidth: 2,
        type: 'line'
    },
    title: {
        text: ar[String(value)]
    },
    subtitle: {
		useHTML: true,
        text: '<a target="_blank" style="color: rgb(0, 0, 255); cursor: pointer; text-decoration: none;" href="https://www.alphavantage.co/">Source: Alpha Vantage</a>'
    },
	navigation: {
		enabled: true,
        buttonOptions: {
            enabled: true
        }
    },
    xAxis: {
        categories: x,
		showLastLabel: true,
		startOnTick: true,
		labels:{
			step: 1,
			align: 'right',
			rotation: -15
		},
		tickInterval: 5
    },
    yAxis: {
        title: {
            text: value
        }
    },
    plotOptions: {
        line: {
            enableMouseTracking: true
        }
    },
	legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					
					backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
				},
    series: [{
        name: symbol,
        data: dataOfSymbol
    }]
});
		}
	}
    xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
    
	
}
function draw_BBANDS(symbol,value){
	var xmlhttp = new XMLHttpRequest();
	url="https://www.alphavantage.co/query?function="+value+"&symbol="+symbol+"&interval=daily&time_period=10&series_type=close&apikey=B7Q03XG89RUCBSPJ"
	xmlhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
			xmlDoc=this.responseText;
	var myObj = JSON.parse(xmlDoc);
	var x =[]
	var RUB=[]
	var RLB=[]
	var RMB=[]
	var i=0;
	var mon=""
	var numMonths=0
	for(var a in myObj["Technical Analysis: BBANDS"]){
		var d=String(a).split('-')
		if(i==0) mon=d[1]
		if(numMonths<6){
			if(mon!=d[1]){
				numMonths=numMonths+1
				mon=d[1]
			}
		}else{
			break;
		}
		x[i]=d[1]+"/"+d[2]
		RUB[i]=parseFloat(myObj["Technical Analysis: BBANDS"][a]["Real Upper Band"])
		RLB[i]=parseFloat(myObj["Technical Analysis: BBANDS"][a]["Real Lower Band"])
		RMB[i]=parseFloat(myObj["Technical Analysis: BBANDS"][a]["Real Middle Band"])
		i=i+1
	}
	x.reverse()
	RUB.reverse()
	RLB.reverse()
	RMB.reverse()
	Highcharts.chart('graph', {
    chart: {
		borderColor: 'darkgray',
        borderWidth: 2,
        type: 'line'
    },
    title: {
        text: 'Bollinger Bands (BBANDS)'
    },
	navigator: {
            enabled: true
    },
    subtitle: {
		useHTML: true,
        text: '<a  target="_blank" style="color: rgb(0, 0, 255); cursor: pointer; text-decoration: none;" href="https://www.alphavantage.co/">Source: Alpha Vantage</a>'
    },
    xAxis: {
        categories: x,
		showLastLabel: true,
		startOnTick: true,
		labels:{
			step: 1,
			align: 'right',
			rotation: -15
		},
		tickInterval: 5
    },
    yAxis: {
        title: {
            text: 'BBANDS'
        }
    },
    plotOptions: {
        line: {
            enableMouseTracking: true
        }
    },
	legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					
					backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
				},
    series: [{
        name: symbol+" Real Middle Band",
        data: RMB
    },{
        name: symbol+" Real Upper Band",
        data: RUB
    },{
        name: symbol+" Real Lower Band",
        data: RLB
    }]
});
		}
	}
    xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
    
}
function draw_MACD(symbol,value){
	var xmlhttp = new XMLHttpRequest();
	url="https://www.alphavantage.co/query?function="+value+"&symbol="+symbol+"&interval=daily&time_period=10&series_type=close&apikey=B7Q03XG89RUCBSPJ"
	xmlhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
			xmlDoc=this.responseText;
	var myObj = JSON.parse(xmlDoc);
	var x =[]
	var MACD_Signal=[]
	var MACD_Hist=[]
	var MACD=[]
	var i=0;
	var mon=""
	var numMonths=0
	for(var a in myObj["Technical Analysis: MACD"]){
		var d=String(a).split('-')
		if(i==0) mon=d[1]
		if(numMonths<6){
			if(mon!=d[1]){
				numMonths=numMonths+1
				mon=d[1]
			}
		}else{
			break;
		}
		x[i]=d[1]+"/"+d[2]
		MACD_Signal[i]=parseFloat(myObj["Technical Analysis: MACD"][a]["MACD_Signal"])
		MACD_Hist[i]=parseFloat(myObj["Technical Analysis: MACD"][a]["MACD_Hist"])
		MACD[i]=parseFloat(myObj["Technical Analysis: MACD"][a]["MACD"])
		i=i+1
	}
	x.reverse()
	MACD_Signal.reverse()
	MACD_Hist.reverse()
	MACD.reverse()
	Highcharts.chart('graph', {
    chart: {
		borderColor: 'darkgray',
        borderWidth: 2,
        type: 'line'
    },
    title: {
        text: 'Moving Average Covergence/Divergence (MACD)'
    },
    subtitle: {
		useHTML: true,
        text: '<a target="_blank" style="color: rgb(0, 0, 255); cursor: pointer; text-decoration: none;" href="https://www.alphavantage.co/">Source: Alpha Vantage</a>'
    },
    xAxis: {
        categories: x,
		showLastLabel: true,
		startOnTick: true,
		labels:{
			step: 1,
			align: 'right',
			rotation: -15
		},
		tickInterval: 5
    },
    yAxis: {
        title: {
            text: 'MACD'
        }
    },
    plotOptions: {
        line: {
            enableMouseTracking: true
        }
    },
	legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					
					backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
				},
    series: [{
        name: symbol+" MACD",
        data: MACD
    },{
        name: symbol+" MACD_Hist",
        data: MACD_Hist
    },{
        name: symbol+" MACD_Signal",
        data: MACD_Signal
    }]
});
		}
	}
    xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
    
}

function draw_STOCH(symbol,value){
	var xmlhttp = new XMLHttpRequest();
	url="https://www.alphavantage.co/query?function="+value+"&symbol="+symbol+"&interval=daily&apikey=B7Q03XG89RUCBSPJ"
	xmlhttp.onreadystatechange = function() {
    	if (this.readyState == 4 && this.status == 200) {
			xmlDoc=this.responseText;
			var myObj = JSON.parse(xmlDoc);
			var x =[]
			var dataOfSymbolSlowK=[]
			var dataOfSymbolSlowD=[]
			var i=0;
			var mon=""
			var numMonths=0
			for(var a in myObj["Technical Analysis: STOCH"]){
				var d=String(a).split('-')
				if(i==0) mon=d[1]
				if(numMonths<6){
					if(mon!=d[1]){
						numMonths=numMonths+1
						mon=d[1]
					}
				}else{
					break;
				}
				x[i]=d[1]+"/"+d[2]
				dataOfSymbolSlowK[i]=parseFloat(myObj["Technical Analysis: STOCH"][a]["SlowK"])
				dataOfSymbolSlowD[i]=parseFloat(myObj["Technical Analysis: STOCH"][a]["SlowD"])
				i=i+1
			}
			x.reverse()
			dataOfSymbolSlowK.reverse()
			dataOfSymbolSlowD.reverse()
			Highcharts.chart('graph', {
    		chart: {
				borderColor: 'darkgray',
        		borderWidth: 2,
        		type: 'line'
    		},
    		title: {
        		text: 'Stochastic Oscillator (STOCH)'
    		},
    		subtitle: {
				useHTML: true,
        		text: '<a  target="_blank" style="color: rgb(0, 0, 255); cursor: pointer; text-decoration: none;" href="https://www.alphavantage.co/">Source: Alpha Vantage</a>'
    		},
    		xAxis: {
        		categories: x,
				showLastLabel: true,
				startOnTick: true,
				labels:{
					step: 1,
					align: 'right',
					rotation: -15
				},
				tickInterval: 5
    		},
    		yAxis: {
        		title: {
            		text: 'STOCH'
		        }
    		},
    		plotOptions: {
        		line: {
            		enableMouseTracking: true
        		}
    		},
			legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					
					backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
				},
    		series: [{
				name: symbol+" SlowK",
        		data: dataOfSymbolSlowK
			},{
        		name: symbol+" SlowD",
        		data: dataOfSymbolSlowD
    		}]
		});
		}
  	};
    xmlhttp.open("GET",url,true);
	xmlhttp.send(null);
    
}

</script>
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
<div class="symbol" style="">Enter Stock Ticker Symbol:*<input type="text" id="stock" name="stock" value="<?php echo isset($_POST['stock']) ? $_POST['stock'] : '' ?>"><br/></div>
<input type="submit" name="submit">
<input type="button" id="clear" name="clear" value="Clear" onclick="clearAll()">
</form>
<div style="text-align: left;">*- <i>Mandatory fields.</i></div>
</div>
<?php if(isset($_POST["submit"])): ?>
	<?php if(isset($_POST["stock"])&&$_POST["stock"]==""):
		$message = "Please enter a symbol";
		echo "<script type='text/javascript'>alert('$message');</script>";
	?>
	<?php else:?>
	<?php if ($_POST["stock"]):
		$url="https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol=".$_POST["stock"]."&apikey=B7Q03XG89RUCBSPJ";
		$result = @file_get_contents($url) or die("Error: unable to get contents for symbol");
		$obj=json_decode($result,true);
		error_reporting(0);
		if(isset($obj["Error Message"])){
			echo "<table align=\"center\"><tr><td class=\"table_heading\">Error</td><td class=\"table_data\" >Error: NO recored has been found, please enter a valid symbol</td></tr></table>";
			echo "<div id=\"table\" visibility=\"hidden\" style=\"visibility: collapse;\">";
		}else if(isset($obj["Time Series (Daily)"])){
			echo "<div id=\"table\" visibility=\"visible\">";
			$num=2;
			foreach($obj["Time Series (Daily)"] as $key => $val)
			{
				if($num==2){$day1=$key.""; $num--;}
				elseif($num==1){$day2=$key.""; $num--;}
				else break;
			}
		}else {
			echo "<div id=\"table\" visibility=\"hidden\" style=\"visibility: collapse;\">";
		}
		?>
		<div id="st">
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
			if($change>=0): echo round($change,4);?><img src="http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png" style="height:10px; width:10px">
		<?php else: echo round($change,4); ?><img src="http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png" style="height:10px; width:10px">
	<?php endif;?>
		</tr>
		<tr>
		<td class="table_heading">Change Percent</td>
		<td class="table_data"><?php if(($change/$obj["Time Series (Daily)"][$day1]["4. close"])*100>=0): 
			echo round(($change/$obj["Time Series (Daily)"][$day2]["4. close"])*100,2)."%";?><img src="http://cs-server.usc.edu:45678/hw/hw6/images/Green_Arrow_Up.png" style="height:10px; width:10px">
			<?php else: echo round(($change/$obj["Time Series (Daily)"][$day2]["4. close"])*100,2)."%"; ?><img src="http://cs-server.usc.edu:45678/hw/hw6/images/Red_Arrow_Down.png" style="height:10px; width:10px">
	<?php endif;?>
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
		<td class="table_data"><?php $pieces = explode(" ", $obj["Meta Data"]["3. Last Refreshed"]); echo $pieces[0];?>
		</tr>
		<tr>
		<td class="table_heading">Indicators</td>
		<td class="table_data">
		<a style="text-decoration:none;" href="#"  onclick="<?php
		$i=0; 
		foreach($obj["Time Series (Daily)"] as $key => $val)
		{
			if($i==0){$today=$key;}
			$d[]=explode("-",$key);
			$date_string12[]= (string)$d[$i][1]."/".(string)$d[$i][2];
			$price12[]=$val['4. close'];
		 	$volume12[] =$val['5. volume'];
		 	$i=$i+1;
		}
		$date_string2=array_reverse($date_string12);
		$price2=array_reverse($price12);
		$volume2=array_reverse($volume12);
		echo "draw_price()";?>">Price   </a>
		<?php echo'<a style="text-decoration:none;" href="#" onclick="draw_G1(\''.$obj["Meta Data"]["2. Symbol"].'\',\'SMA\')">SMA   </a>'; ?>
		<?php echo'<a style="text-decoration:none;" href="#" onclick="draw_G1(\''.$obj["Meta Data"]["2. Symbol"].'\',\'EMA\')">EMA   </a>'; ?>
		<?php echo'<a style="text-decoration:none;" href="#" onclick="draw_STOCH(\''.$obj["Meta Data"]["2. Symbol"].'\',\'STOCH\')">STOCH   </a>'; ?>
		<?php echo'<a style="text-decoration:none;" href="#" onclick="draw_G1(\''.$obj["Meta Data"]["2. Symbol"].'\',\'RSI\')">RSI   </a>'; ?>
		<?php echo'<a style="text-decoration:none;" href="#" onclick="draw_G1(\''.$obj["Meta Data"]["2. Symbol"].'\',\'ADX\')">ADX   </a>'; ?>
		<?php echo'<a style="text-decoration:none;" href="#" onclick="draw_G1(\''.$obj["Meta Data"]["2. Symbol"].'\',\'CCI\')">CCI   </a>'; ?>
		<?php echo'<a style="text-decoration:none;" href="#" onclick="draw_BBANDS(\''.$obj["Meta Data"]["2. Symbol"].'\',\'BBANDS\')">BBANDS   </a>'; ?>
		<?php echo'<a style="text-decoration:none;" href="#" onclick="draw_MACD(\''.$obj["Meta Data"]["2. Symbol"].'\',\'MACD\')">MACD   </a>'; ?>
		</tr>
		</table>
		</div>
		<div id="graph" style="width=100% !important">
		<?php
		$i=0; 
		foreach($obj["Time Series (Daily)"] as $key => $val)
		{
			if($i==0){$today=$key;}
			$d[]=explode("-",$key);
			$date_string1[]= (string)$d[$i][1]."/".(string)$d[$i][2];
			$price1[]=$val['4. close'];
		 	$volume1[] =$val['5. volume'];
		 	$i=$i+1;
		}
		$date_string=array_reverse($date_string1);
		$price=array_reverse($price1);
		$volume=array_reverse($volume1);
		echo"<script> 
		var vol=".json_encode($volume)."
		var price=".json_encode($price)."
		var dd=".json_encode($date_string)."
		for(var i=0;i<vol.length;i++){
			vol[i]=(parseFloat(vol[i]))
		}
		for(var i=0;i<price.length;i++){
			price[i]=parseFloat(price[i])
		}
		var today=\"".$today."\"
		var today_arr= today.split('-')
		var today_str= today_arr[1]+'/'+today_arr[2]+'/'+today_arr[0]
		var min_f= parseFloat(Math.min.apply(Math, price));
		Highcharts.chart('graph', {
			chart: {
				borderColor: 'darkgray',
				borderWidth: 2,
				zoomType: 'xy'
			},
			title: {
				text: 'Stock Price ('+today_str+')'
			},
			subtitle: {
				useHTML: true,
				text: '<a target=\"_blank\" style=\"color: rgb(0, 0, 255); cursor: pointer; text-decoration: none;\" href=\"https://www.alphavantage.co/\">Source: Alpha Vantage</a>'
			},
			xAxis: [{
				categories: dd,
				showLastLabel: true,
				startOnTick: true,
				labels:{
					step: 1,
					align: 'right',
					rotation: -15
				},
				tickInterval: 5
			}],
			yAxis: [{ // Primary yAxis
				labels: {
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				title: {
					text: 'Stock Price',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				min: min_f
			}, { // Secondary yAxis
				title: {
					text: 'Volume',
					style: {
						color: Highcharts.getOptions().colors[1]
					}
				},
				tickInterval: 80000000,
				labels: {
		formatter: function () {
			var label = this.axis.defaultLabelFormatter.call(this);
			// Use thousands separator for four-digit numbers too
			if (/^[0-9]{4}$/.test(label)) {
				return Highcharts.numberFormat(this.value, 0);
			}
			return label;
		}
	},
				opposite: true
			}],
			tooltip: {
				shared: true
			},plotOptions: {
				series: {
					marker: {
						enabled: false
					}
				}
			},
			legend: {
				layout: 'vertical',
				align: 'right',
				verticalAlign: 'middle',
				
				backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
			},
			navigation: {
				buttonOptions: {
					enabled: true
				}
			},
			series: [{
				name: ".json_encode($obj["Meta Data"]["2. Symbol"]).",
				type: 'area',
				data: price,
				color: '#e52100'
				
			},{
				name: ".json_encode($obj["Meta Data"]["2. Symbol"])."+' Volume',
				type: 'column',
				yAxis: 1,
				color: '#ffffff',
				data: vol,
				tooltip: {
					valueSuffix: 'M'
				}
		
			}]
		});
		</script>";
		?>
		</div>
		<div id="rss_feed" style="text-align:center;" onclick="
		if(document.getElementById('arrow_img').src.indexOf('Gray_Arrow_Down')!=-1){
			document.getElementById('arrow_img').src='http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Up.png'
			document.getElementById('message').innerHTML='Click to hide stock news'
			document.getElementById('rss_table').style.visibility='visible'
			<?php $rss_url="https://seekingalpha.com/api/sa/combined/".$obj["Meta Data"]["2. Symbol"].".xml"; 
			$a=@file_get_contents($rss_url) or die("unable to fetch news for the symbol"); 
			$xml=new SimpleXMLElement($a) or die("Error: Cannot create object");
			$news= array(); 
			$i=0;
			foreach ($xml->channel->children() as $child)
			{
				if($child->getName()=="item"){
					$art_found=false;
					foreach ($child->children() as $c)
					{	
						if($c->getName()=="pubDate"){
							$pd=(string)$c;
						}
						if($c->getName()=="title"){
							$t=$c;
						}
						if($c->getName()=="link"&& strpos($c,"art")){
							$string_title=(string)"title".$i;
							$string_link=(string)"link".$i;
							$l=(string)$c;
							$art_found=true;
						}
					}
					if($art_found){
						$news[]=isset($l)?(string)$l:null;
						$news[]=isset($t)?(string)$t:null;
						$news[]=isset($pd)?$pd:null;
						$i=$i+3;
					}
					
				}
			}
			 echo "draw_rss()";
			?>
			
		}else{

			document.getElementById('arrow_img').src='http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png'
			document.getElementById('message').innerHTML='Click to show stock news'
			document.getElementById('rss_table').style.visibility='collapse'
		}
		">
		<div id="message" style="color: darkgray;" >Click to show stock news</div>
		<img id="arrow_img" width="30px" src="http://cs-server.usc.edu:45678/hw/hw6/images/Gray_Arrow_Down.png" ></div>
		<div id="rss_table"></div>
		</div>
		<script type="text/javascript">
		function formatDate(date) {
 			var monthNames = [
   				"Jan", "Feb", "Mar",
   				"Apr", "May", "Jun", "Jul",
    			"Aug", "Sep", "Oct",
    			"Nov", "Dec"
  				];
			var weekday = new Array(7);
			weekday[0] =  "Sun";
			weekday[1] = "Mon";
			weekday[2] = "Tue";
			weekday[3] = "Wed";
			weekday[4] = "Thu";
			weekday[5] = "Fri";
			weekday[6] = "Sat";

			var n = weekday[date.getDay()];

 			var day = date.getDate();
  			var monthIndex = date.getMonth();
 			var year = date.getFullYear();

  			return n+","+day + ' ' + monthNames[monthIndex] + ' ' + year+' '+date.getHours()+":"+date.getMinutes()+':'+date.getSeconds();
}


		function draw_rss(){
			var a=<?php echo json_encode($news); ?>;
			var str="<table class='rss_tab' valign='center' style=' margin-left:auto; margin-right:auto; border-collapse: collapse; border: 1px solid darkgray; background-color: #bfbfbf;'>";
			for(var i=0;i<a.length;i++)
			{
				
				var d= a[i+2]!=null?a[i+2].split('-')[0]:null;
				var link=a[i]!=null?a[i]:'';
				var title=a[i+1]!=null?a[i+1]:' ';
				str=str+"<tr><td style='collapse; border: 1px solid darkgray;'><a target=\"_blank\" style=\"text-decoration:none;\" href=\""+link+"\">"+title+"</a>"+"\xa0 \xa0 \xa0 \xa0"+"Published Time:  "+d+"</td></tr>"
				i=i+2
				if(i==14) break;
			}
			str=str+"</table>"
			document.getElementById('rss_table').innerHTML=str
			
		}
		function draw_price(){
			var vol=<?php echo json_encode($volume2); ?>;
			var price=<?php echo json_encode($price2); ?>;
			var dd=<?php echo json_encode($date_string2); ?>;
			var sym = <?php echo json_encode($obj["Meta Data"]["2. Symbol"]);?>;
			for(var i=0;i<vol.length;i++){
	
				vol[i]=parseFloat(vol[i])
				price[i]=parseFloat(price[i])
			}
			var today="<?php echo $today;?>";
			var today_arr= today.toString().split('-')
			var today_str= today_arr[1]+"/"+today_arr[2]+"/"+today_arr[0]
			var min_f= parseFloat(Math.min.apply(Math, price));
			Highcharts.chart('graph', {
				chart: {
					borderColor: 'darkgray',
        			borderWidth: 2,
					zoomType: 'xy'
				},
				title: {
					text: 'Stock Price ('+today_str+')'
				},
				subtitle: {
					useHTML: true,
					text: '<a target="_blank" style="color: rgb(0, 0, 255); cursor: pointer; text-decoration: none;" href="https://www.alphavantage.co/">Source: Alpha Vantage</a>'
				},
				xAxis: [{
					categories: dd,
					showLastLabel: true,
					startOnTick: true,
					labels:{
						step: 1,
						align: 'right',
						rotation: -15
					},
					tickInterval: 5
				}],
				yAxis: [{ // Primary yAxis
					labels: {
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					title: {
						text: 'Stock Price',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					min: min_f
				}, { // Secondary yAxis
					title: {
						text: 'Volume',
						style: {
							color: Highcharts.getOptions().colors[1]
						}
					},
					
					labels: {
            			formatter: function () {
               			 var label = this.axis.defaultLabelFormatter.call(this);
                		// Use thousands separator for four-digit numbers too
                		if (/^[0-9]{4}$/.test(label)) {
                	    return this.value;
                		}
                		return label;
						}
            		},
					tickInterval: 80000000,
					opposite: true
				}],
				tooltip: {
					shared: true
				},plotOptions: {
					series: {
						marker: {
							enabled: false
						}
					}
				},
				legend: {
					layout: 'vertical',
					align: 'right',
					verticalAlign: 'middle',
					
					backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
				},
				series: [{
					name: sym,
					type: 'area',
					data: price,
					color: '#e52100'
					
				},{
					name: sym+' Volume',
					type: 'column',
					yAxis: 1,
					color: '#ffffff',
					data: vol,
					tooltip: {
						valueSuffix: 'M'
					}
			
				}]
			});
		}
		</script>
	<?php endif;?>
	<?php endif;?>
<?php endif;?>
</body>
</html>