<?php
class Forgot_password extends Frontend_Controller{
      function __construct() {
            parent::__construct();
            $this->load->model('action');
            $this->load->library('upload');
        }


        public function index(){
            $this->data['meta_title'] = 'Forgot Password';
            $this->data['confirmation'] = null;
            
            $this->load->view('access/forgot_password', $this->data);
        }


        public function reset_password($reset_code = null){
            $this->data['meta_title'] = 'Reset Password';
            $this->data['confirmation'] = null;
            if($this->action->read('users', array('reset_code'=>$reset_code))){
                $this->data['reset_code'] = $reset_code;
                $this->load->view('access/reset_password', $this->data);
            }
            
            if(isset($_POST['update_password'])){
                $reset_code = $this->input->post('reset_code');
                $password = md5($this->input->post('password').config_item('encryption_key'));
                $data = array('password'=>$password, 'reset_code'=>'');
                if($this->action->update('users', $data, array('reset_code'=>$reset_code))){
                        $s_data=array();
                        $this->load->library('session');
                        $s_data['msg_updated_password'] = 'Password Updated Successfully..';
                        $this->session->set_userdata($s_data);
                        redirect('admin');
                }else{
                    echo 'Password not reset';
                }
            }
        }
        
        
        

        public function sent_reset_code($id=null){
            $where = array(
                    'email'    => $this->input->post('email')
                );
                
            if($this->action->read('users', $where)){
                $reset_code = (strtotime(date("Y-m-d h:i:s"))*1000);
                $reset_link = site_url('forgot_password/forgot_password/reset_password/'.$reset_code);
                
                if($this->action->update('users', array('reset_code'=>$reset_code), $where)){
                
                    $email = $this->input->post('email');
                      
                    $to = $email;
                    $subject = "Reset Password";
    
                    $message = "
                        <html>
                        <head>
                        <title>Reset Password</title>
                        </head>
                        <body>
                            <p>Dear User , Please click this link if not work copy this link and past it to other tab of your browser then press enter.</p>
                            <br>
                            <a href='".$reset_link."'>".$reset_link."</a>
                        </body></html>";
    
                 
                     
                    //server configaration
                   $config['configuration'] = array(
                        'protocol'  => 'smtp',
                        'smtp_host' => 'support@nurelectronicsbd.com',
                        'smtp_port' =>  26,
                        'smtp_user' => 'support@nurelectronicsbd.com',
                        'smtp_pass' => '}yn$qADF1KtO',
                        'mailtype'  => 'html',
                        'charset'   => 'utf-8'
                        );    
                    $config = config_item("configuration");
                    
                    $from   = $config['smtp_user'];
                    $site   = config_item("domain");
                    $domain  = $site[0];
        
                    $this->load->library('email', $config);
                    $this->email->set_newline("\r\n");
        
                    $this->email->clear();
                    $this->email->to($to);
                    $this->email->from($from , $domain); // change
                    $this->email->subject($subject); // change
                    $this->email->message($message); // change
    
                    if($this->email->send()){
                        $msg_array=array(
                            "title" =>"Success",
                            "emit"  =>"Please check your email and reset your password..",
                            "btn"   =>true
                        );
                        $this->data['confirmation'] = message('success',$msg_array);
                        $this->session->set_flashdata('confirmation',$this->data['confirmation']);
                        redirect('forgot_password/forgot_password');
                    }
                }
            }else{
                $_SESSION['msg'] = '<div class="alert alert-warning text-center"><h1><strong>Warning!</strong></h1><br> <h2>Username or Email Not Matched..</h2></div>';
                redirect('forgot_password/forgot_password');
            }
        }
    }