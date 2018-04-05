<?php

const GOOGLE_API_KEY = "AIzaSyA5ZDRG9r8hBWrtlGsEuJKU2KBg_cCV_Qk";

// Extract parameters from URL
$needed_params = array("home_addr", "home_time", "work_addr", "work_time");
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
        $result[$day] = array("home_to_work" => array("time" => null), "work_to_home" => array("time" => null));

        $home_time = strtotime("next " . $day . "+" . substr($params['home_time'], 0, 2) . "hours +" . substr($params['home_time'], 3, 2) . "minutes");
        $work_time = strtotime("next " . $day . "+" . substr($params['work_time'], 0, 2) . "hours +" . substr($params['work_time'], 3, 2) . "minutes");

        // Home to work
        $home_response = callGoogleApi($params['home_addr'], $params['work_addr'], $home_time);
        if ($home_response->status !== "OK") {
            throw new \Exception("Google error response status: " . $home_response->status, 502);
        }
        $result[$day]['home_to_work']['time'] = $home_response->routes[0]->legs[0]->duration_in_traffic->value;

        // Work to home
        $work_response = callGoogleApi($params['work_addr'], $params['home_addr'], $work_time);
        if ($work_response->status !== "OK") {
            throw new \Exception("Google error response status: " . $work_response->status, 502);
        }
        $result[$day]['work_to_home']['time'] = $work_response->routes[0]->legs[0]->duration_in_traffic->value;

        $result[$day]['total'] = $result[$day]['work_to_home']['time'] + $result[$day]['home_to_work']['time'];
        $result['total'] += $result[$day]['total'];
    }
    return $result;
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

    $url = "https://maps.googleapis.com/maps/api/directions/json?origin=" . $origin . "&destination=" . $dest . "&departure_time=" . $time . "&traffic_model=best_guess&key=" . GOOGLE_API_KEY;

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
<<<<<<< HEAD
    if (!$_GET["home_addr"]) {
       $LogLine = "_GET EST NULL;TITO-App requested from UI";
       error_log(print_r($LogLine, TRUE));
       $params = $_POST;
    } else {
       $LogLine = "_POST EST NULL;TITO-App requested from URL";
       error_log(print_r($LogLine, TRUE));
       $params = $_GET;
    }

    // Adding LOG
    $home_for_log = $params['home_addr'];
    $work_for_log = $params['work_addr'];
    $LogLine = "TITO-App;home=\"$home_for_log\";work=\"$work_for_log\";";
    error_log(print_r($LogLine, TRUE));

=======
    $params = $_GET;
>>>>>>> parent of 1c202d5... add range feature
    $result = array();
    foreach ($needed_params as $param_name) {
        if (!isset($params[$param_name])) {
            throw new \Exception("Missing parameter '" . $param_name . "' for this API function.", 501);
        }
        $result[$param_name] = $params[$param_name];
    }
    return $result;
}
