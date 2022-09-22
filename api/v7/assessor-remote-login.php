<?php
// including vendor
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;

// include headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));
    // $headers = getallheaders();
    // print_r($headers['DevKey']);
//    $client_key = $data->developer_key;

//    if (!empty($client_key) && ($user->check_developer($client_key))){
        if (!empty($data->cli_id_or_em) && !empty($data->password)) {
            $user_data = $client->user_login($data->cli_id_or_em);
            if (!empty($user_data)){
                $password_used = $user_data['user_pwd'];
                if (password_verify($data->password,$password_used)) {
                    $iss = 'localhost';
                    $iat = time();
                    $nbf = $iat; // issued after 1 secs of been created
                    $exp = $iat + (86400 * 3650); // expired after 10years of been created
                    $aud = "my_user"; //the type of audience e.g. admin or customer

                    $user_arr_data = array(
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
                    $secret_key = getenv('HTTP_MY_SECRET');
                    $pay_info = array("iss"=>$iss, "iat"=>$iat, "nbf"=>$nbf, "exp"=>$exp, "aud"=>$aud,
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
                    $jwt = JWT::encode($pay_info, $secret_key, 'HS512');
                    http_response_code(200);
                    echo json_encode(array("status" => 1, "jwt" => $jwt, "message" => "User logged in successfully",));
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Incorrect password, try resetting your password."));
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Invalid credentials, assessor ID/Email does not match any record."));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Provide all required field"));
        }
//    } else {
//        http_response_code(200);
//        echo json_encode(array("status" => 0, "message" => "Oops, Unauthorized user! missing/invalid developer key"));
//    }
} else {
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Access Denied"));
}
