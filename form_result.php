<html>
    <html lang="en">
        <head>
             <!-- Bootstrap Core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/stylish-portfolio.css" rel="stylesheet">
            
            
        </head>     
        <body>
  <?php
         
$weekdays_home_departure = array("Monday","Tuesday","Wednesday","Thursday","Friday");
$weekdays_work_departure = array("Monday","Tuesday","Wednesday","Thursday","Friday");
$weekdays_home_duration = array("Monday","Tuesday","Wednesday","Thursday","Friday");
$weekdays_work_duration = array("Monday","Tuesday","Wednesday","Thursday","Friday");
$stats = array("week"=>"0","month"=>"0","year"=>"0","life"=>"0");

//SQL variables
$servername = "localhost";
$username = "root";
$password = "";

//Obtention des infos de Google
function GetDataFromGoogle (){
    global $weekdays_home_duration;
    global $weekdays_work_duration;
    global $home;
    global $work;
    global $weekdays_home_departure;
    global $weekdays_work_departure;
    
      foreach ($weekdays_home_duration as $day) {
        
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=". $home . "&destination=" . $work . "&departure_time=" . $weekdays_home_departure[$day] . "&traffic_model=best_guess&key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk";
         
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
   
        $response = json_decode($response);

        $weekdays_home_duration[$day] = $response->routes[0]->legs[0]->duration_in_traffic->value;
        
      
    }

    
    foreach ($weekdays_work_duration as $day) {
        
        $url = "https://maps.googleapis.com/maps/api/directions/json?origin=". $work . "&destination=" . $home . "&departure_time=" . $weekdays_work_departure[$day] . "&traffic_model=best_guess&key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk";
         
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);
   
        $response = json_decode($response);
        

        
        $weekdays_work_duration[$day] = $response->routes[0]->legs[0]->duration_in_traffic->value;
      
    }

}


//convertit les données au format nécessaire pour Google
function dataconversion($hour_home_departure, $hour_work_departure) {
    
    //calcul des dates de départ de la maison
    global $weekdays_home_departure;
    foreach ($weekdays_home_departure as $day) {
        $weekdays_home_departure[$day] = strtotime("next ". $day . "+" . substr($hour_home_departure,0,2) . "hours +" . substr($hour_home_departure,3,2) . "minutes");
     }
    
    //calcul des dates de départ du travail
    global $weekdays_work_departure;
    foreach ($weekdays_work_departure as $day) {
        $weekdays_work_departure[$day] = strtotime("next ". $day . "+" . substr($hour_work_departure,0,2) . "hours +" . substr($hour_work_departure,3,2) . "minutes");
        }
}

//Show maps
function showmap() {
    global $home;
    global $work;
    
   // echo '<div class="jumbotron text-center">';
    echo '<iframe width="100%" height="100%" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/directions?origin=' . $home . '&destination=' . $work . '&key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk" allowfullscreen></iframe>';
   //  echo '</div>';
          
}

//create stats
function CreateStats(){
    global $stats;
    global $weekdays_home_duration;
    global $weekdays_work_duration;
    
    foreach ($weekdays_work_duration as $day) {
      
        $stats["week"] = $stats["week"] + $weekdays_home_duration[$day] + $weekdays_work_duration[$day];
       //workaround car le tableau a un offset de trop!
        if ($day =="Friday") { break;}
    }
    
    $stats["month"] = $stats["week"] * 4;
    $stats["year"] = $stats["month"] * 12;
    $stats["life"] = $stats["year"] * 40;
}

//conversion d'une durée en secondes en format humain
function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}

//Affichage du tableau
function DisplayTable() {
    global $stats;
    global $weekdays_home_duration;
    global $weekdays_work_duration; 
    global $home;
    global $work;
    
    ?>
            
<div class="container">
    <div class="row">    
                    <div class="span12">
  <h2>Average commuting time</h2>
  
  <?php
    $home = str_replace(',%20France', '', $home);
    $work = str_replace(',%20France', '', $work);
    echo "<h2>" . str_replace('%20', ' ', $home) . " <-> " . str_replace('%20', ' ', $work) . "</h2>";
    ?>
                    </div>
    </div>
  <table class="table table-hover">
    <thead>
      <tr>
          <th>#</th>
          <?php
          
          foreach ($weekdays_home_duration as $day) {
       echo "<th>" . $day . "</th>";
          }
          ?>
      </tr>
    </thead>
    <tbody>
        
      <tr>
          <th scope="row">Home -> Work</th>
          <?php
          foreach ($weekdays_home_duration as $day) {
       echo "<td>" . secondsToTime($weekdays_home_duration["$day"]) . "</td>";
       //workaround car le tableau a un offset de trop!
        if ($day =="Friday") { break;}
          }
        ?>
      </tr>
      <tr>
          <th scope="row">Work -> Home</th>
        <?php
          foreach ($weekdays_work_duration as $day) {
       echo "<td>" . secondsToTime($weekdays_work_duration["$day"]) . "</td>";
       //workaround car le tableau a un offset de trop!
        if ($day =="Friday") { break;}
          }
        ?>
      </tr>
      <tr>
     <th scope="row">Total</th>
    <?php
          foreach ($weekdays_work_duration as $day) {
       echo "<td>" . secondsToTime($weekdays_home_duration["$day"]+$weekdays_work_duration["$day"]) . "</td>";
       //workaround car le tableau a un offset de trop!
        if ($day =="Friday") { break;}
          }
        ?>
      </tr>
        
      </tr>
    </tbody>
  </table>
        </div>
            <?php

}
function DisplayStats()
{
       
    ?>
            
<div class="container">
    <div class="row">    
                    <div class="span12">
   
  
  <?php
    global $stats;
    echo "by week: ";
    echo secondsToTime($stats["week"]);
        echo "<br>"; 

    echo "by Month: ";
    echo secondsToTime($stats["month"]);
        echo "<br>"; 

    echo "by year: ";
    echo secondsToTime($stats["year"]);
        echo "<br>"; 

    echo "over a lifetime: ";
    echo secondsToTime($stats["life"]);
        echo "<br>"; 
        
           echo "</div>";
    echo "</div>";
    echo "</div>";

    
}

// Réception des variables
//$hour_home_departure = $_POST['hour_home_departure'];
//$hour_work_departure = $_POST['hour_work_departure'];
$hour_home_departure="08:00";
$hour_work_departure="17:00";

$home = $_POST['home'];
$work = $_POST['work'];

//nettoyage des variables
$home = str_replace(' ', '%20', $home);
$work = str_replace(' ', '%20', $work);
    

//Conversion
dataconversion($hour_home_departure,$hour_work_departure);
GetDataFromGoogle();
CreateStats();
DisplayTable();
DisplayStats();
showmap();

//gestion SQL
// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
// Create database
$sql = "CREATE DATABASE TitoDB";
if ($conn->query($sql) === TRUE) {
    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();

?>


                </body>
    </html>