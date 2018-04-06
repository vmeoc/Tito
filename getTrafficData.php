<?php

const GOOGLE_API_KEY = "AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk";

// Extract parameters from URL
$needed_params = array("home_addr", "home_time", "work_addr", "work_time","home_range");


$params = extractParametersFromUrl($needed_params);

$result = getTrafficData($params);

//------------------------------------------------------------------------------

/**
 *
 * @param type $params
 * @throws \Exception
 */
function getTrafficData($params) {
    $result = array('total'=>0);
    $days = array("monday", "tuesday", "wednesday", "thursday", "friday");

    foreach ($days as $day) {
        $result[$day] = array("home_to_work" => array("time" => null, 'range_less'=>[], 'range_more'=>[]), "work_to_home" => array("time" => null));

        $home_time = strtotime("next " . $day . "+" . substr($params['home_time'], 0, 2) . "hours +" . substr($params['home_time'], 3, 2) . "minutes");
        $work_time = strtotime("next " . $day . "+" . substr($params['work_time'], 0, 2) . "hours +" . substr($params['work_time'], 3, 2) . "minutes");

        $array_times = [];
        // Home to work
        $home_response = callGoogleApi($params['home_addr'], $params['work_addr'], $home_time);
        if ($home_response->status !== "OK") {
            echo "Google error response status (home): " . $home_response->status;
            throw new \Exception("Google error response status: " . $home_response->status, 502);
        }
        $result[$day]['home_to_work']['start'] = $home_time;
        $result[$day]['home_to_work']['time'] = $home_response->routes[0]->legs[0]->duration_in_traffic->value;

        for($i=(-1*$params['home_range']); $i<0;$i+=600){
            $time_tmp = $home_time + $i;
            $home_response = callGoogleApi($params['home_addr'], $params['work_addr'], $time_tmp);
            if ($home_response->status !== "OK") {
                echo "Google error response status (range): " . $home_response->status;
                throw new \Exception("Google error response status (range): " . $home_response->status, 502);
            }
            $result[$day]['home_to_work']['range_less'][$time_tmp.""] = [$home_response->routes[0]->legs[0]->duration_in_traffic->value, false, false];
            $array_times[$time_tmp] = $home_response->routes[0]->legs[0]->duration_in_traffic->value;
        }
        for($i=600; $i<=($params['home_range']);$i+=600){
            $time_tmp = $home_time + $i;
            $home_response = callGoogleApi($params['home_addr'], $params['work_addr'], $time_tmp);
            if ($home_response->status !== "OK") {
                echo "Google error response status (range): " . $home_response->status;
                throw new \Exception("Google error response status (range): " . $home_response->status, 502);
            }
            $result[$day]['home_to_work']['range_more'][$time_tmp.""] = [$home_response->routes[0]->legs[0]->duration_in_traffic->value, false, false];
            $array_times[$time_tmp] = $home_response->routes[0]->legs[0]->duration_in_traffic->value;
        }

        defineMinAndMax($result[$day]['home_to_work'], $array_times);

        // Work to home
        $work_response = callGoogleApi($params['work_addr'], $params['home_addr'], $work_time);
        if ($work_response->status !== "OK") {
            echo "Google error response status (work): " . $work_response->status;
            throw new \Exception("Google error response status (work): " . $work_response->status, 502);
        }
        $result[$day]['work_to_home']['start'] = $work_time;
        $result[$day]['work_to_home']['time'] = $work_response->routes[0]->legs[0]->duration_in_traffic->value;

        $result[$day]['total'] = $result[$day]['work_to_home']['time'] + $result[$day]['home_to_work']['time'];
        $result['total'] += $result[$day]['total'];
    }
    return $result;
}

function defineMinAndMax(&$result, $array_times){
    $min_time = $result['time'];
    $max_time = null;
    $min_hour = null;
    $max_hour = null;

    foreach($array_times as $hour => $time){
        if($time < $min_time){
            $min_hour = $hour;
            $min_time = $time;
        }
        if($time > $max_time){
            $max_hour = $hour;
            $max_time = $time;
        }
    }
    $result['min'] = false;
    if (isset($result['range_less'][$min_hour])){
        $result['range_less'][$min_hour][1] = true;
    } else if (isset($result['range_more'][$min_hour])){
        $result['range_more'][$min_hour][1] = true;
    } else{
        $result['min'] = true;
    }

    $result['max'] = false;
    if (isset($result['range_less'][$max_hour])){
        $result['range_less'][$max_hour][2] = true;
    } else if (isset($result['range_more'][$max_hour])){
        $result['range_more'][$max_hour][2] = true;
    } else{
        $result['max'] = true;
    }
}

/**
 * Call the Google API
 *
 * @param type $origin
 * @param type $dest
 * @param type $time
 * @return type
 */
function callGoogleApi($origin, $dest, $time) {

    $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . str_replace(' ', '%20', $origin) . "&destination=" . str_replace(' ', '%20', $dest) . "&departure_time=" . $time . "&traffic_model=pessimistic&key=" . GOOGLE_API_KEY;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_PROXYPORT, 3128);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response);
}

/**
 * Get an array of parameters from the URL
 * If a needed parameter is missing, throw an exception
 *
 * @param array $needed_params
 * @return array
 * @throws \Exception
 */
function extractParametersFromUrl(array $needed_params = array()) {
    if (empty($_GET['home_addr'])) {
       //$LogLine = "_GET EST NULL;TITO-App requested from UI";
       $LogLine = "Appel de TITO via POST;TITO-App requested from UI";
       error_log(print_r($LogLine, TRUE));
       $params = $_POST;
    } else {
       //$LogLine = "_POST EST NULL;TITO-App requested from URL";
       $LogLine = "Appel de TITO via GET;TITO-App requested from URL";
       error_log(print_r($LogLine, TRUE));
       $params = $_GET;
    }

    // Adding LOG
    $home_for_log = $params['home_addr'];
    $work_for_log = $params['work_addr'];
    $LogLine = "TITO-App;home=\"$home_for_log\";work=\"$work_for_log\";";
    error_log(print_r($LogLine, TRUE));

    $result = array();
    foreach ($needed_params as $param_name) {
        if (!isset($params[$param_name])) {
            echo "Missing parameter '" . $param_name . "' for this API function.";
            throw new \Exception("Missing parameter '" . $param_name . "' for this API function.", 501);
        }
        $result[$param_name] = $params[$param_name];
    }
    return $result;
}
