<?php

class Mod_dashboard extends CI_model
{
    public function registeredUsers()
    {
        $this->db->select("users.id,users.first_name,users.last_name,users.user_name,users.email,users.profile_image,users.create_date,users.profile_status,users.country,users.profile_url");
        $this->db->from("users");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function allRegisteredUsers($limit, $start)
    {
        /*$this->db->select("users.id,users.first_name,users.last_name,users.user_name,users.email,users.profile_image,users.create_date,users.profile_status,users.country,users.profile_url,COUNT(activate_tagi.id) as numberOfTagi");
        $this->db->from("users");
        $this->db->join('activate_tagi','activate_tagi.user_id = users.id','Left');
        $this->db->group_by('activate_tagi.id');
        $this->db->limit($limit, $start);*/
        $this->db->select('users.*, COUNT(activate_tagi.id) as numberOfTagi');
        $this->db->from('users');
        $this->db->join('activate_tagi', 'activate_tagi.user_id = users.id','left');
        $this->db->group_by('users.id');
        $this->db->limit($limit, $start);
        $result=$this->db->get();
        $data=$result->result_array();
        foreach($data as $dt)
        {
            $id=$dt['id'];
            $Udata['id']=$dt['id'];
            $Udata['first_name']=$dt['first_name'];
            $Udata['last_name']=$dt['last_name'];
            $Udata['user_name']=$dt['user_name'];
            $Udata['email']=$dt['email'];
            $Udata['create_date']=$dt['create_date'];
            $Udata['profile_status']=$dt['profile_status'];
            $Udata['country']=$dt['country'];
            $Udata['numberOfTagi']=$dt['numberOfTagi'];
            $points=$this->getUsersPoints($id);
            $Udata['tags_points']=$points['points'];
            $mainDt[]=$Udata;
        }
        return $mainDt;
    }
    public function getUsersPoints($id)
    {
        $this->db->select("points");
        $this->db->from('people_log_point');
        $this->db->where('user_id',$id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function registeredUsersCount()
    {
        $this->db->select("*");
        $this->db->from("users");
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function registeredUsersSearchCount($search)
    {
        $this->db->select("*");
        $this->db->from("users");
        $where="email Like '%".$search."%' OR first_name Like '%".$search."%'";
        $this->db->where($where);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function searchRegisteredUsers($limit, $start,$search)
    {
        /*$this->db->select('users.*, COUNT(activate_tagi.id) as numberOfTagi')
         ->from('users');
        $this->db->join('activate_tagi', 'activate_tagi.user_id = users.id','left')
         ->group_by('id');
        $where="users.email Like '%".$search."%' OR users.first_name Like '%".$search."%'";
        $this->db->where($where);
        $this->db->limit($limit, $start);
        $result=$this->db->get();
        return $result->result_array();*/
        
        $this->db->select('users.*, COUNT(activate_tagi.id) as numberOfTagi');
        $this->db->from('users');
        $this->db->join('activate_tagi', 'activate_tagi.user_id = users.id','left');
        $this->db->group_by('users.id');
         $where="users.email Like '%".$search."%' OR users.first_name Like '%".$search."%'";
        $this->db->where($where);
        $this->db->limit($limit, $start);
        $result=$this->db->get();
        $data=$result->result_array();
        foreach($data as $dt)
        {
            $id=$dt['id'];
            $Udata['id']=$dt['id'];
            $Udata['first_name']=$dt['first_name'];
            $Udata['last_name']=$dt['last_name'];
            $Udata['user_name']=$dt['user_name'];
            $Udata['email']=$dt['email'];
            $Udata['create_date']=$dt['create_date'];
            $Udata['profile_status']=$dt['profile_status'];
            $Udata['country']=$dt['country'];
            $Udata['numberOfTagi']=$dt['numberOfTagi'];
            $points=$this->getUsersPoints($id);
            $Udata['tags_points']=$points['points'];
            $mainDt[]=$Udata;
        }
        return $mainDt;
    }
   /* public function registeredUsers()
    {
        $this->db->select("*");
        $this->db->from("users");
        $result=$this->db->get();
        $dt=$result->result_array();
        foreach($dt as $dd)
        {
            $this->db->select("*");
            $this->db->from("activate_tagi");
            $this->db->where("user_id",$dd["id"]);
            $res=$this->db->get();
            $dt2[]=$res->result_array();
        }
        $data=array_merge($dt,$dt2);
        print_r($data);
        die;
        return $data->result_array();
    }*/
    public function updtaeAccountStatus($profile_status,$user_id)
    {
        $data=array("profile_status"=>$profile_status);
   
        $this->db->where("id",$user_id);
        $result=$this->db->update("users",$data);
        return $result;
    }
    public function addProducts($data)
    {
        $this->db->insert("products",$data);
        $insert_id=$this->db->insert_id();
        /*print_r($this->db->last_query());
        die;*/
        return $insert_id;
    }
    public function productsMngmnt()
    {
        $this->db->select("*");
        $this->db->from("products");
        $this->db->order_by("id", "desc");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function deleteProduct($id)
    {
        $this->db->where("id",$id);
        $result=$this->db->delete("products");
        return $result;
    }
    public function editProduct($id,$data)
    {
        $this->db->where("id",$id);
        $result=$this->db->update("products",$data);
      /*print_r($this->db->last_query());
        die;*/
        return $result;
    }
    public function totalRegisteredUsers()
    {
        $this->db->select("*");
        $this->db->from("users");
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function purchasedTagUsers()
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("purchased_tag_status",1);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function notPurchasedTag()
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("purchased_tag_status",0);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function totalRegisteredTags()
    {
        $this->db->select("*");
        $this->db->from("tagi");
        $this->db->where("active_status",1);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function NotRegisterTags()
    {
        $this->db->select("*");
        $this->db->from("tagi");
        $this->db->where("active_status",0);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function DisableTags()
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("status",0);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function oldPasswordCheck($id)
    {
        $this->db->select("password");
        $this->db->from("admin");
        $this->db->where("id",$id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function resetAdminPassword($id,$newPassword)
    {
        $data=array(
                "password"=>$newPassword
            );
        $this->db->where("id",$id);
        $this->db->update("admin",$data);
        if($result=$this->db->affected_rows())
        {
          return 1;
        }
        else {
            return 0;
        } 
    }
    public function loginUserData($id)
    {
        $this->db->select("*");
        $this->db->from("admin");
        $this->db->where("id",$id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function addTags($data)
    {
        $this->db->insert("tags",$data);
        $insert_id=$this->db->insert_id();
        
        return $insert_id;
    }
    public function uidCheck($uid)
    {
        $this->db->select("*");
        $this->db->from("products");
        $this->db->where("uid",$uid);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function tagiuidCheck($uid)
    {
        $this->db->select("*");
        $this->db->from("tagi");
        $this->db->where("uid",$uid);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function nfcTags()
    {
        $this->db->select("tagi.id,tagi.uid,tagi.status,tagi.active_status,tagi.created_date");
        $this->db->from("tagi");
        $this->db->join('activate_tagi','activate_tagi.tagi_id = tagi.id','Left');
        $this->db->join('users','users.id = activate_tagi.user_id' ,'Left');
        //$this->db->limit($length, $start);
        $this->db->order_by("tagi.id", "desc");
        $result=$this->db->get();
        return $result->result_array();
       /*$i=0;
        foreach ($result->result_array() as $row)
        {
            $rows[0]=$row['id'];
            $rows[1]=$row['uid'];
            $rows[2]=$row['status'];
            $rows[3]=$row['active_status'];
            $rows[4]=$row['created_date'];
            $MainArray[$i]=$rows;
            
           
           $i++;
        }*/
       //return $MainArray;
    }
    public function get_search_count($category,$search)
    {
        $this->db->select("tagi.id,tagi.uid,tagi.status,tagi.active_status,tagi.created_date,users.email,activate_tagi.status as user_status");
        $this->db->from("tagi");
        $this->db->join('activate_tagi','activate_tagi.tagi_id = tagi.id','Left');
        $this->db->join('users','users.id = activate_tagi.user_id' ,'Left');
        $this->db->where("tagi.category",$category);
        $where="tagi.uid Like '%".$search."%' OR users.email Like '%".$search."%'";
        $this->db->where($where);
        $this->db->order_by("tagi.id", "desc");
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function get_count($category)
    {
        $this->db->select("tagi.id,tagi.uid,tagi.status,tagi.active_status,tagi.created_date,users.email,activate_tagi.status as user_status");
        $this->db->from("tagi");
        $this->db->join('activate_tagi','activate_tagi.tagi_id = tagi.id','Left');
        $this->db->join('users','users.id = activate_tagi.user_id' ,'Left');
        $this->db->where("tagi.category",$category);
        $this->db->order_by("tagi.id", "desc");
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function nfcTagsbyCategory($category,$limit, $start)
    {
        $this->db->select("tagi.id,tagi.uid,tagi.status,tagi.active_status,tagi.created_date,users.email,activate_tagi.status as user_status");
        $this->db->from("tagi");
        $this->db->join('activate_tagi','activate_tagi.tagi_id = tagi.id','Left');
        $this->db->join('users','users.id = activate_tagi.user_id' ,'Left');
        $this->db->where("tagi.category",$category);
        $this->db->limit($limit, $start);
        $this->db->order_by("tagi.id", "desc");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function searchnfcTagsbyCategory($category,$limit, $start,$search)
    {
        $this->db->select("tagi.id,tagi.uid,tagi.status,tagi.active_status,tagi.created_date,users.email,activate_tagi.status as user_status");
        $this->db->from("tagi");
        $this->db->join('activate_tagi','activate_tagi.tagi_id = tagi.id','Left');
        $this->db->join('users','users.id = activate_tagi.user_id' ,'Left');
        $this->db->where("tagi.category",$category);
        $where="tagi.uid Like '%".$search."%' OR users.email Like '%".$search."%'";
        $this->db->where($where);
        $this->db->limit($limit, $start);
        $this->db->order_by("tagi.id", "desc");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function searchnfcTags($search)
    {
        $this->db->select("tagi.id,tagi.uid,tagi.status,tagi.active_status,tagi.created_date,users.email,activate_tagi.status as user_status");
        $this->db->from("tagi");
        $this->db->join('activate_tagi','activate_tagi.tagi_id = tagi.id','Left');
        $this->db->join('users','users.id = activate_tagi.user_id' ,'Left');
        $where="tagi.uid Like '%".$search."%' OR users.email Like '%".$search."%'";
        $this->db->where($where);
        $result=$this->db->get();
        return $result->result_array();
    }
    public function editTag($id,$data)
    {
        $this->db->where("id",$id);
        $result=$this->db->update("tags",$data);
        return $result;
    }
    public function deleteTag($id)
    {
        $this->db->where("id",$id);
        $result=$this->db->delete("tagi");
        return $result;
    }
    
    public function deleteActivateTag($id)
    {
        $this->db->where("tagi_id",$id);
        $result=$this->db->delete("activate_tagi");
        return $result;
    }
    
    public function deleteTagPoint($id)
    {
        $this->db->where("id",$id);
        $result=$this->db->delete("tagi_points");
  
        return $result;
    }
    public function updateTagStatus($id,$status)
    {
        $data=array(
                "status"=>$status
            );
        $this->db->where("id",$id);
        $result=$this->db->update("tagi",$data); 
        /*print_r($this->db->last_query());
        die;*/
        return $result;
    }
    public function addTagiPoints($data)
    {
        $this->db->insert("tagi_points",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;
    }
    public function tagiPointsData()
    {
        $this->db->select("*");
        $this->db->from("tagi_points");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function updateqrcode($id,$uid,$fileName)
    {
        $data=array(
            "uid"=>$uid,
            "qrimage"=>$fileName
            );
        $this->db->where("id",$id);
        $result=$this->db->update("products",$data);
        return $result;
    }
    public function updatetagiqrcode($id,$uid,$fileName)
    {
        $data=array(
            "uid"=>$uid,
            "qrimage"=>$fileName
            );
        $this->db->where("id",$id);
        $result=$this->db->update("tagi",$data);
        return $result;
    }
   public function oldQRCheck($id)
   {
       $this->db->select("*");
       $this->db->from("products");
       $this->db->where("id",$id);
       $result=$this->db->get();
       return $result->row_array();
   }
    public function oldtagiQRCheck($id)
   {
       $this->db->select("*");
       $this->db->from("tagi");
       $this->db->where("id",$id);
       $result=$this->db->get();
       return $result->row_array();
   }
   public function addTagiUid($data)
   {
        $this->db->insert("tagi",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;   
   }
   public function tagiIdCheck($uid)
   {
       $this->db->select("*");
        $this->db->from("tagi");
        $this->db->where("uid",$uid);
        $result=$this->db->get();
        return $result->row_array();
   }
   public function oldCouponCodeCheck($id)
   {
       $this->db->select("*");
       $this->db->from("tagi_points");
       $this->db->where("id",$id);
       $result=$this->db->get();
      /* print_r($this->db->last_query());
       die;*/
       return $result->row_array();
       
   }
   public function couponCheck($coupon_code)
   {
       $this->db->select("*");
       $this->db->from("tagi_points");
       $this->db->where("coupon_code",$coupon_code);
       $result=$this->db->get();
       return $result->row_array();
   }
   public function updatecouponcode($id,$coupon_code)
   {
        $data=array(
            "coupon_code"=>$coupon_code
            );
        $this->db->where("id",$id);
        $result=$this->db->update("tagi_points",$data);
        return $result;
   }
   public function editCouponCodeData($id,$data)
   {
        $this->db->where("id",$id);
        $result=$this->db->update("tagi_points",$data);
        /*print_r($this->db->last_query());
       die;*/
        return $result;
   }
   public function couponCodeCheck($coupon_code)
   {
       $this->db->select("*");
       $this->db->from("tagi_points");
       $this->db->where("coupon_code",$coupon_code);
       $result=$this->db->get();
       return $result->row_array();
   }
    public function numberOfTagi($user_id)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("user_id",$user_id);
        $this->db->where("status",1);
        $result=$this->db->get();
        $num = $result->num_rows();
        /*print_r($this->db->last_query());
        die;*/
        return $num;
    }
   public function TagsAddedByAdmin()
   {
       $this->db->select("*");
       $this->db->from("tagi");
       $result=$this->db->get();
        return $result->num_rows();
   }
   public function userLinks($user_id)
    {
        $this->db->select("*");
        $this->db->from("social_links");
        $this->db->where("user_id",$user_id);
        $result=$this->db->get();
        return $result->result_array();
    }
    /*public function tagiUserDetails($tagi_id)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->join("users","users.id= activate_tagi.user_id","right");
        $this->db->where("activate_tagi.tagi_id",$tagi_id);
        $result=$this->db->get();
        print_r($this->db->last_query());
        return $result->row_array();
    }*/
    public function tagiID($tagi_id)
    {
        $this->db->select("id");
        $this->db->from("activate_tagi");
        $this->db->where("tagi_id",$tagi_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    
    public function user_tagi($user_id)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("user_id",$user_id);
        $this->db->where("status",1);
        $result=$this->db->get();
        return $result->result_array();
    }
    public function userTagiPoints($tagi)
    {
        $this->db->select("*");
        $this->db->from("people_log_point");
        $this->db->where("user_id",$tagi);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function peopleLogs($user_id)
    {
        $this->db->select("*");
        $this->db->from("people_logs");
        $this->db->where("user_id",$user_id);
        $this->db->where("status",1);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function checkUserData($user_id)
   {
       $this->db->select("*");
       $this->db->from("users");
       $this->db->where("id",$user_id);
       $result=$this->db->get();
       return $result->row_array();
   }
   public function socialLinks()
   {
       $this->db->select("*");
       $this->db->from("social_icons");
       $result=$this->db->get();
       return $result->result_array();
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
   public function tagiSocialLinks($user_id,$type)
    {
        $this->db->select("*");
        $this->db->from("social_links");
        $this->db->where("user_id",$user_id);
        $this->db->where("category",$type);
        $result=$this->db->get();
        return $result->result_array();
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
   public function tagiUserDetails($user_id)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
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
    public function privateTagiList($user_id,$type)
    {
        $this->db->select("*");
        $this->db->from("userTypes");
        $this->db->where("user_id",$user_id);
        $this->db->where("type",$type);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function medicalStatus($user_id)
    {
        $this->db->select("*");
        $this->db->from("medical_details");
        $this->db->where("user_id",$user_id);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function totalUserTagiCount($user_id)
    {
        $this->db->select("*");
        $this->db->from("activate_tagi");
        $this->db->where("user_id",$user_id);
        $result=$this->db->get();
        return $result->num_rows();
    }
    public function userRewardsData()
    {
        $this->db->select("user_gift_card.id as id,users.id as user_id,users.email,users.first_name,users.last_name,users.profile_image,tagi_points.id as gift_id,tagi_points.coupon_code");
        $this->db->from("user_gift_card");
        $this->db->join("users","users.id = user_gift_card.user_id");
        $this->db->join("tagi_points","tagi_points.id = user_gift_card.gift_id");
        $result=$this->db->get();
        return $result->result_array();
    }
    public function deleteRewardRecord($id)
    {
        $this->db->where("id",$id);
        $result=$this->db->delete("user_gift_card"); 
        return $result;
    }
    public function qrcodeUserId($qrcode)
    {
        $this->db->select("*");
        $this->db->from("users");
        $this->db->where("qrcode",$qrcode);
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
    public function contactTagiSocialLinks($id,$type,$link_type)
    {
        $this->db->select("*");
        $this->db->from("social_links");
        $this->db->where("user_id",$id);
        $this->db->where("category",$type);
        $this->db->where("type",$link_type);
        $result=$this->db->get();
        return $result->row_array();        
    }
    public function checkFolder($folder_name)
    {
        $this->db->select("*");
        $this->db->from("tags_category");
        $this->db->where("name",$folder_name);
        $result=$this->db->get();
        return $result->row_array();
    }
    public function addNewFolder($data)
   {
        $this->db->insert("tags_category",$data);
        $insert_id=$this->db->insert_id();
        return $insert_id;   
   }
   public function nfcFolders()
   {
       $this->db->select("*");
       $this->db->from("tags_category");
       $result=$this->db->get();
       return $result->result_array();
   }
    public function deleteFolder($id)
    {
        $this->db->where("id",$id);
        $result=$this->db->delete("tags_category");
        return $result;
    }
}
?>