<?php

include_once("../registration.php");
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] !== "DELETE" && $_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(array("error" => "Method not allowed"));
    exit;
}

$id = 0;
if ($_SERVER["REQUEST_METHOD"] === "DELETE") {
    parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $query);
    $id = (int) ($query["id"] ?? 0);
} else {
    $request = json_decode(file_get_contents('php://input'), true);
    if (is_array($request)) {
        $id = (int) ($request["id"] ?? 0);
    }
}

if ($id <= 0) {
    http_response_code(400);
    echo json_encode(array("error" => "Invalid id"));
    exit;
}

$registration = new Registration();
$deleted = $registration->delete($id);

if ($deleted === true) {
    http_response_code(200);
    echo json_encode(array("success" => true));
    exit;
}

http_response_code(404);
echo json_encode(array("error" => "Registration not found"));
