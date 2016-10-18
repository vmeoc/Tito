<html>
    <html lang="en">
        <head></head>     
        <body>
  <?php
         
$weekdays_home_departure = array("Monday","Tuesday","Wednesday","Thursday","Friday");
$weekdays_work_departure = array("Monday","Tuesday","Wednesday","Thursday","Friday");
$weekdays_home_duration = array("Monday","Tuesday","Wednesday","Thursday","Friday");
$weekdays_work_duration = array("Monday","Tuesday","Wednesday","Thursday","Friday");
$stats = array("week"=>"0","month"=>"0","year"=>"0","life"=>"0");

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
    
    echo '<div class="jumbotron text-center">';
    echo '<iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/directions?origin=' . $home . '&destination=' . $work . '&key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk" allowfullscreen></iframe>';
     echo '</div>';
          
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
    
    echo "<br>";
    echo "time spent in transport:";
    echo "<br>";
    echo "per week: " . secondsToTime($stats["week"]);
    echo "<br>";
    echo "per month: " . secondsToTime($stats["month"]);
    echo "<br>";
    echo "per year: " . secondsToTime($stats["year"]);
    echo "<br>";
    echo "per life: " . secondsToTime($stats["life"]);
    echo "<br>";
}

//conversion d'une durée en secondes en format humain
function secondsToTime($seconds) {
    $dtF = new \DateTime('@0');
    $dtT = new \DateTime("@$seconds");
    return $dtF->diff($dtT)->format('%a days, %h hours, %i minutes and %s seconds');
}

// Réception des variables
$hour_home_departure = $_POST['hour_home_departure'];
$hour_work_departure = $_POST['hour_work_departure'];
$home = $_POST['home'];
$work = $_POST['work'];

//nettoyage des variables
$home = str_replace(' ', '%20', $home);
$work = str_replace(' ', '%20', $work);
    

//Conversion
dataconversion($hour_home_departure,$hour_work_departure);
GetDataFromGoogle();
CreateStats();
showmap();


?>


                </body>
    </html>