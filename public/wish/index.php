<?php
header("content-type:text/html;charset=utf-8");
$con=mysqli_connect('127.0.0.1','root','root','wish');
$sql="select * from wish";
//echo $sql;die;
$res=mysqli_query($con,$sql);
while($arr=mysqli_fetch_assoc($res)){
	$array[]=$arr;
}
//print_r($array);die;
?>
