<?php

session_start();
$p_id=$_SESSION['opid'];
$p_name=$_SESSION['pname'];
$price=$_SESSION['price'];
$picture=$_SESSION['picture'];
$ratings=$_SESSION['ratings'];
$description=$_SESSION['description'];

//for database connection
$con=mysqli_connect('localhost', 'root', '','my');
if(!$con){
	 die ( "Connection not success" .mysql_error());
}

//creating table for review if it does not exists
$create = "CREATE TABLE if not exists review(
				id int,
				email VARCHAR(50),
				p_id int,
				review VARCHAR(3000) NOT NULL,
				ratings float,
				Foreign key(id) references register(id),
				Foreign key(email) references register(email),
				Foreign key(p_id) references products(p_id)
			)";
			$revi=mysqli_query($con,$create);
			if(!$revi){
				 die ( "Create not success" .mysql_error());
			}


						//creating table for favourites if it does not exists
						$create_fav= "CREATE TABLE if not exists favourites(
													id int,
													email VARCHAR(50),
													p_id int,
													p_name varchar(30),
													price int,

													picture varchar(100),

													Foreign key(id) references register(id),
													Foreign key(email) references register(email),
													Foreign key(p_id) references products(p_id)
												)";
												$carr=mysqli_query($con,$create_fav);
												if(!$carr){
													 die ( "Create not success" .mysql_error());
												}



//review
//review is successfull only if user is logged in
if( isset($_POST['review']) ){
	if( isset(($_SESSION['username'])) ){
		$id=$_SESSION['id'];
		$email=$_SESSION['email'];
		$review=$_POST['review'];
		$rating=$_POST['rating'];
		//to check if the logged in user has already inserted a review
		$check=mysqli_query($con,"select * from review where id=$id and p_id=$p_id") OR die(mysql_error());
		$check1=mysqli_fetch_assoc($check);
		//for user inputting review for the first time
		if($check1==NULL){
			$rev="INSERT into review values($id,'$email',$p_id,'$review',$rating) ";
			$in=mysqli_query($con,$rev);

			if(!$in){
				die ( "Insert not success" .mysql_error());
			}
			else{
				echo "<script> alert('Your review has been added'); </script>";
			}
		}
		//if review is already inputted for the logged in user then it gets updated
		else{
		$rev="Update review set review='$review',ratings=$rating where id=$id and p_id=$p_id";
		$in=mysqli_query($con,$rev);
		if(!$in){
			 die ( "Update not success" .mysql_error());
		}
		else{
			echo "<script> alert('Your previous review has been updated'); </script>";
		}
}
	//for calculating average rating from the all the reviews
	$rat=mysqli_query($con,"select avg(ratings) from review where p_id=$p_id") or die(mysql_error());
	$avg_rat=mysqli_fetch_array($rat);
	//update the product ratings after a user has added a rating
	$ratings=round($avg_rat[0],2);
	$update_rat=mysqli_query($con,"update products set ratings=$ratings where p_id=$p_id ");




	}
//unsuccessful review, because the user is not logged in
else{
		echo "<script> alert('Please login first');</script>";
	}
}

?>

<!DOCTYPE html>
<html>

<head >
	<title>Product</title>
<link rel="icon" type="image/png" href="css\images\favicon.png">
  <link rel="manifest" href="manifest.json">
    <meta name="viewport" content="width=device-width, intial-scale=1" >
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <link rel="stylesheet" type="text/css" href="index.css?version=699">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    
	<link rel="icon" type="image/png" href="css\images\favicon.png">
	<link rel="stylesheet" type="text/css" href="menu.css?version=69">

	<link rel="icon" type="image/png" href="css\images\favicon.png">
	<title><?php echo $p_name; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="css\product.css?version=69">

