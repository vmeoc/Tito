
  <?php
//array mgmt very nasty. To improve        
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
    
      foreach ($weekdays_home_duration as $key=>$day) {
        
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
        unset($weekdays_home_duration[$key]);
        
      
    }

    
    foreach ($weekdays_work_duration as $key=>$day) {
        
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
        unset($weekdays_work_duration[$key]);
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
    
    foreach ($weekdays_work_duration as $key=>$day) {
      
        $stats["week"] = $stats["week"] + $weekdays_home_duration[$key] + $weekdays_work_duration[$key];

    }
    
    $stats["month"] = $stats["week"] * 4;
    $stats["year"] = $stats["month"] * 12;
    $stats["life"] = $stats["year"] * 40;
}

//conversion d'une durée en secondes en format humain
function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    $result = $dtF->diff($dtT);
    $stringResult="";
    if ($result->format("%a") != 0 ) {$stringResult .= $result->format("%a") . " day" . ($result->format("%a") > 1 ? "s" : "") . " ";}
    if ($result->format("%h") != 0 ) {$stringResult .= $result->format("%h") . " hour" . ($result->format("%h") > 1 ? "s" : "") . " "; }
    $stringResult .= $result->format("%i") . " minute" . ($result->format("%i") > 1 ? "s" : "") . " "; 
    return $stringResult;
        
}

//Affichage du tableau
function DisplayTable() {
    global $stats;
    global $weekdays_home_duration;
    global $weekdays_work_duration; 
    global $home;
    global $work;
    
    ?>
            
<div >
    <div class="row">    
                    <div class="span12">
  <h2 id="titleResult">Average commuting time</h2>
  
  <?php
    $home = str_replace(',%20France', '', $home);
    $work = str_replace(',%20France', '', $work);
    echo "<h2>" . str_replace('%20', ' ', $home) . " <i class='fa fa-arrows-h'></i> " . str_replace('%20', ' ', $work) . "</h2>";
    ?>
                    </div>
    </div>
  <table class="table table-hover">
    <thead>
      <tr>
          <th>#</th>
          <?php
          
          foreach ($weekdays_home_duration as $key=>$day) {
       echo "<th>" . $key . "</th>";
          }
          ?>
      </tr>
    </thead>
    <tbody>
        
      <tr>
          <th scope="row">Home -> Work</th>
          <?php
          foreach ($weekdays_home_duration as $key=>$day) {
       echo "<td>" . secondsToTime($weekdays_home_duration["$key"]) . "</td>";

          }
        ?>
      </tr>
      <tr>
          <th scope="row">Work -> Home</th>
        <?php
          foreach ($weekdays_work_duration as $key=>$day) {
       echo "<td>" . secondsToTime($weekdays_work_duration["$key"]) . "</td>";
          }
        ?>
      </tr>
      <tr>
     <th scope="row">Total</th>
    <?php
          foreach ($weekdays_work_duration as $key=>$day) {
       echo "<td>" . secondsToTime($weekdays_home_duration["$key"]+$weekdays_work_duration["$key"]) . "</td>";
       //workaround car le tableau a un offset de trop!
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

function writeintodb() {
    //variables SQL
    $servername = $_SERVER['SERVER_NAME'];
    $username = "root";
    $password = "";
    $dbname="TitoDB";
    $tablename ="TitoTable";
        
    //Autres
    global $home;
    global $work;
    global $hour_home_departure;
    global $hour_work_departure;
    
    
// Create connection 
$conn = new mysqli($servername, $username, $password,$dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "INSERT INTO $tablename (home, work, hour_home_departure, hour_work_departure) VALUES ('$home', '$work', '$hour_home_departure', '$hour_work_departure')";

if ($conn->query($sql) === TRUE) {} else {
    echo "Error writing values: " . $conn->error;
}

$conn->close();
}

// Réception des variables
//$hour_home_departure = $_POST['hour_home_departure'];
//$hour_work_departure = $_POST['hour_work_departure'];
$hour_home_departure= $_POST['hour_home_departure'];
$hour_work_departure= $_POST['hour_work_departure'];

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
writeintodb ();


?>

