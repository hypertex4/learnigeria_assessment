<?php

// include headers
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once('../config/database.php');
include_once('../classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));
    if (!empty($data->reset_code) && !empty($data->password)) {
        $result = $client->resetPassword($data->reset_code, password_hash($data->password, PASSWORD_DEFAULT));
        if ($result=="true") {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Password Changed Successfully."));
        } elseif ($result=="invalid") {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Invalid reset code, reset password failed."));
        } elseif ($result=="expired") {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Expired reset code, reset password failed."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Error, could not update password"));
        }

    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Enter required field"));
    }
} else {
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Access Denied"));
}


?>