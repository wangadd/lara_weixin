<?php
header("content-type:text/html;charset=utf-8");
$username=empty($_POST['username'])?"":$_POST['username'];
//echo "$username";
$content=empty($_POST['content'])?"":$_POST['content'];
$time=date('Y-m-d H:i:s',time());
$con=mysqli_connect('127.0.0.1','root','root','wish');
$sql="insert into wish(w_name,w_content,w_time)values('$username','$content','$time')";
//echo $sql;die;
$res=mysqli_query($con,$sql);
if($res){
	echo '太棒了！恭喜你许愿成功！！！';
header("refresh:1;url='http://localhost/wish/wish/'");
}else{
	echo '很遗憾许愿失败';
header("refresh:1;url='register.php'");
}
?>