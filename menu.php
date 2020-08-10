<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

<link rel="icon" type="image/png" href="css\images\favicon.png">
  <link rel="manifest" href="manifest.json">
    <meta name="viewport" content="width=device-width, intial-scale=1" >
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css">
    <link rel="stylesheet" type="text/css" href="index.css?version=699">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
    
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    
	<link rel="icon" type="image/png" href="css\images\favicon.png">
	<link rel="stylesheet" type="text/css" href="menu.css?version=69">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
 crossorigin="anonymous">
 <style>
	 form, #results {
		 width: 80%;
		 margin: auto;
	 }
 </style>
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
  <?php
		$con=mysqli_connect('localhost', 'root', '','my');
		if(!$con){
			 die ( "Connection not success" .mysql_error());
		}
		else{
		$data = mysqli_query($con,"SELECT * FROM products ORDER BY p_id") or die('No Records Found');
	?>
<div class="background">
	<!--a hidden form containing value of id of picture clicked-->
<form name="id_sender" action="product.php" method="post" style="display: none">
	<input type="text" id="id_sender"  name="id_value">
	<input type='submit' id='sub' name='submit' >
</form>

  <div class="pt-5 pb-5" style="text-align: center; margin-top: 100px"><h2>Our Products</h2></div>
		<div class="row">
			<form name="search_users" id="search_users" action="users.php" method="post">
				<div class="input-group mb-3">
					<div class="input-group-prepend">
						<span class="input-group-text" id="">Search</span>
					</div>
					<input id="search" name="search" type="search" class="form-control" placeholder="Search for your cakes" aria-label="Search Users" aria-describedby="basic-addon2">
				</div>
			</form>
		</div>
		<div class="row">
			<div id="results"></div>
		</div>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
	 crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
	 crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
	 crossorigin="anonymous"></script>

	<script>
		$(function () {
			load_data();
			function load_data(query)
			{
				$.ajax({
					url:"livesearch.php",
					method:"POST",
					data:{query:query},
					success:function(data)
					{
						$('#results').html(data);
					}
				});
			}
			$('#search').keyup(function(){
				var search = $(this).val();
				if(search != '')
				{
					load_data(search);
				}
				else
				{
					load_data();
				}
			});
		});
	</script>

		<div class="product-container">
			<?php

				while($info = mysqli_fetch_assoc( $data)){
					$p_id=$info['p_id'];
					$p_name=$info['p_name'];
					$description=$info['description'];
					$price=$info['price'];
					$ratings=$info['ratings'];
					$picture=$info['picture'];

			?>

			<div class="card" id='<?php echo $p_id ?>' >
				<img src='<?php echo $picture; ?>' style="width:100%; height:200px;">
				<form name="product" method="post" action="test.php" >
				  <input type="hidden" name="pid" value='<?php echo $p_id ?>'>
				  <input type="text" value='<?php echo $p_name; ?>' readonly id="pname" name="pname">
				  <input type="text" value='<?php echo 'Price: '.' ₹'.$price; ?>' readonly class="price">
				  <input type="text" value='<?php echo 'Ratings: '.$ratings; ?>' readonly id="rating">
				  
				  <input type="Submit" name="" value="ORDER" class="button"><br>
				</form>
	  		</div>

		
	  		
	  		<?php } } ?>
 		</div>
    <div class="footer">
    <div id="map"></div>
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

</body>
</html>