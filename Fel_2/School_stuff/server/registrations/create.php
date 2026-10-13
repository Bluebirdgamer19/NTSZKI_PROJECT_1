<?php

include_once("../registration.php");
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(array("error" => "Method not allowed"));
    exit;
}

$request = json_decode(file_get_contents('php://input'), true);
if (!is_array($request)) {
    http_response_code(400);
    echo json_encode(array("error" => "Invalid request body"));
    exit;
}

$fullName = trim($request["fullName"] ?? "");
$schoolName = trim($request["schoolName"] ?? "");
$isDormitory = (int) (($request["isDormitory"] ?? false) ? 1 : 0);
$isFinalYear = (int) (($request["isFinalYear"] ?? false) ? 1 : 0);
$interests = $request["interests"] ?? array();

if ($fullName === "" || $schoolName === "" || !is_array($interests)) {
    http_response_code(400);
    echo json_encode(array("error" => "Missing required fields"));
    exit;
}

$cleanInterests = array();
foreach ($interests as $interest) {
    $cleanInterest = trim((string) $interest);
    if ($cleanInterest !== "") {
        $cleanInterests[] = $cleanInterest;
    }
}
$cleanInterests = array_values(array_unique($cleanInterests));

if (count($cleanInterests) === 0) {
    http_response_code(400);
    echo json_encode(array("error" => "At least one interest is required"));
    exit;
}

$registration = new Registration();
$result = $registration->create($fullName, $schoolName, $cleanInterests, $isDormitory, $isFinalYear);

if ($result === true) {
    http_response_code(201);
    echo json_encode(array("success" => true));
    exit;
}

http_response_code(500);
echo json_encode(array("error" => "Failed to save registration"));
