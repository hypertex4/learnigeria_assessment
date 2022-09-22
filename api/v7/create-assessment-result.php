<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");
date_default_timezone_set('Africa/Lagos'); // WAT

include_once('../config/database.php');
include_once('../classes/Client.class.php');

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $err = 0;
    $ass_created_on = date("d-m-Y H:i:s");
    $student_results = json_decode(file_get_contents("php://input"));
    if (count($student_results) > 0) {
        foreach ($student_results as $res) {
            if (!empty($client->check_if_assessor_status_active($res->user_id))) {
                if (!empty($res->user_id) && !empty($res->name) && !empty($res->age) && !empty($res->gender) && !empty($res->grade)
                    && !empty($res->enrolmentStatus) && !empty($res->schoolType) && !empty($res->sampleNumber) && !empty($res->time)
                    && !empty($res->state) && !empty($res->literacy) && !empty($res->numeracy) && !empty($res->start_time)
                    && !empty($res->end_time)
                ) {
                    if ($client->save_assessment_results(
                        $res->client_id, $res->user_id, $res->name, $res->age, $res->gender, $res->grade, $res->enrolmentStatus,
                        $res->schoolType, $res->sampleNumber, $res->time, $res->state, $res->literacy, $res->numeracy, $res->hausa, $res->igbo,
                        $res->yoruba, $res->ethnomaths, $res->bonus, $res->start_time,$res->end_time,$res->curr_location,$res->curr_lga,
                        $res->home_sch_id,$ass_created_on
                    )) {
                    } else {
                        $err = $err + 1;
                    }
                } else {
                    $err = $err + 1;
                }
            } else {
                $err = 10000;
            }
        }
        if ($err == 0) {
            http_response_code(200);
            echo json_encode(array("status" => 1, "message" => "Assessment result has been successfully stored."));
        } else if ($err == 10000) {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Server error, assessor status is inactive. Contact support"));
        } else {
            http_response_code(200);
            echo json_encode(array("status" => 0, "message" => "Server error, could not save assessment result."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Student result is empty, fill all required field."));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>