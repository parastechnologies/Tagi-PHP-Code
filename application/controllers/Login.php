<?php error_reporting(0); if(!defined('BASEPATH')) exit('No direct script access allowed');
require APPPATH . '/libraries/BaseController.php';

/**
 * Class : Login (LoginController)
 */
class Login extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    { 
        parent::__construct();
       $this->load->database();
       $this->load->helper('url');
        $this->load->library('session');
        $this->load->model('Mod_login');
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        redirect('login');
    }
    
    /**
     * This function used to check the user is logged in or not
     */
    function isLoggedIn()
    {
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('login');
        }
        else
        {
            //$this->loadViews('/dashboard');
            redirect('/dashboard');
            //$this->load->view('login');
        }
    }
    
    /**
     * This function used to login view 
     */
    public function login()
    {
        $this->isLoggedIn(); 
    }

    /**
     * This function used to logged in user
     */
    public function loginMe()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|max_length[128]|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->isLoggedIn(); 
        }
        else 
        {
            //Login for Super-admin
            $email = strtolower($this->security->xss_clean($this->input->post('email')));
            $remember = strtolower($this->security->xss_clean($this->input->post('remember')));
            $pwd=$this->input->post('password');
            $password = md5($this->input->post('password'));
            $result = $this->Mod_login->loginMe($email, $password);
            $suspendStatus=$result["status"];
            if($suspendStatus != 1)
            {
                if(!empty($result))
                {
                    if(!empty($remember)) {
                       
                    	setcookie ("email",$email,time()+ (10 * 365 * 24 * 60 * 60));
                        setcookie ("password",$pwd,time()+ (10 * 365 * 24 * 60 * 60));
                    
                    } 
                    else {
                    	setcookie("email","");
                    	setcookie("password","");
                    }
                    $sessionArray = array('id'=>$result['id'],                    
                                            'email'=>$result['email'],
                                            "role"=>$result['role'],
                                            'isLoggedIn' => TRUE
                                    );
    
                    $this->session->set_userdata($sessionArray);
                    unset($sessionArray['id'], $sessionArray['isLoggedIn'], $sessionArray['lastLogin']);
                    $loginInfo = 
                        array(
                                "id"=>$result['id'], 
                                "sessionData" => json_encode($sessionArray), 
                                "machineIp"=>$_SERVER['REMOTE_ADDR'], 
                            );
                    //$this->Mod_login->lastLogin($loginInfo);
                    //$this->loadViews('/dashboard');
                    redirect('/dashboard');
                    //redirect('https://www.google.com');
                }
                else
                {
                    $this->session->set_flashdata('error', 'Email or password mismatch');
                    $this->isLoggedIn();
                }    
            }
            else
            {
                $this->session->set_flashdata('error', 'Account Deactivated');
                $this->isLoggedIn();
            } 
        }
        }
    /**
     * This function used to generate reset password request link
     */
        public function forgot_password()
        {
            $this->load->view('forgot_password');
        }
        public function forgotPasswordMail(){
            $this->load->library('form_validation');
        
        $this->form_validation->set_rules('login_email','Email','trim|required|valid_email');
        
                
        if($this->form_validation->run() == FALSE)
        {      
             echo 2;
            // return true;
        }
        else 
        {
      $email = strtolower($this->security->xss_clean($this->input->post('login_email')));
      $email_check = $this->Mod_login->checkExistEmail($email);
      if($email_check){
          echo 3;
      }else{
           require 'vendor/autoload.php';
            $API_KEY='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';
            $FROM_EMAIL = 'saurabh.parastechnologies@gmail.com';
            $TO_EMAIL = $email; 
            $subject = "Forgot Password Request"; 
            $from = new SendGrid\Email(null, $FROM_EMAIL);
            $to = new SendGrid\Email(null, $TO_EMAIL);
            $decode= base64_encode($TO_EMAIL);
            $htmlContent = 'Dear '.$TO_EMAIL.',  
                              <br/>Recently a request was submitted to reset a password for your account. If this was a mistake, just ignore this email and nothing will happen to your account.
                              <br/>To reset your password, click the following link : <a href="https://controlpanel.tagmoi.co/resetPassword?email='.$decode.'">Click here to reset your password</a>
                              <br/><br/>Regards,
                              <br/>Tagi';
            $content = new SendGrid\Content("text/html",$htmlContent);
            $mail = new SendGrid\Mail($from, $subject, $to, $content);
            $sg = new \SendGrid($API_KEY);
            $response = $sg->client->mail()->send()->post($mail);
             if($response->statusCode() == 202)
                {
                    echo "1";
                }
                else 
                {
                    echo "4";  
                }
            //echo json_encode(array('Response'=>'true', 'message'=>'Please check your e-mail, we have sent a password reset link to your registered Email.'));
      }
        }
    }
       /**
     * This function used to load forgot password view
     */
   public function resetPassword()
    { 
        $isLoggedIn = $this->session->userdata('isLoggedIn');
        if(!isset($isLoggedIn) || $isLoggedIn != TRUE)
        {
            $this->load->view('resetPassword');
        }
        else
        {
            redirect('/dashboard');
        }
    }
    /*Start forgotResetPassword API*/  
    public function forgotResetPassword(){ 
       
         $encode = $this->input->post("email");
         $email = base64_decode($this->input->post("email"));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', 'password and  connfirm passsword does not match');
        }
        else{
             $newPassword = md5($this->input->post('password'));
            $data  =$this->Mod_login->resetPassword($email,$newPassword);
         if($data == 1){
             $this->session->set_flashdata('success', 'Your password reset successfully, Please login with your new password.');
        }else{
             $this->session->set_flashdata('error', 'Password not updated, Please, do not use your previous password.');
        }
        }
        redirect('resetPassword?email='.$encode);
    }
    public function resetForgotPassword($id)
    {
        $data["id"]=$id;
        $this->load->view("resetForgotPassword",$data);
    }
    public function resetUserForgotPassword(){ 
        $id = $this->input->post("id");
        $this->load->library('form_validation');
        $this->form_validation->set_rules('password', 'Password', 'required|max_length[32]');
        $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]');
        if($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata('error', 'password and  confirm passsword does not match');
        }
        else{
             $newPassword = md5($this->input->post('password'));
            $data=$this->Mod_login->resetUserPassword($id,$newPassword);
         if($data == 1){
             $this->session->set_flashdata('success', 'Your password reset successfully, Please login with your new password.');
        }else{
             $this->session->set_flashdata('error', 'Password not updated, Please, do not use your previous password.');
        }
        }
        redirect('resetForgotPassword/'.$id);
    }
/*End forgotResetPassword API*/ 
}

?>