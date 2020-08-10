//sql queries
<?php

//creating a connection variable
$con=mysqli_connect('localhost', 'root', '');
if(!$con){
	 die ( "Connection not success" .mysql_error());
}

//for selecting database
$db = mysqli_select_db($con,'my');
//creating database if database does not exists
if(!$db){
	$create_db="create database my";
	$database=mysqli_query($con,$create_db);
	if(!$database){
		die("Database creation failed ".mysql_error());
	}
	//selecting database after creating
	else{
		$db = mysqli_select_db($con,'my');

	}
}
//creating table for registered user if it already does not exists
$create = "CREATE TABLE if not exists register(
				id int PRIMARY KEY AUTO_INCREMENT,
        firstname VARCHAR(30) NOT NULL,
        lastname VARCHAR(30) NOT NULL,
        email VARCHAR(50) UNIQUE,
        password varchar(50)
        )";

$register=mysqli_query($con,$create);
if(!$register){
	 die ( "Create not success" .mysql_error());
}

//creating table for registered user if it already does not exists
$create = "CREATE TABLE if not exists products(
				p_id int PRIMARY KEY AUTO_INCREMENT,
        p_name  VARCHAR(30) NOT NULL,
        description VARCHAR(3000) NOT NULL,
				type VARCHAR(20),
        ratings float,
        price int,
        picture varchar(100)
        )";

$register=mysqli_query($con,$create);
if(!$register){
	 die ( "Create not success" .mysql_error());
}

mysqli_close($con);
?>
