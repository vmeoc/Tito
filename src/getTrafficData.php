<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$method = $_SERVER['REQUEST_METHOD'];
header('Content-Type: application/json');

try {
    if (strtoupper($method) !== "GET") {
        // If is not GET method
        throw new \Exception("Oups, request must be a GET method.");
    }
    if (!checkRequestArguments($_GET)) {
        // If missing arguments
        throw new \Exception("Oups, missing request arguments.");
    }

// Home data
    $hour_home_departure = $_GET['hour_home_departure'];
    $home = $_GET['home'];

// Work data
    $hour_work_departure = $_GET['hour_work_departure'];
    $work = $_GET['work'];

    $data = array('home' => array('place' => $home, 'time' => $hour_home_departure), 'work' => array('place' => $work, 'time' => $hour_work_departure));

    // Return JSON success response
    echo getJsonResponse($data);
} catch (\Exception $e) {
    // Return JSON error response
    echo getErrorJsonResponse($e->getMessage(), 500);
}
exit(0);

//------------------------------------------------------------------------------

/**
 * Check the request arguments
 * 
 * @param array $args
 * @return boolean
 */
function checkRequestArguments(array $args) {
    if (!isset($args['hour_home_departure']) || !isset($args['hour_work_departure']) || !isset($args['home']) || !isset($args['work'])) {
        return false;
    }
    return true;
}

/**
 * Get a JSON response as a string.
 * 
 * @param array $data
 * @param int $code
 * @param mixed $error
 * @return string
 * @throws \Exception
 */
function getJsonResponse(array $data, $code = 200, $error = null) {
    if (!is_int($code)) {
        throw new \Exception("JSON code response must be an integer.");
    }
    $result = array('code' => $code, 'data' => $data);
    if ($error !== null) {
        $result['error'] = $error;
    }
    return json_encode($result);
}

/**
 * Get a error JSON response as a string
 * 
 * @param mixed $error
 * @param int $code
 * @return string
 */
function getErrorJsonResponse($error, $code = 404){
    return getJsonResponse(array(), $code, $error);
}
