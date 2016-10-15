<html>
    <html lang="en">
        <head></head>     
        <body>
  <?php
         
$weekdays_home_departure = array("Monday","Tuesday","Wednesday","Thursday","Friday");
$weekdays_work_departure = array("Monday","Tuesday","Wednesday","Thursday","Friday");



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
// Réception des variables
$hour_home_departure = $_GET['hour_home_departure'];
$hour_work_departure = $_GET['hour_work_departure'];

//Conversion
dataconversion($hour_home_departure,$hour_work_departure);
?>

<div class="jumbotron text-center">
    <iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/directions?origin=verri%C3%A8res%20le%20buisson&destination=La%20d%C3%A9fense&key=AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk" allowfullscreen></iframe>
     </div>
          

            </body>
    </html>