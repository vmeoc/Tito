<html>
    <head></head>

<?php

$servername = "localhost";
$username = "root";
$password = "Tito2016";
$dbname="TitoDB_old";
$tablename ="TitoTable";

function InitDB(){
    global $servername;
    global $username;
    global $password;
    global $dbname;
    
// Create connection 
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database
$sql = "CREATE DATABASE $dbname";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}
$conn->close();
}

function InitTable (){
    global $servername;
    global $username;
    global $password;
    global $dbname;
    global $tablename;
    
// Create connection 
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// sql to create table
$sql = "CREATE TABLE $tablename (
id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
home VARCHAR(50) NOT NULL,
work VARCHAR(50) NOT NULL,
hour_home_departure VARCHAR(50) NOT NULL,
hour_work_departure VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table $tablename created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
}

InitDB();
InitTable();


?>
</hmtl>

