<?php

include_once("../registration.php");
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] !== "GET") {
    http_response_code(405);
    echo json_encode(array("error" => "Method not allowed"));
    exit;
}

$registration = new Registration();
echo json_encode($registration->getStats());
