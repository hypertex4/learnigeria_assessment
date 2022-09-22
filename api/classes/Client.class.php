<?php

$filepath = realpath(dirname(__FILE__));
include_once($filepath . '/../config/database.php');

class Client {

    private $conn;

    public function __construct(){
        $db = new Database();
        $this->conn = $db->connect();
    }

    public function insert_student_results($id,$std_name,$std_age,$b,$_1,$_2,$_3,$_4,$_5,$_6,$num_level,$lit_level){
        $temp_query = "INSERT INTO tbl_student_results SET id=?,student_name=?,student_age=?,beginner=?,level_1=?,level_2=?,
                        level_3=?,level_4=?,level_5=?,level_6=?,numeracy_level=?,literacy_level=?";
        $temp_obj = $this->conn->prepare($temp_query);
        $temp_obj->bind_param("isisssssssss",$id,$std_name,$std_age,$b,$_1,$_2,$_3,$_4,$_5,$_6,$num_level,$lit_level);
        if ($temp_obj->execute()) {
            return true;
        }
        return false;
    }

    public function read_student_results(){
        $beats_query = "SELECT * FROM tbl_student_results";
        $beats_obj = $this->conn->prepare($beats_query);
        if ($beats_obj->execute()) {
            return $beats_obj->get_result();
        }
        return array();
    }