</head>
<body>
	<nav>
	<div class="cover">
     <div class="header">
          <h2 class="logo"><span class="blueLogo">Kup</span><span class="PinkLogo">Cakes</span></h2>
          <input type="checkbox" id="chk">
          <label for="chk" class="show-menu-btn">
            <i class="fas fa-bars"></i>
          </label>

          <ul class="menu">
            <a href="index.php" id="home">Home</a>
            <a href="about_us2.html" id="aboutus">About</a>
            <a href="menu.php" id="services">menu</a>
            
            <label for="chk" class="hide-menu-btn">
              <i class="fas fa-times"></i>
            </label>
          </ul>
     </div>
    </div>	    
  </nav>

	<div id='cartinfo' style="margin-top: 80px">
		im cart, nice to meet you.
		<div id='close' onclick="document.getElementById('cartinfo').style.display='none'">Close</div>
	</div>

  <h1 class="pname" style="margin-top: 120px"><u><?php echo $p_name; ?></u></h1>
  <div class='info1'>

    <img id='img' src="<?php echo $picture; ?>">

    <div class="detail">
				<div class='rating'>
      	Ratings:<?php
				if($ratings){
				for($i=1; $i<=5;$i++){
					if($i<=$ratings){
					echo " <img src='css\images\star1.png'>";
				}
				else{
					echo " <img src='css\images\star.png'>";
				}
			}
		}
		else{
			echo " Not available";
		}
			 ?>
			</div>
			<div class='price'>
				Price:<?php echo $price; ?>
			</div>

		<div id='descriptions'>
      <u>Description: </u><?php echo $description; ?>
		</div>
		<div id='cart'>
			<div class="fav">
				<?php
				if( isset($_SESSION['id']) ){
				$id=$_SESSION['id'];
				$check=mysqli_query($con,"select * from favourites where id=$id and p_id=$p_id") OR die(mysql_error());
				$check1=mysqli_fetch_array($check);
				//for user inputting review for the first time

				if($check1[0]==''){
					$_SESSION['flag']=0;
					echo "<img class='add_fav' src='products\like.png'  onclick='changepage();' >";
				}
				else{
					$_SESSION['flag']=1;
					echo "<img class='add_fav' src='products\blike.png'  onclick='changepage();' >";

				}
			}
				?>
				<script>
					function changepage(){
						location.href='add_fav.php';

					}
				</script>

			</div>
      <input type="button" value="DONE" onclick=location.href='menu.php'>
	<input type="button" value="Order" onclick=location.href='order.php'>
		</div>
    </div>
  </div>
<div class="review_box">
	<div class="add_review">
	<h2>Add your own review</h2>
	<form method='post' action="<?=$_SERVER['PHP_SELF'];?>">
		<input type='text' name='review' placeholder="add review here..." required>
		<select  name='rating' >
			<option value="1">1</option>
			<option value="2">2</option>
			<option value="3">3</option>
			<option value="4">4</option>
			<option value="5">5</option>
		</select>
		<input type='submit'>
	</form>
</div>
<?php
$que="SELECT * FROM review where p_id=$p_id";
$data = mysqli_query($con,$que) or die('No Records Found');
?>
<div class='reviews'>
		<p>Reviews of Verified user </p>
	<?php
	while($info = mysqli_fetch_assoc( $data)){
		$user_id=$info['id'];
		$user_email=$info['email'];
		$pro_id=$info['p_id'];
		$pro_review=$info['review'];
		$pro_rating=$info['ratings'];


	?>

<div class='review'>

<div class='rev_user'>
	<?php echo "<img src='css\images\capture.png'>  ".$user_email; ?>
</div>
<div class=rev_rat>
Ratings:<?php
for($i=1; $i<=5;$i++){
	if($i<=$info['ratings']){
	echo " <img src='css\images\star1.png' >";

}
else{
	echo " <img src='css\images\star.png' >";
}
}


?>

</div>
	<div class='rev_review'>
	<?php echo 'Review: '.$pro_review; ?>
	</div>
</div>
<?php }?>
</div>

    <div class="footer" style=" margin-top: 50px">
    <div id="map" style= "height: 375px;"></div>
      <!-- Replace the value of the key parameter with your own API key. -->
    <div class="info">

      <h1>REACH US</h1>
      <h2>Address:</h2>
      <p>St. Francis Institute of Technology<br>Sardar Vallabhai Patel Rd, Near Bhagwati Hospital, Mount Poinsur, Borivali West, Mumbai, Maharashtra 400103</p>
      <h2>Phone number:</h2>
      <p>+91 9004780857/9876543210</p>
      <h2>Our Centres:</h2>
      <p><a href="contact.xml">Click here to get the list of our centres in INDIA</a></p>
      <div class="p-sm1">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
          </div>
    </div>
    </div>
    </div>

<script async defer
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCa75D5faK3aPSFQ7o1AH9RiAJYX_VA1T4&callback=initMap">
</script>

<script type="text/javascript">
// Initialize and add the map
function initMap() {
  // The location of Uluru
  var uluru = {lat: 19.18117, lng: 72.854201};
  var uluru1 = {lat: 25, lng: 80};
  // The map, centered at Uluru
  var map = new google.maps.Map(document.getElementById('map'), {zoom: 4, center: uluru});
  // The marker, positioned at Uluru
  var marker = new google.maps.Marker({position: uluru, map: map});
  var marker1 = new google.maps.Marker({position: uluru1, map: map});
}
</script>


<?php
mysqli_close($con);
?>
</body>
