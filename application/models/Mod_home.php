<?php 
class Mod_home extends CI_Model
{
    public function signUp($data)
    {
        $this->db->insert("users",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function profileUrl($insert_id,$url)
    {
        $data=array(
                "profile_url"=>$url
            );
        $this->db->where("id",$insert_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function emailCheck($email)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("email",$email);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function updateProfile($user_id,$data)
    {
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function getUserProfile($user_id)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function login($email,$password)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("email",$email);
        $this->db->where("password",$password);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function updateLoginData($id,$login_data)
    {
        $this->db->where("id",$id);
        $result=$this->db->update("users",$login_data);
        return $result;
    }
    public function getLoginData($id)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("id",$id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function editProfile($user_id,$data)
    {
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function changeEmail($user_id,$email)
    {
        $data=array(
            "changeEmail_request"=>$email
        );
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function getRequestEmail($user_id)
    {
        $this->db->select("changeEmail_request");
        $this->db->from("users");
        $this->db->where("id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function updateChangeEmailRequest($email,$user_id)
    {
        $data=array(
                "email"=>$email
            );
        $this->db->where('id',$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function passwordCheck($user_id)
    {
        $this->db->select("password");
        $this->db->from("users");
        $this->db->where("id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function updateNewPassword($user_id,$newPassword)
    {
        $data=array(
            "password"=>$newPassword
            );
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function updateCountry($user_id,$country)
    {
        $data=array(
                "country"=>$country
            );
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function rateUs($data)
    {
        $this->db->insert("rating",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function medicalDetails($data)
    {
        $this->db->insert("medical_details",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function updateQr($user_id,$userQr,$filepath,$businessuserQr,$businessfilepath,$privateuserQr,$privatefilepath)
    {
        $data=array(
            "qrcode"=>$userQr,
            "qrimage"=>$filepath,
            "business_qrcode"=>$businessuserQr,
            "business_qrimage"=>$businessfilepath,
            "private_qrcode"=>$privateuserQr,
            "private_qrimage"=>$privatefilepath
            );
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function activateTagi($data)
    {
        $this->db->insert("activate_tagi",$data);
        $insert_id=$this->db->insert_id();
        /*print_r($this->db->last_query());
        die;*/
        return $insert_id;
    }
    public function tagiCheck($tagi)
    {
        $this->db->select("*");
        $this->db->from("tagi");
        $this->db->where("uid",$tagi);
        $result=$this->db->get();
        /*print_r($this->db->last_query());
        die;*/
        return $result->row_array();
    }
    
    public function tagsList()
    {
        $this->db->select("*");
        $this->db->from("products");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function updateUserTagStatus($user_id,$purchased_tag_status)
    {
        $data=array(
            "purchased_tag_status"=>$purchased_tag_status
            );
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function checkActiveTagi($tagi)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("uid",$tagi);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function checkTagi($tagi)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("uid",$tagi);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function checkTagiCurrentStatus($tagi)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("uid",$tagi);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function checkTagiRow($tagi)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("uid",$tagi);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function myTagi($user_id)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("user_id",$user_id);
        $this->db->where("status",1);
        $result=$this->db->get();
        return $result->result_array();
    }
    public function tagi_deactivate($tagi_id,$user_id)
    {
        $data=array(
                "status"=>0
            );
        $this->db->where("tagi_id",$tagi_id);
        $this->db->where("user_id",$user_id);
        $result=$this->db->update("activate_tagi",$data);
        return $result;
    }
    public function tagi_activate($tagi_id,$user_id)
    {
        $data=array(
            "status"=>1
        );
        $this->db->where("tagi_id",$tagi_id);
        $this->db->where("user_id",$user_id);
        $result=$this->db->update("activate_tagi",$data);
        return $result;
    }
    public function updatesTagistatus($tag_id,$status)
    {
        $data=array(
                "active_status"=>$status
            );
        $this->db->where("id",$tag_id);
        $result=$this->db->update("tagi",$data);
        return $result;
    }
    public function peopleLog($name)
    {
        $this->db->select("id,user_name,profile_image,create_date");
        $this->db->from("users");
        $where="user_name Like '%".$name."%'";
        $this->db->where($where);
        $result=$this->db->get();
        return $result->result_array();
    }
    public function addpeopleLog($user_id,$profile_id,$type,$direct_status)
    {
        $data=array(
            "user_id"=>$user_id,
            "profile_id"=>$profile_id,
            "type"=>$type,
            "direct_status"=>$direct_status
            );
        $this->db->insert("people_logs",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function updatePeopleLog($user_id,$id,$type)
    {
        $data=array(
            "type"=>$type
            );
        $this->db->where("user_id",$user_id);
        $this->db->where("profile_id",$id);
        $result=$this->db->update("people_logs",$data);
        return $result;
    }
    public function addOtherPeopleLog($id,$user_id,$user_type)
    {
        $data=array(
                "user_id"=>$id,
                "profile_id"=>$user_id,
                "type"=>$user_type,
                "status"=>0
            );
        $this->db->insert("people_logs",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function userPeopleLog($user_id)
    {
        $this->db->select("*");
        $this->db->from("people_logs");
        $this->db->where("user_id",$user_id);
        $this->db->order_by("id","desc");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function tagiData($tagi_id)
    {
        $this->db->select("*");
        $this->db->from("tagi");
        $this->db->where("id",$tagi_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function peopleLogCheck($user_id,$profile_id)
    {
        $this->db->select("*");
        $this->db->from("people_logs");
        $this->db->where("user_id",$user_id);
        $this->db->where("profile_id",$profile_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function logPointData($user_id)
    {
        $this->db->select("*");
        $this->db->from("people_log_point");
        $this->db->where("user_id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function updateLogPoints($user_id,$addpoint)
    {
        $data=array(
                "points"=>$addpoint
            );
        $this->db->where("user_id",$user_id);
        $result=$this->db->update("people_log_point",$data);
        return $result;
    }
    public function addLogPoints($user_id,$points)
    {
        $data=array(
            "user_id"=>$user_id,
            "points"=>$points
            );
        $this->db->insert("people_log_point",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function getMedicalDetails($user_id)
    {
        $this->db->select("*");
        $this->db->from("medical_details");
        $this->db->where("user_id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function userMedicalDetails($result)
    {
        $this->db->select("*");
        $this->db->from("medical_details");
        $this->db->where("id",$result);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function updateMedicalDetails($id,$data)
    {
        $this->db->where("id",$id);
        $result=$this->db->update("medical_details",$data);
        return $result;
    }
    public function addLink($data)
    {
        $this->db->insert("social_links",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function tagiDetails($uid)
    {
        $this->db->select("user_id");
        $this->db->from("activate_tagi");
        $this->db->where("uid",$uid);
        $result=$this->db->get();
       /* print_r($this->db->last_query());
        die;*/
        return $result->row_array();
    }
    public function tagiUserDetails($user_id)
    {
        /*$this->db->select("*");
        $this->db->from("users");
        $this->db->join("social_links","social_links.user_id = users.id");
        $this->db->where("users.id",$user_id);
        $result=$this->db->get();
        return $result->result_array();*/
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function checkforgotPasswordEmail($email)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("email",$email);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function getSocialLink($user_id,$category)
    {
        $this->db->select("*");
        $this->db->from("social_links");
        $this->db->where("user_id",$user_id);
        $this->db->where("category",$category);
        $this->db->order_by("row_order","asc");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function deleteSocialLink($id)
    {
        $this->db->where("id",$id);
        $result=$this->db->delete("social_links");
        return $result;
    }
    public function renameTagi($id,$name)
    {
        $data=array(
                "name"=>$name
            );
        $this->db->where("id",$id);
        $result= $this->db->update("activate_tagi",$data);
        return $result;
    }
    public function updatedEmail($user_id)
    {
        $this->db->select("changeEmail_request");
        $this->db->from("users");
        $this->db->where("id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function updateOldEmailOtp($user_id,$code)
    {
        $data=array(
            "oldEmail_otp"=>$code
            );
        $this->db->where('id',$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function updatechangeEmailOtp($user_id,$code)
    {
        $data=array(
            "changeEmail_otp"=>$code
            );
        $this->db->where('id',$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function updateResetPassword($email,$password)
    {
        $data=array(
                "password"=>$password
            );
        $this->db->where("email",$email);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function directStatus($user_id,$type,$status)
    {
        $data=array(
                "direct_status"=>$status
            );
        $this->db->where("user_id",$user_id);
        $this->db->where("type",$type);
        $result=$this->db->update("userTypes",$data);
        return $result;
    }
    public function getPublicStatus($user_id)
    {
        $this->db->select("direct_status");
        $this->db->from("userTypes");
        $this->db->where("user_id",$user_id);
        $this->db->where("type",'Public');
        $result=$this->db->get();
        return $result->row_array();
    }
    public function getBusinessStatus($user_id)
    {
        $this->db->select("direct_status");
        $this->db->from("userTypes");
        $this->db->where("user_id",$user_id);
        $this->db->where("type",'Business');
        $result=$this->db->get();
        return $result->row_array();
    }
    public function getPrivateStatus($user_id)
    {
        $this->db->select("direct_status");
        $this->db->from("userTypes");
        $this->db->where("user_id",$user_id);
        $this->db->where("type",'Private');
        $result=$this->db->get();
        return $result->row_array();
    }
    public function updateMedicalDetailStatus($user_id,$status)
    {
        $data=array(
                "medical_status"=>$status
            );
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function addTagiType($tagi_id,$type)
    {
        $data=array(
                "type"=>$type
            );
        $this->db->where("tagi_id",$tagi_id);
        $result=$this->db->update("activate_tagi",$data);
        return $result;
    }
    public function tagiDataList($user_id,$type)
    {
        $this->db->select("*");
        $this->db->from("userTypes");
        $this->db->where("user_id",$user_id);
        $this->db->where("type",$type);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function userTagiDetails($user_id)
    {
        $this->db->select("id,first_name,last_name,email,description,user_name,profile_image,qrcode,business_qrcode,private_qrcode,medical_status,default_public_status,default_private_status,default_business_status,profile_status");
        $this->db->from("users");
        $this->db->where("id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function tagiSocialLinks($user_id,$type)
    {
        $this->db->select("*");
        $this->db->from("social_links");
        $this->db->where("user_id",$user_id);
        $this->db->where("category",$type);
        $this->db->order_by("row_order","asc");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function tagiSocialLinksByDate($user_id,$type,$date)
    {
        $this->db->select("*");
        $this->db->from("social_links");
        $this->db->where("user_id",$user_id);
        $this->db->where("category",$type);
        $this->db->where("created_date <=",$date);
        $this->db->order_by("row_order","asc");
        $result=$this->db->get();
       /* print_r($this->db->last_query());
        die;*/
        return $result->result_array();
    }
    public function directtagiSocialLinksByDate($user_id,$type,$date)
    {
        $this->db->select("*");
        $this->db->from("social_links");
        $this->db->where("user_id",$user_id);
        $this->db->where("category",$type);
        $this->db->where("created_date <=",$date);
        $this->db->order_by("row_order","asc");
        $this->db->limit(1, 0);
        $result=$this->db->get();
       /* print_r($this->db->last_query());
        die;*/
        return $result->result_array();
    }
    public function tagiID($tagi_id)
    {
        $this->db->select("id");
        $this->db->from("activate_tagi");
        $this->db->where("tagi_id",$tagi_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    /*public function tagiStatusDetails($tagi_id)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("tagi_id",$tagi_id);
        $this->db->where("default_status",1);
        $result=$this->db->get();
        return $result->row_array();
    }*/
    public function tagiUidCheck($tagi_id)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("tagi_id",$tagi_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function getTagiData($tagi_id)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("tagi_id",$tagi_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function tagiCount($user_id)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("user_id",$user_id);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function deleteLinkData($tagiid)
    {
        $this->db->where("tagi_row_id",$tagiid);
        $result=$this->db->delete("social_links");
        return $result;
    }
    public function tagiActivateStatus($tagi_id,$data)
    {
        $this->db->where("id",$tagi_id);
        $result=$this->db->update("tagi",$data);
        return $result;
    }
    public function updateUserTagi($user_id,$tagi)
    {
        $data=array(
                "status"=>1
            );
        $this->db->where("uid",$tagi);
        $this->db->where("user_id",$user_id);
        $result=$this->db->update("activate_tagi",$data);
        return $result;
    }
    public function getLastLink($result)
    {
        $this->db->where("id",$result);
        $this->db->from("social_links");
        $result=$this->db->get();
        return $result->row_array();
    }
    public function socialIcon($type)
    {
        $this->db->select("image");
        $this->db->from("social_icons");
        $this->db->where("type",$type);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function linkCheck($user_id,$type,$category)
    {
        $this->db->select("*");
        $this->db->from("social_links");
        $this->db->where("user_id",$user_id);
        $this->db->where("type",$type);
        $this->db->where("category",$category);
        $result=$this->db->get();
        /*print_r($this->db->last_query());
        die;*/
        return $result->row_array();
    }
    public function editLink($id,$data)
    {
        $this->db->where("id",$id);
        $result=$this->db->update("social_links",$data);
        return $result;
    }
    public function getEditLink($id)
    {
        $this->db->select("*");
        $this->db->where("id",$id);
        $this->db->from("social_links");
        $result=$this->db->get();
        return $result->row_array();
    }
    public function getLinkType($id)
    {
        $this->db->select("type");
        $this->db->where("id",$id);
        $this->db->from("social_links");
        $result=$this->db->get();
        return $result->row_array();
    }
    public function businessTagiList($user_id,$type)
    {
        $this->db->select("*");
        $this->db->from("userTypes");
        $this->db->where("user_id",$user_id);
        $this->db->where("type",$type);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function privateTagiList($user_id,$type)
    {
        $this->db->select("*");
        $this->db->from("userTypes");
        $this->db->where("user_id",$user_id);
        $this->db->where("type",$type);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function publicUserDetail($publicDetails)
    {
        $this->db->insert("userTypes",$publicDetails);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function privateUserDetail($privateDetails)
    {
        $this->db->insert("userTypes",$privateDetails);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function businessUserDetail($businessDetails)
    {
        $this->db->insert("userTypes",$businessDetails);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function updateTypeProfile($id,$data)
    {
        $this->db->where("id",$id);
        $result=$this->db->update("userTypes",$data);
        return $result;
    }
    public function publicUrl($user_id,$publicType)
    {
        $this->db->select("*");
        $this->db->from("userTypes");
        $this->db->where("user_id",$user_id);
        $this->db->where("type",$publicType);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function defultProfileStatusCheck($user_id)
    {
        $this->db->select("default_public_status,default_private_status,default_business_status");
        $this->db->from("users");
        $this->db->where("id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function defaultProfile($user_id,$data)
    {
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function addTypeProfile($data)
    {
        $this->db->insert("userTypes",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function typeProfileData($user_id,$type)
    {
        $this->db->select("id,user_id,name,image,description,profile_url,type,status,direct_status");
        $this->db->from("userTypes");
        $this->db->where("user_id",$user_id);
        $this->db->where("type",$type);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function homeProfileStatus($user_id,$profileStatus)
    {
        $data=array(
                "profile_status"=>$profileStatus
            );
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function medicalStatus($user_id)
    {
        $this->db->select("*");
        $this->db->from("medical_details");
        $this->db->where("user_id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function editPublicProfile($user_id,$type,$publicData)
    {
        $this->db->where("user_id",$user_id);
        $this->db->where("type",$type);
        $result=$this->db->update("userTypes",$publicData);
        return $result;
    }
    public function totalUserTagiCount($user_id)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("user_id",$user_id);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function socailLinkOrder($user_id,$order)
    {
        $data=array(
                "row_order"=>$order
            );
        $this->db->where("id",$user_id);
        $result=$this->db->update("social_links",$data);
        return $result;
    }
    public function tagiOrderCount($user_id,$category)
    {
        $this->db->select("*");
        $this->db->from("social_links");
        $this->db->where("user_id",$user_id);
        $this->db->where("category",$category);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function deletePeopleLog($id)
    {
        $this->db->where("id",$id);
        $result=$this->db->delete("people_logs");
        return $result;
    }
    public function tagiUserId($idd)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("tagi_id",$idd);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function qrcodeUserId($qrcode,$type)
    {
        $this->db->select("*");
        $this->db->from("users");
        if($type == "Public")
        {
            $this->db->where("qrcode",$qrcode);
        }
        if($type == "Business")
        {
            $this->db->where("business_qrcode",$qrcode);
        }
        if($type == "Private")
        {
            $this->db->where("private_qrcode",$qrcode);   
        }
        $result=$this->db->get();
        return $result->row_array();
    }
    public function userTotalPoints($user_id)
    {
        $this->db->select("points,");
        $this->db->from("people_log_point");
        $this->db->where("user_id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function getAllGiftCards()
    {
        $this->db->select('*');
        $this->db->from('tagi_points');
        $result=$this->db->get();
        return $result->result_array();
    }
    public function addGiftCardUserRecord($id,$gift_id)
    {
        $data=array(
                "user_id"=>$id,
                "gift_id"=>$gift_id
            );
        $this->db->insert('user_gift_card',$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function checkGiftCardData($id,$gift_id)
    {
        $this->db->select("*");
        $this->db->from("user_gift_card");
        $this->db->where("user_id",$id);
        $this->db->where("gift_id",$gift_id);
        $result=$this->db->get();
        return $result->result_array();
    }
    public function giftCardList($user_id)
    {
        $this->db->select("*");
        $this->db->from("user_gift_card");
        $this->db->join("tagi_points","tagi_points.id = user_gift_card.gift_id");
        $this->db->where("user_gift_card.user_id",$user_id);
        $result=$this->db->get();
        return $result->result_array();
    }
    public function allGiftCardList()
    {
        $this->db->select("*");
        $this->db->from("tagi_points");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function allGiftCardRangeList()
    {
        $this->db->select("id,point_range_from,point_range_to,home_note,arabic_note");
        $this->db->from("tagi_points");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function setPrivateProfilePassword($user_id,$password)
    {
        $data=array(
                "protected_password"=>$password
            );
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function protectedPasswordCheck($user_id)
    {
        $this->db->select("protected_password");
        $this->db->from("users");
        $this->db->where("id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function updateNewProtectedPassword($user_id,$newPassword)
    {
        $data=array(
            "protected_password"=>$newPassword
            );
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function getProfileUrl($type)
    {
        $this->db->select("base_url");
        $this->db->from("social_icons");
        $this->db->where("type",$type);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function walletTagiSocialLinks($id,$type,$link_type)
    {
        $this->db->select("*");
        $this->db->from("social_links");
        $this->db->where("user_id",$id);
        $this->db->where("category",$type);
        $this->db->where("type",$link_type);
        $result=$this->db->get();
        return $result->row_array();        
    }
    public function getEmailData($user_id)
    {
        $this->db->select("email");
        $this->db->from("users");
        $this->db->where("user_id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function getChangeEmailOtp($user_id)
    {
        $this->db->select('oldEmail_otp,changeEmail_otp,forgotEmail_otp,privatePassword_otp');
        $this->db->from('users');
        $this->db->where("id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function updatechangeEmailStatus($user_id,$type,$status)
    {
        if($type == "old_email")
        {
            $data=array(
                    "oldEmail_status"=>$status
                );
        }
        elseif($type == "change_email")
        {
            $data=array(
                    "changeEmail_status"=>$status
                );
        }
        elseif($type == "forgot_password")
        {
            $data=array(
                    "forgotEmail_status"=>$status
                );   
        }
        elseif($type == "private_password")
        {
            $data=array(
                    "privatePassword_status"=>$status
                );   
        }
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function updateForgotPasswordOtp($user_id,$code)
    {
        $data=array(
                "forgotEmail_otp"=>$code
            );
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function updatePrivatePasswordOtp($user_id,$code)
    {
        $data=array(
                "privatePassword_otp"=>$code
            );
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function failedTagi($data)
    {
        $this->db->insert("failed_tagi",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function getQrCodeUser()
    {
        $this->db->select("id");
        $this->db->from("users");
        $this->db->where('popup_count',0);
        $result=$this->db->get();
        return $result->result_array();
    }
    public function updateuserQr($id,$publicuserQr,$publicfilepath,$businessuserQr,$businessfilepath,$privateuserQr,$privatefilepath)
    {
        $data=array(
            "qrcode"=>$publicuserQr,
            "qrimage"=>$publicfilepath,
            "business_qrcode"=>$businessuserQr,
            "business_qrimage"=>$businessfilepath,
            "private_qrcode"=>$privateuserQr,
            "private_qrimage"=>$privatefilepath
            );
        $this->db->where("id",$id);
        $result=$this->db->update('users',$data);
        /*print_r($this->db->last_query());
        die;*/
        return $result;
    }
    public function publicqrcode($id,$publicuserQr,$publicfilepath)
    {
        $data=array(
            "qrcode"=>$publicuserQr,
            "qrimage"=>$publicfilepath
        );
        $this->db->where("id",$id);
        $result=$this->db->update('users',$data);
        /*print_r($this->db->last_query());
        die;*/
        return $result;
    }
    public function getpublicQrcode($user_id,$type)
    {
        if($type == "Public")
        {
            $this->db->select("qrimage");    
        }
        elseif($type == "Business")
        {
            $this->db->select("business_qrimage as qrimage");
        }
        elseif($type == "Private")
        {
            $this->db->select("private_qrimage as qrimage");
        }
        $this->db->where("id",$user_id);
        $this->db->from("users");
        $result=$this->db->get();
        return $result->row_array();
    }
    
    public function tagiDefaultSocialLinks($user_id,$type)
    {
        $this->db->select("*");
        $this->db->from("social_links");
        $this->db->where("user_id",$user_id);
        $this->db->where("category",$type);
        $this->db->where("row_order",0);
        $result=$this->db->get();
        return $result->result_array();
    }
    public function businessqrcode($id,$businessuserQr,$businessfilepath)
    {
        $data=array(
            "business_qrcode"=>$businessuserQr,
            "business_qrimage"=>$businessfilepath
        );
        $this->db->where("id",$id);
        $result=$this->db->update('users',$data);
        return $result;
    }
    public function privateqrcode($id,$privateuserQr,$privatefilepath)
    {
        $data=array(
            "private_qrcode"=>$privateuserQr,
            "private_qrimage"=>$privatefilepath
        );
        $this->db->where("id",$id);
        $result=$this->db->update('users',$data);
        return $result;
    }
    /*public function addDirectLog($user_id,$usertype,$direct_status,$encodedTime)
    {
        $data=array(
                "user_id"=>$user_id,
                "user_type"=>$usertype,
                "status"=>$direct_status,
                "time"=>$encodedTime
            );
        $this->db->insert("direct_log",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
        
    }*/
    public function getAllProfileImage($user_id,$type)
    {
        $this->db->select("*");
        $this->db->from("userTypes");
        $this->db->where("user_id",$user_id);
        $this->db->where("type",$type);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function updateAllProfileimage($user_id,$profileImages,$type)
    {
        $data=array(
                "image"=>$profileImages
            );
        $this->db->where("user_id",$user_id);
        $this->db->where("type",$type);
        $result=$this->db->update("userTypes",$data);
        return $result;
    }
    
}