<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));
    $cli_id_or_em = htmlspecialchars(strip_tags(trim($data->cli_id_or_em)));
    $client_pwd = strtoupper(htmlspecialchars(strip_tags(trim($data->client_pwd))));

    if (!empty($cli_id_or_em) && !empty($client_pwd)){
        $user_data = $client->user_login($cli_id_or_em);
        if (!empty($user_data)){
            $password_used = $user_data['user_pwd'];
            if (password_verify($client_pwd,$password_used)) {
                $user_arr = array(
                    "user_sno"=>$user_data['user_sno'],
                    "user_id"=>$user_data['user_id'],
                    "user_name"=>$user_data['user_name'],
                    "user_email"=>$user_data['user_email'],
                    "user_type"=>$user_data['user_type'],
                    "user_active"=>$user_data['user_active'],
                    "usr_created_on"=>$user_data['usr_created_on'],

                    "client_sno"=>$user_data['client_sno'],
                    "client_id"=>$user_data['client_id'],
                    "organisation_name"=>$user_data['organisation_name'],
                    "client_mobile"=>$user_data['client_mobile']
                );
                if($user_data['user_type']=='support'){ $location= "support/"; }
                else { $location= "dashboard"; }
                http_response_code(200);
                echo json_encode(array("status"=>1,"user_details"=>$user_arr,"message"=>"User logged in successfully","location"=>$location));
                $_SESSION['USER_LOGIN'] = $user_arr;
            } else {
                http_response_code(200);
                echo json_encode(array("status"=>0,"message"=>"Incorrect password. Contact our support."));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Invalid Client ID / Email."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Kindly fill the required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status"=>503,"message"=>"Access Denied"));
}