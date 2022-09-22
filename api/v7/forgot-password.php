<?php

// include headers
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

include_once('../config/database.php');
include_once('../classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));
//    if (empty($data->developer_key)) {
//        http_response_code(200);
//        echo json_encode(array("status" => 0, "message" => "Oops, Unauthorized developer, missing/invalid developer key"));
//    } else {
//        $client_key = $data->developer_key;
//        if (!empty($client_key) && ($user->check_developer($client_key))) {
            if (!empty($data->email)) {
                $email_check = $client->check_active_user_account($data->email);
                if (!empty($email_check)) {
                    $result = $client->passwordResetRequest($data->email);
                    if (!$result) {
                        http_response_code(200);
                        echo json_encode(array("status" => 0, "message" => "Reset password failed"));
                    } else {
                        $toEmail = $result['email_or_id'];
                        $subject = "Password Reset Request";
                        $content = "<html>
                        <head>
                            <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
                            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                            <title>LearNigeria Assessment</title>
                            <style>
                            @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,500;0,700;0,900;1,300&display=swap');
                            body {font-family: 'Roboto', sans-serif;font-weight: 400}
                            .wrapper {max-width: 600px;margin: 0 auto}
                            .company-name {text-align: left;background-color: #BF4300;padding: 20px;}
                            table {width: 100%;}
                            .table-head {color: #fff;}
                            .mt-3 {margin-top: 3em;}
                            a {text-decoration: none;}
                            .not-active { pointer-events: none !important; cursor: default !important; color:#740774;font-weight:bolder; }
                        </style>
                        </head>
                        <body>
                            <div class='wrapper'>
                            <table>
                                <thead>
                                    <tr>
                                        <th class='table-head' colspan='4'><h1 class='company-name'>LearNigeria Assessment</h1></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class='mt-3'>
                                                <p>Hi</p>
                                                <p>You are getting this mail because you requested for a password reset on LearNigeria Assessment, 
                                                your password reset code is:</p>
                                                <div style='background:#E7E7E7;padding:20px 0;width:250px;margin: 0 auto;text-align:center;font-size:35px;color:#787878'>".$result['temp_password']."</div>
                                                <p>Enter this code within 10 minutes to reset your password</p>
                                                <p>Regards,<br/>The LearNigeria Team</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        </body>
                        </html>";
                        $mailHeaders = "MIME-Version: 1.0" . "\r\n";
                        $mailHeaders .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                        $mailHeaders .= "From: LearNigeria Assessment <support@learnigeria.org>\r\n";
                        if (mail($toEmail, $subject, $content, $mailHeaders)) {
                            http_response_code(200);
                            echo json_encode(array("status" =>1,"message"=>"Successful, check your mail for reset password code."));
                        } else {
                            http_response_code(200);
                            echo json_encode(array("status" =>0, "message" => "Error, Unable to send mail."));
                        }
                    }
                } else {
                    http_response_code(200);
                    echo json_encode(array("status" => 0, "message" => "Email does not exist"));
                }
            } else {
                http_response_code(200);
                echo json_encode(array("status" => 0, "message" => "Email is required"));
            }
//        } else {
//            http_response_code(200);
//            echo json_encode(array("status" => 0, "message" => "Oops, Unauthorized developer, missing/invalid client key"));
//        }
//    }
} else {
    http_response_code(200);
    echo json_encode(array("status" => 0, "message" => "Access Denied"));
}


?>