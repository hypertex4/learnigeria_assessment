<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
include_once('../classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    $fullname = htmlspecialchars(strip_tags($data->fullname));
    $user_id = htmlspecialchars(strip_tags($data->user_id));
    $email = htmlspecialchars(strip_tags($data->email));
    $ass_status = htmlspecialchars(strip_tags($data->ass_status));

    if (!empty($fullname) && !empty($email) && !empty($user_id) && !empty($ass_status)) {
        $result = $client->update_user_profile_by_user_id($user_id,$fullname,$email,$ass_status);
        if ($result==true) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Profile has been successfully updated."));
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