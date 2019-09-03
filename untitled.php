<?php
include("php/connect.php");

$qry_views = mysqli_query($link,"select * from prime_order");
while($rs_views = mysqli_fetch_array($qry_views)){
	$order_id = $rs_views['order_id'];
	$writer_level = $rs_views['writer_level'];
	$qry = mysqli_query($link,"select * from view_order where order_id = '".$order_id."' and writer_level = '".$writer_level."'");
	$count = mysqli_num_rows($qry);
	if($count == 0){
		$sqlinsert = "INSERT INTO view_order (`order_id`,`writer_level`) VALUES ('".$order_id."', '".$writer_level."')";
		//mysqli_query($link,$sqlinsert);
		$query_insert = mysqli_query($link,$sqlinsert) or die(mysqli_error($link));
					
	}
}
?>