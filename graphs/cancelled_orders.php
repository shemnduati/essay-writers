<?php
include('phpgraphlib-master/phpgraphlib.php');
//include('phpgraphlib-master/phpgraphlib_pie.php');
$graph = new PHPGraphLib(350,280);
//fetch 
$dataArray = array();
//get data from database
include("connect.php");
$sql="SELECT item, quantity FROM produce WHERE type ='Livestock'";
$result = mysql_query($sql) or die('Query failed: ' . mysql_error());
if ($result) {
	while($row=mysql_fetch_array($result)){
		$item=$row['item'];
		$quantity=$row['quantity'];
		//Adding data to the array
	$dataArray[$item]=$quantity;
	//print_r($dataArray);
	}
}
$graph->setBackgroundColor("black");
$graph->addData($dataArray);
$graph->setBarColor('255, 255, 204');
$graph->setTitle('Livestock Comparison Graph');
$graph->setTitleColor('yellow');
$graph->setupYAxis(12, 'yellow');
$graph->setupXAxis(25, 'yellow');
$graph->setGrid(false);
$graph->setGradient('silver', 'gray');
$graph->setBarOutlineColor('white');
$graph->setTextColor('white');
$graph->setDataPoints(true);
$graph->setDataPointColor('yellow');
$graph->setLine(true);
$graph->setLineColor('yellow');
$graph->createGraph();






?>