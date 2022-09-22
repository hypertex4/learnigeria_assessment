<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once('../config/database.php');
include_once('../classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $fullname = htmlspecialchars(strip_tags($data->fullname));
    $client_id = strtoupper(htmlspecialchars(strip_tags($data->client_id)));
    $email = htmlspecialchars(strip_tags($data->email));
    $ass_status = htmlspecialchars(strip_tags($data->ass_status));
    $password = htmlspecialchars(strip_tags($data->password));
    $confirm_password = htmlspecialchars(strip_tags($data->confirm_password));

    $user_id = rand(1000000,9999999);

    if (!empty($fullname) && !empty($client_id) && !empty($email) && !empty($ass_status) && !empty($password) && !empty($confirm_password) && !empty($user_id)) {
        if ($password !== $confirm_password){
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Password not matched."));
        } else {
            $email_data = $client->check_user_email($email);
            if (!empty($email_data)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Assessor account with ".$email." already exist."));
            }  else {
                $client_data = $client->create_user_assessor($user_id,$client_id,$fullname,$email,$ass_status,$password);
                if ($client_data) {
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Assessor account has been successfully created."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Server error, could not create assessor instance"));
                }
            }
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