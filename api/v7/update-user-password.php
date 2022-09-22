<?php
ob_start(); session_start();
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
include_once('../classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    $curr_pwd = htmlspecialchars(strip_tags(($data->curr_pwd)));
    $np = htmlspecialchars(strip_tags($data->new_pwd));
    $r_np = htmlspecialchars(strip_tags($data->rpt_new_pwd));
    $user_id = htmlspecialchars(strip_tags($data->user_id));
    $user_email = htmlspecialchars(strip_tags($data->user_email));

    if (!empty($curr_pwd) && !empty($np) && !empty($r_np)) {
        // verify old password
        $user_data = $client->user_login($user_email);
        if (!empty($user_data)) {
            $password_used = $user_data['user_pwd'];
            if (password_verify($curr_pwd,$password_used)) {
                if (empty(trim($r_np)) || strlen($np) < 6) {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "New/Repeat password must be at least six(6) character"));
                } else {
                    if (trim($np) !== trim($r_np)) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "New password combination did not match, try again."));
                    } else {
                        if (password_verify($np, $user_data['user_pwd'])) {
                            http_response_code(200);
                            echo json_encode(array("status" => 0, "message" => "New password already in use."));
                        } else {
                            $new_pwd = password_hash($np, PASSWORD_DEFAULT);
                            if ($client->update_user_password($new_pwd, $user_id)) {
                                http_response_code(200);
                                echo json_encode(array("status" => 1, "message" => "Successfully Updated, your account has been updated. N.B. Password change takes effect on your next login."));
                            } else {
                                http_response_code(200);
                                echo json_encode(array("status" => 0, "message" => "Failed to update user, contact admin via the help line"));
                            }
                        }
                    }
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Invalid (current password) entered."));
            }
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Invalid session, try login again."));
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