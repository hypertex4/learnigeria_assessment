<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Result.class.php');

$db = new Database();
$connection = $db->connect();
$result = new Result($connection);

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $std_res = $result->read_student_results();
    if ($std_res->num_rows > 0) {
        $std_res_arr = array();
        while ($row = $std_res->fetch_assoc()) {
            $std_res_arr[] = array(
                "std_id" => $row['std_id'],
                "id" => $row['id'],
                "student_name" => $row['student_name'],
                "student_age" => $row['student_age'],
                "beginner" => $row['beginner'],
                "level_1" => $row['level_1'],
                "level_2" => $row['level_2'],
                "level_3" => $row['level_3'],
                "level_4" => $row['level_4'],
                "level_5" => $row['level_5'],
                "level_6" => $row['level_6'],
                "numeracy_level" => $row['numeracy_level'],
                "literacy_level" => $row['literacy_level']
            );
        }
        http_response_code(200);
        echo json_encode(array("status" => 1, "student_results" => $std_res_arr));
    } else {
        http_response_code(200);
        echo json_encode(array("status" => 0, "message" => "No Record Found"));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}