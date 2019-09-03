<?php
include('phpgraphlib-master/phpgraphlib.php');
$graph = new PHPGraphLib(650,380);
$dataArray = array();
//get data from database
include("php/connect.php");
$sql="SELECT country,COUNT(*) AS 'count' FROM tbl_signup GROUP BY country ";
$result = mysqli_query($link,$sql) or die('Query failed: ' . mysqli_error($link));
if ($result) {
	while($row=mysqli_fetch_array($result)){
		$item=$row['country'];
		$quantity=$row['count'];
		//Adding data to the array
	$dataArray[$item]=$quantity;
	//print_r($dataArray);
	}
}
$graph->addData($dataArray);
$graph->setTitle('Region Preference');
$graph->setBars(false);
$graph->setLine(true);
$graph->setDataPoints(true);
$graph->setDataPointColor('maroon');
$graph->setDataValues(true);
$graph->setDataValueColor('maroon');
$graph->setGoalLine(5);
$graph->setGoalLineColor('red');
$graph->createGraph();
?>