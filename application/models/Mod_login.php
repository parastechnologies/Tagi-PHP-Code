<?php 
class Mod_login extends CI_Model
{
    public function loginMe($email, $password)
    {
        $this->db->select("*");
        $this->db->from("admin");
        $this->db->where("email",$email);
        $this->db->where("password",$password);
        if($query=$this->db->get())
        {
           return $query->row_array();
        }
        else{
          return false;
        }
    }
    public function checkExistEmail($email)
    {
        $this->db->select("*");
        $this->db->from("admin");
        $this->db->where("email",$email);
        $result=$this->db->get();
        if($result->num_rows()>0){
          return false;
        }else{
          return true;
        }
    }
    public function resetPassword($email, $newPassword){
         $changePasswordData=array(
            'password'=>$newPassword
            );   
        $this->db->where('email', $email);
        $this->db->update('admin', $changePasswordData);
        if($query=$this->db->affected_rows())
        {
          return 1;
        }
        else {
            return 0;
        }
      }
}