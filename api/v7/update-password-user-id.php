<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
include_once('../classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    $password = htmlspecialchars(strip_tags(($data->password)));
    $user_id = htmlspecialchars(strip_tags($data->user_id));
    $user_email = htmlspecialchars(strip_tags($data->user_email));
    $confirm_password = htmlspecialchars(strip_tags($data->confirm_password));

    if (!empty($password) && !empty($user_id) && !empty($confirm_password)) {
        $user_data = $client->user_login($user_email);
        if (!empty($user_data)) {
            $password_used = $user_data['user_pwd'];
            if (empty(trim($password)) || strlen($confirm_password) < 6) {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Password/confirm password must be at least six(6) character"));
            } else {
                if (trim($password) !== trim($confirm_password)) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "New password combination did not match, try again."));
                } else {
                    if (password_verify($password, $user_data['user_pwd'])) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "New password already in use."));
                    } else {
                        $new_pwd = password_hash($password, PASSWORD_DEFAULT);
                        if ($client->update_user_password($new_pwd, $user_id)) {
                            http_response_code(200);
                            echo json_encode(array("status" => 1, "message" => "Password has been updated successfully. N.B. Password change takes effect on next login."));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "Failed to update user, contact admin via the help line"));
                        }
                    }
                }
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Invalid session, user currently in-active"));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "Kindly fill the required field"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>