<?php
include('phpgraphlib-master/phpgraphlib.php');
include('phpgraphlib-master/phpgraphlib_pie.php');
$graph = new PHPGraphLibPie(400,200);
//fetch 
$dataArray = array();
//get data from database
include("php/connect.php");
$sql="SELECT assign_writer,COUNT(*) AS 'count' FROM tbl_signup GROUP BY assign_writer ";
$result = mysqli_query($link,$sql) or die('Query failed: ' . mysqli_error($link));
if ($result) {
	while($row=mysqli_fetch_array($result)){
		$item=$row['assign_writer'];
		$quantity=$row['count'];
		//Adding data to the array
	$dataArray[$item]=$quantity;
	//print_r($dataArray);
	}
}
$graph->addData($dataArray);
$graph->setBackgroundColor("#fff");
$graph->setTitle(date('Y-m-d'). " ". 'Writers status');
$graph->setLabelTextColor('50, 50, 50');
$graph->setLegendTextColor('50, 50, 50');
$graph->createGraph();






?>