    public function user_login($user_id_or_em){
        $email_query = "SELECT * FROM tbl_users u INNER JOIN tbl_clients c oN u.client_id=c.client_id  
                        WHERE (u.user_id=? OR u.user_email=?) AND u.user_active='yes'";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("ss", $user_id_or_em,$user_id_or_em);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_active_user_account($user_id_or_em){
        $email_query = "SELECT * FROM tbl_users u INNER JOIN tbl_clients c oN u.client_id=c.client_id  
                        WHERE (u.user_id=? OR u.user_email=?) AND u.user_active='yes'";
        $user_obj = $this->conn->prepare($email_query);
        $user_obj->bind_param("ss", $user_id_or_em,$user_id_or_em);
        if ($user_obj->execute()) {
            $data = $user_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_client_email($email){
        $email_query = "SELECT * FROM tbl_clients WHERE client_email=?";
        $cli_obj = $this->conn->prepare($email_query);
        $cli_obj->bind_param("s", $email);
        if ($cli_obj->execute()) {
            $data = $cli_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function check_user_email($email){
        $email_query = "SELECT * FROM tbl_users WHERE user_email=?";
        $cli_obj = $this->conn->prepare($email_query);
        $cli_obj->bind_param("s", $email);
        if ($cli_obj->execute()) {
            $data = $cli_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function create_user_assessor($user_id,$client_id,$fullname,$email,$ass_status,$password){
        $pass_hash= password_hash($password, PASSWORD_DEFAULT);
        $user_type = "assessor";
        $cli_query = "INSERT INTO tbl_users SET client_id=?,user_id=?,user_name=?,user_email=?,user_active=?,user_pwd=?,user_type=?";
        $cli_obj = $this->conn->prepare($cli_query);
        $cli_obj->bind_param("sssssss", $client_id,$user_id,$fullname,$email,$ass_status,$pass_hash,$user_type);
        if ($cli_obj->execute()) {
            return true;
        }
        return false;
    }

    public function passwordResetRequest($email) {
        $random_string = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz",6)),0,6);
        $encrypted_temp_password = $random_string;
        $date_now = date("Y-m-d H:i:s");
        $sql = "SELECT * FROM tbl_password_reset_request WHERE email_or_id='$email'";
        $query_obj = $this->conn->prepare($sql);
        if ($query_obj->execute()) {
            $data = $query_obj->get_result();
            if ($data->num_rows === 0) {
                $insert_query = "INSERT INTO tbl_password_reset_request SET email_or_id=?,encrypted_temp_password=?,created_at=?";
                $insert_obj = $this->conn->prepare($insert_query);
                $insert_obj->bind_param("sss",$email,$encrypted_temp_password,$date_now);
                if ($insert_obj->execute()){
                    $userArr['email_or_id'] = $email;
                    $userArr['temp_password'] = $random_string;
                    return $userArr;
                }
                return false;
            } else {
                $update_query = "UPDATE tbl_password_reset_request SET email_or_id=?,encrypted_temp_password=?,created_at=?";
                $update_obj = $this->conn->prepare($update_query);
                $update_obj->bind_param("sss",$email,$encrypted_temp_password,$date_now);
                if ($update_obj->execute()){
                    $userArr['email_or_id'] = $email;
                    $userArr['temp_password'] = $random_string;
                    return $userArr;
                }
                return false;
            }
        }
        return false;
    }

    public function resetPassword($code,$password){
        $sql = "SELECT * FROM tbl_password_reset_request WHERE encrypted_temp_password='$code'";
        $query = $this->conn->prepare($sql);
        if ($query->execute()) {
            $data = $query->get_result()->fetch_assoc();
            if (empty($data)){
                return "invalid";
            } else {
                $db_encrypted_email_or_id = $data['email_or_id'];
                $old = new DateTime($data['created_at']);
                $now = new DateTime(date("Y-m-d H:i:s"));
                $diff = $now->getTimestamp() - $old->getTimestamp();

                if ($diff < 600) {
                    $update_query = "UPDATE tbl_users SET user_pwd=? WHERE user_id='$db_encrypted_email_or_id' OR user_email='$db_encrypted_email_or_id'";
                    $update_obj = $this->conn->prepare($update_query);
                    $update_obj->bind_param("s",$password);
                    if ($update_obj->execute()){
                        if ($update_obj->affected_rows > 0) {
                            //Delete any existing user token entry
                            $del_reset_obj = $this->conn->prepare("DELETE FROM tbl_password_reset_request WHERE email_or_id=?");
                            $del_reset_obj->bind_param("s",$db_encrypted_email_or_id);
                            $del_reset_obj->execute();
                            return "true";
                        }
                    }
                    return "false";
                } else { return "expired"; }
            }
        }
        return "false";
    }

    public function check_client_org_name($org_name){
        $email_query = "SELECT * FROM tbl_clients WHERE organisation_name=?";
        $cli_obj = $this->conn->prepare($email_query);
        $cli_obj->bind_param("s", $org_name);
        if ($cli_obj->execute()) {
            $data = $cli_obj->get_result();
            return $data->fetch_assoc();
        }
        return array();
    }

    public function create_client($client_id,$client_fullname,$organisation_name,$client_email,$client_mobile,$client_pwd){
        $pass_hash= password_hash($client_pwd, PASSWORD_DEFAULT);
        $user_type = "client";
        $cli_query = "INSERT INTO tbl_clients SET client_id=?,client_fullname=?,organisation_name=?,client_email=?,client_mobile=?";
        $cli_obj = $this->conn->prepare($cli_query);
        $cli_obj->bind_param("sssss", $client_id,$client_fullname,$organisation_name,$client_email,$client_mobile);
        if ($cli_obj->execute()) {
            if ($this->create_client_user($client_id,$client_fullname,$client_email,$pass_hash,$user_type)) return true;
            else return false;
        }
        return false;
    }

    public function create_client_user($user_id,$user_name,$user_email,$user_pwd,$user_type){
        $cli_query = "INSERT INTO tbl_users SET client_id=?,user_id=?,user_name=?,user_email=?,user_pwd=?,user_type=?";
        $cli_obj = $this->conn->prepare($cli_query);
        $cli_obj->bind_param("ssssss",$user_id, $user_id,$user_name,$user_email,$user_pwd,$user_type);
        if ($cli_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_user_by_id($user_id){
        $user_query = "SELECT * FROM tbl_users u INNER JOIN tbl_clients c oN u.client_id=c.client_id  WHERE u.user_id=?";
        $user_obj = $this->conn->prepare($user_query);
        $user_obj->bind_param("s", $user_id);
        if ($user_obj->execute()) {
            return $user_obj->get_result();
        }
        return array();
    }

    public function update_user_personal_profile($user_id,$user_name,$user_email,$phone){
        $usr_query = "UPDATE tbl_users SET user_name=?,user_email=? WHERE user_id=?";
        $usr_obj = $this->conn->prepare($usr_query);
        $usr_obj->bind_param("sss",$user_name,$user_email,$user_id);
        if ($usr_obj->execute()) {
            $this->update_client_phone_profile($user_id,$phone);
            if ($usr_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_user_profile_by_user_id($user_id,$fullname,$email,$ass_status){
        $usr_query = "UPDATE tbl_users SET user_name=?,user_email=?,user_active=? WHERE user_id=?";
        $usr_obj = $this->conn->prepare($usr_query);
        $usr_obj->bind_param("ssss",$fullname,$email,$ass_status,$user_id);
        if ($usr_obj->execute()) {
            if ($usr_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_user_password($user_id,$user_pwd){
        $usr_query = "UPDATE tbl_users SET user_pwd=? WHERE user_id=?";
        $usr_obj = $this->conn->prepare($usr_query);
        $usr_obj->bind_param("ss",$user_pwd,$user_id);
        if ($usr_obj->execute()) {
            if ($usr_obj->affected_rows > 0){
                return true;
            }
            return "no_change";
        }
        return false;
    }

    public function update_client_phone_profile($client_id,$phone){
        $usr_query = "UPDATE tbl_clients SET client_mobile=? WHERE client_id=?";
        $usr_obj = $this->conn->prepare($usr_query);
        $usr_obj->bind_param("ss",$phone,$client_id);
        if ($usr_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_all_user_account($client_id){
        $user_query = "SELECT * FROM tbl_users WHERE client_id=? AND user_type='assessor'";
        $user_obj = $this->conn->prepare($user_query);
        $user_obj->bind_param("s", $client_id);
        if ($user_obj->execute()) {
            return $user_obj->get_result();
        }
        return array();
    }

    public function update_assessor_status($status,$user_id){
        $usr_query = "UPDATE tbl_users SET user_active=? WHERE user_id=?";
        $usr_obj = $this->conn->prepare($usr_query);
        $usr_obj->bind_param("ss",$status,$user_id);
        if ($usr_obj->execute()) {
            if ($usr_obj->affected_rows > 0){
                return true;
            }
            return false;
        }
        return false;
    }

    public function delete_assessor($user_id){
        $del_query = "DELETE FROM tbl_users WHERE user_id='$user_id'";
        $del_obj = $this->conn->prepare($del_query);
        if ($del_obj->execute()){
            if ($del_obj->affected_rows > 0){ return true; }
            return false;
        }
        return false;
    }

    public function save_assessment_results(
        $client_id,$user_id,$stud_name,$age,$gender,$grade,$enrolmentStatus,$schoolType,$sampleNumber,$time,$state,
        $literacy,$numeracy,$hausa,$igbo,$yoruba,$ethnomaths,$bonus,$start_time,$end_time,$curr_location,$curr_lga
        ,$home_sch_id,$ass_created_on
    ) {
        $cli_query = "INSERT INTO tbl_assessments SET client_id=?,user_id=?,stud_name=?,age=?,gender=?,grade=?,enrol_status=?,
                        school_type=?,sample_no=?,ass_date=?,state=?,literacy=?,numeracy=?,hausa=?,igbo=?,yoruba=?,ethnomaths=?,
                        bonus=?,start_time=?,end_time=?,current_state=?,current_lga=?,home_sch_id=?,ass_created_on=?";
        $cli_obj = $this->conn->prepare($cli_query);
        $cli_obj->bind_param(
            "sssissssssssssssssssssss",
            $client_id,$user_id,$stud_name,$age,$gender,$grade,$enrolmentStatus,$schoolType,$sampleNumber,$time,$state,
                    $literacy,$numeracy,$hausa,$igbo,$yoruba,$ethnomaths,$bonus,$start_time,$end_time,$curr_location,$curr_lga,
                    $home_sch_id,$ass_created_on);
        if ($cli_obj->execute()) {
            return true;
        }
        return false;
    }

    public function get_all_client_assessments($user_id){
        $ass_query = "SELECT a.*,u.* FROM tbl_assessments a INNER JOIN tbl_users u ON a.user_id=u.user_id WHERE a.user_id=?";
        $ass_obj = $this->conn->prepare($ass_query);
        $ass_obj->bind_param("s", $user_id);
        if ($ass_obj->execute()) {
            return $ass_obj->get_result();
        }
        return array();
    }

    public function check_if_assessor_status_active($user_id){
        $ass_query = "SELECT * FROM tbl_users WHERE user_id=? AND user_active='yes'";
        $ass_obj = $this->conn->prepare($ass_query);
        $ass_obj->bind_param("s", $user_id);
        if ($ass_obj->execute()) {
            return $ass_obj->get_result();
        }
        return array();
    }

    public function count_total_assessment($user_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_assessments WHERE user_id='$user_id'";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_client_assessment($client_id){
        $com_query = "SELECT count(*) AS myCount FROM tbl_assessments WHERE client_id='$client_id'";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_gender_student($client_id,$sex){
        $com_query = "SELECT count(*) AS myCount FROM tbl_assessments WHERE client_id='$client_id' AND gender='$sex'";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }

    public function count_total_school_type_student($client_id,$school_type){
        $com_query = "SELECT count(*) AS myCount FROM tbl_assessments WHERE client_id='$client_id' AND school_type='$school_type'";
        $com_obj = $this->conn->prepare($com_query);
        if ($com_obj->execute()) {
            $data = $com_obj->get_result()->fetch_assoc();
            return $data['myCount'];
        }
        return 0;
    }
}

$client = new Client();