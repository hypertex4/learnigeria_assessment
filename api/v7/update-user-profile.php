<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
include_once('../classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    $user_name = htmlspecialchars(strip_tags(strtoupper($data->user_name)));
    $user_email = htmlspecialchars(strip_tags($data->user_email));
    $user_id = htmlspecialchars(strip_tags($data->user_id));
    $phone = htmlspecialchars(strip_tags($data->phone));

    if (!empty($user_name) && !empty($user_email) && !empty($user_id)) {
        $result = $client->update_user_personal_profile($user_id,$user_name,$user_email,$phone);
        if ($result==true) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Your account profile has been successfully updated."));
        } else if ($result=="no_change"){
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update profile, no changes found."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Failed to update profile."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Fill all required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}

?>