<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../classes/Client.class.php');


if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $data = json_decode(file_get_contents("php://input"));

    if (trim($data->action_code) == '101' && !empty(trim($data->u_id))) {
        if ($client->update_assessor_status($data->active,$data->u_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Assessor status updated."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to update assessor status."));
        }
    }

    if (trim($data->action_code) == '102' && !empty(trim($data->u_id))) {
        if ($client->delete_assessor($data->u_id)) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Assessor deleted successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Unable to delete assessor."));
        }
    }
}