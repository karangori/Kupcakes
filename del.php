//to delete a user
<?php

$em=$_POST['email'];
$ps=$_POST['pass'];

//creating a connection variable
$con=mysqli_connect('localhost', 'root', '','my');
if(!$con){
  echo "con cond";
	 die ( "Connection not success" .mysql_error());
}


$que="DELETE FROM register where email='".mysqli_real_escape_string($con,$em)."' and password='".mysqli_real_escape_string($con,$ps)."'";
//$que="SELECT * FROM register where email='".$em."' and password='".$ps."'";

$data = mysqli_query($con,$que) or die('No Records Found');

if($data){
  echo "<script> alert('Account deleted successfully');</script>";
}


  echo "<script>location.href='delete.html'</script>";
//echo '<a href="menu.php" id="menu">Menu</a>';

mysqli_close($con);

?>
