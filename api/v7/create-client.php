<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once('../config/database.php');
include_once('../classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $client_fullname = htmlspecialchars(strip_tags($data->client_fullname));
    $organisation_name = strtoupper(htmlspecialchars(strip_tags($data->organisation_name)));
    $client_email = htmlspecialchars(strip_tags($data->client_email));
    $client_mobile = htmlspecialchars(strip_tags($data->client_mobile));
    $client_pwd = htmlspecialchars(strip_tags($data->client_pwd));
    $pwd_confirm = htmlspecialchars(strip_tags($data->pwd_confirm));

    $c_id = rand(1000000,9999999);

    if (!empty($client_fullname) && !empty($organisation_name) && !empty($client_email) && !empty($client_mobile) && !empty($client_pwd) && !empty($pwd_confirm) && !empty($c_id)) {
        if ($client_pwd !== $pwd_confirm){
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Password not matched."));
        } else {
            $email_data = $client->check_client_email($client_email);
            $org_name_data = $client->check_client_org_name($organisation_name);
            if (!empty($email_data)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Client account with ".$client_email." already exist."));
            } elseif (!empty($org_name_data)){
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Organisation name with ".$organisation_name." already exist."));
            } else {
                $client_data = $client->create_client($c_id,$client_fullname,$organisation_name,$client_email,$client_mobile,$client_pwd);
                if ($client_data) {
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "message" => "Client account has been successfully created."));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Server error, could not create client instance"));
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