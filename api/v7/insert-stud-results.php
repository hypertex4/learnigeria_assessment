<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-type: application/json; charset=UTF-8");

include_once('../config/database.php');
include_once('../classes/Result.class.php');

$db = new Database();
$connection = $db->connect();
$std_res = new Result($connection);

//$student_results = array(
//    (object) [
//        "id" => 1,
//        "student_name" => "Ayo",
//        "student_age" => 8,
//        "numeracy_level" => "Level 2",
//        "literacy_level" => "Beginner"
//    ],
//    (object) [
//        "id" => 2,
//        "student_name" => "Dayo",
//        "student_age" =>5,
//        "numeracy_level" => "Level 1",
//        "literacy_level" => "Level 4"
//    ],
//    (object) [
//        "id" => 3,
//        "student_name" => "Fred",
//        "student_age" => 6,
//        "numeracy_level" => "Level 3",
//        "literacy_level" => "Level 1"
//    ]
//);

$err = 0;
if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $student_results = json_decode(file_get_contents("php://input"));
    if (count($student_results) > 0) {
        foreach ($student_results as $res) {
            if (!empty($res->id) && !empty($res->student_name) && !empty($res->student_age)) {
                if ($res->numeracy_level == "Beginner"){$b=1;$_1=0;$_2=0;$_3=0;$_4=0;$_5=0;$_6=0;}
                if ($res->numeracy_level == "Level 1"){$b=1;$_1=1;$_2=0;$_3=0;$_4=0;$_5=0;$_6=0;}
                if ($res->numeracy_level == "Level 2"){$b=1;$_1=1;$_2=1;$_3=0;$_4=0;$_5=0;$_6=0;}
                if ($res->numeracy_level == "Level 3"){$b=1;$_1=1;$_2=1;$_3=1;$_4=0;$_5=0;$_6=0;}
                if ($res->numeracy_level == "Level 4"){$b=1;$_1=1;$_2=1;$_3=1;$_4=1;$_5=0;$_6=0;}
                if ($res->numeracy_level == "Level 5"){$b=1;$_1=1;$_2=1;$_3=1;$_4=1;$_5=1;$_6=0;}
                if ($res->numeracy_level == "Level 6"){$b=1;$_1=1;$_2=1;$_3=1;$_4=1;$_5=1;$_6=1;}
                if($std_res->insert_student_results($res->id,$res->student_name,$res->student_age,$b,$_1,$_2,$_3,$_4,$_5,$_6,$res->numeracy_level,$res->literacy_level)){}
                else{ $err = $err + 1; }
            } else { $err = $err + 1; }
        }

        if ($err == 0){
            http_response_code(200);
            echo json_encode(array("status"=>1,"message"=>"Results updated successfully."));
        } else {
            http_response_code(200);
            echo json_encode(array("status"=>0,"message"=>"Unable to process objects."));
        }
    } else {
        http_response_code(200);
        echo json_encode(array("status"=>0,"message"=>"Cant process and empty array..."));
    }
} else {
    http_response_code(503);
    echo json_encode(array("status" => 503, "message" => "Access Denied"));
}
?>