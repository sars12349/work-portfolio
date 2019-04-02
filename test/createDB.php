<?php
include_once("sqlConn.inc.php");

//create database
if($con -> query("CREATE DATABASE id7769590_jasondb"))
	echo "database created.";
else
	echo "Error creating database:".$con-> error;
	
//create table
$con->select_db("id7769590_jasondb");

$sql="
CREATE TABLE persons
(
personID int NOT NULL AUTO_INCREMENT,
PRIMARY KEY(personID),
FirstName varchar(15),
LastName varchar(15),
Age int
)";

//Execute query
$con -> query($sql);

$con -> close();
?>		