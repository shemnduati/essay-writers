<?php
include('phpgraphlib-master/phpgraphlib.php');
include('phpgraphlib-master/phpgraphlib_pie.php');
$graph = new PHPGraphLib(450,380);
//fetch 
$dataArray = array();
//get data from database
include("php/connect.php");
$sql="SELECT reason,COUNT(*) AS 'count' FROM orders_canceled GROUP BY reason ";
$result = mysqli_query($link,$sql) or die('Query failed: ' . mysqli_error($link));
if ($result) {
	while($row=mysqli_fetch_array($result)){
		$item=$row['reason'];
		$quantity=$row['count'];
		//Adding data to the array
	$dataArray[$item]=$quantity;
	//print_r($dataArray);
	}
}
$graph->setBackgroundColor("black");
$graph->addData($dataArray);
$graph->setBarColor('255, 255, 204');
$graph->setTitle('cancelled orders');
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