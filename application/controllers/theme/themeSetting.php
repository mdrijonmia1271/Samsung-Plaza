<?php
class ThemeSetting extends Admin_controller {
     function __construct() {
        parent::__construct();
        $this->load->library('upload');
        $this->load->model('action');
    }
    
    public function index() {
        $this->data['meta_title'] = 'Theme';
        $this->data['active'] = 'data-target="theme_menu"';
        $this->data['subMenu'] = 'data-target="logo"';
        $this->data['confirmation'] = null;

//-----------------------------------------------------------------------------------------
//--------------------------------Changeing Logo start here--------------------------------
//-----------------------------------------------------------------------------------------
        if ($this->input->post('submit_logo')) {

            if ($_FILES["attachFile"]["name"]!=null && $_FILES["attachFile"]["name"]!="" ) {

                $config['upload_path'] = './public/img';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="logo_".rand(111111,999999); 
                $config['overwrite']=true;   
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload("attachFile")){
                    $upload_data=$this->upload->data();
                    
                   //Encoding into json array start here
                    $logo_info=array(
                        'logo'=> "public/img/".$upload_data['file_name'],
                        'faveicon'=> $this->input->post('faveicon'),
                    );
                    $logo_data=json_encode($logo_info);
                    //Encoding into json array end here
                    $data=array(
                        'meta_key'  =>'logo',
                        'meta_value'=>$logo_data
                    );
                    $msg_array = array(
                        "title" => "Success",
                        "emit"  => "Logo Successfully Saved",
                        "btn"   => true
                    );
                    $this->data['confirmation'] = message($this->action->add('site_meta', $data), $msg_array);
                }
                    
            }
                else{
                    $msg_array=array(
                    "title"=>"Error",
                    "emit"=>$this->upload->display_errors(),
                    "btn"=>true
                    );
                    $this->data['confirmation']=message("warning",$msg_array);
                }

            }

        if ($this->input->post('update_logo')) {

            $where=array(
                'meta_key'  =>'logo',
            );

            if ($_FILES["attachFile"]["name"]!=null && $_FILES["attachFile"]["name"]!="" ) {

                $config['upload_path'] = './public/img';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="logo_".rand(111111,999999); 
                $config['overwrite']=true;   
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload("attachFile")){

                    if (is_file('./'.$this->input->post('old_logo'))) {
                        unlink('./'.$this->input->post('old_logo'));
                    }

                    $upload_data=$this->upload->data();
                    
                   //Encoding into json array start here
                    $logo_info=array(
                        'logo'=> "public/img/".$upload_data['file_name'],
                        'faveicon'=> $this->input->post('faveicon'),
                    );
                    $logo_data=json_encode($logo_info);
                    //Encoding into json array end here
                    $data=array(
                        'meta_value'=>$logo_data
                    );
                    $msg_array = array(
                        "title" => "Success",
                        "emit"  => "Logo Successfully Saved",
                        "btn"   => true
                    );
                    $this->data['confirmation'] = message($this->action->update('site_meta', $data,$where), $msg_array);
                }
                    
            }
                else{
                    $msg_array=array(
                    "title"=>"Error",
                    "emit"=>$this->upload->display_errors(),
                    "btn"=>true
                    );
                    $this->data['confirmation']=message("warning",$msg_array);
                }

            }

//-----------------------------------------------------------------------------------------
//---------------------------------Changeing Logo end here---------------------------------
//-----------------------------------------------------------------------------------------


//-----------------------------------------------------------------------------------------
//--------------------------------Changeing Feveicon start here----------------------------
//-----------------------------------------------------------------------------------------
        if ($this->input->post('submit_fevicon')) {

            if ($_FILES["attachFile"]["name"]!=null && $_FILES["attachFile"]["name"]!="" ) {

                $config['upload_path'] = './public/img';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="favicon_".rand(111111,999999); 
                $config['overwrite']=true;   
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload("attachFile")){
                    $upload_data=$this->upload->data();
                    
                   //Encoding into json array start here
                    $logo_info=array(
                        'logo'=> $this->input->post('logo'),
                        'faveicon'=> "public/img/".$upload_data['file_name'],
                    );
                    $logo_data=json_encode($logo_info);
                    //Encoding into json array end here
                    $data=array(
                        'meta_key'  =>'logo',
                        'meta_value'=>$logo_data
                    );
                    $msg_array = array(
                        "title" => "Success",
                        "emit"  => "Logo Successfully Saved",
                        "btn"   => true
                    );
                    $this->data['confirmation'] = message($this->action->add('site_meta', $data), $msg_array);
                }
                    
            }
                else{
                    $msg_array=array(
                    "title"=>"Error",
                    "emit"=>$this->upload->display_errors(),
                    "btn"=>true
                    );
                    $this->data['confirmation']=message("warning",$msg_array);
                }

            }

        if ($this->input->post('update_fevicon')) {
            $where=array(
                'meta_key'  =>'logo'
            );

            if ($_FILES["attachFile"]["name"]!=null && $_FILES["attachFile"]["name"]!="" ) {

                $config['upload_path'] = './public/img';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="favicon_".rand(111111,999999); 
                $config['overwrite']=true;   
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload("attachFile")){

                    if (is_file('./'.$this->input->post('old_faveicon'))) {
                        unlink('./'.$this->input->post('old_faveicon'));
                    }

                    $upload_data=$this->upload->data();
                    
                   //Encoding into json array start here
                    $logo_info=array(
                        'logo'=> $this->input->post('logo'),
                        'faveicon'=> "public/img/".$upload_data['file_name'],
                    );
                    $logo_data=json_encode($logo_info);
                    //Encoding into json array end here
                    $data=array(
                        'meta_value'=>$logo_data
                    );
                    $msg_array = array(
                        "title" => "Success",
                        "emit"  => "Logo Successfully Saved",
                        "btn"   => true
                    );
                    $this->data['confirmation'] = message($this->action->update('site_meta', $data,$where), $msg_array);
                }
                    
            }
                else{
                    $msg_array=array(
                    "title"=>"Error",
                    "emit"=>$this->upload->display_errors(),
                    "btn"=>true
                    );
                    $this->data['confirmation']=message("warning",$msg_array);
                }

            }

//-----------------------------------------------------------------------------------------
//---------------------------------Changeing Feveicon end here-----------------------------
//-----------------------------------------------------------------------------------------


//-----------------------------------------------------------------------------------------
//--------------------------------Changeing Menu Icon start here---------------------------
//-----------------------------------------------------------------------------------------
        if ($this->input->post('submit_menu_icon')) {
//Encoding into json array start here
            $menu_icon=array(
                'aside_menu'=> $this->input->post('aside_menu'),
                'footer_menu'=> $this->input->post('footer_menu')
            );
            $menu_icon=json_encode($menu_icon);
//Encoding into json array end here
            $data=array(
                'meta_key'  =>  'menu_icon',
                'meta_value'=>  $menu_icon
            );
            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme Successfully Saved",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add('site_meta', $data), $msg_array);
            redirect('theme/themeSetting/','refresh');
        }

        //INSERT End here
        //UPDATE Start here

        if ($this->input->post('update_menu_icon')) {
            $where=array(
                'meta_key'  =>  'menu_icon'
            );

            //Encoding into json array start here
            $menu_icon=array(
                'aside_menu'=> $this->input->post('aside_menu'),
                'footer_menu'=> $this->input->post('footer_menu')
            );
            $menu_icon=json_encode($menu_icon);
//Encoding into json array end here
            $data=array(
                'meta_value'=>  $menu_icon
            );
            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme successfully Saved",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->update('site_meta', $data,$where), $msg_array);
            redirect('theme/themeSetting/','refresh');
        }

//-----------------------------------------------------------------------------------------
//---------------------------------Changeing Menu Icon end here----------------------------
//-----------------------------------------------------------------------------------------
        //Converting array to object
        $meta = $this->action->read("site_meta");
        $meta_info=array();
        foreach ($meta as $meta_value) {
            $meta_info[$meta_value->meta_key] = $meta_value->meta_value;
        }
        $meta_data = (object) $meta_info;
        $this->data["meta"] = $meta_data;
        //Converting array to object
        
        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/theme/nav', $this->data);
        $this->load->view('components/banner/banner', $this->data);
        $this->load->view('components/theme/changeLogo', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function theme_tools() {
        $this->data['meta_title'] = 'Themt';
        $this->data['active'] = 'data-target="theme_menu"';
        $this->data['subMenu'] = 'data-target="tools"';
        $this->data['confirmation'] = null;

        //--------------------------------------------------------------------------------------
        //----------------------------Language Change start here--------------------------------
        //--------------------------------------------------------------------------------------
        if ($this->input->post('submit_language')) {
            $data=array(
                'meta_key' => 'language',
                'meta_value' => $this->input->post("language")
                
            );
            $msg_array = array(
                "title" => "Success",
                "emit"  => "Language Successfully Saved",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add('site_meta', $data), $msg_array);
        }

        if ($this->input->post('update_language')) {
            $where=array(
                'meta_key' => 'language',
            );
            $data=array(
                'meta_value' => $this->input->post("language")
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Language successfully Updated",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->update('site_meta', $data,$where), $msg_array);
        }
        //----------------------------------------------------------------------------------------------
        //----------------------------------Language Change end here------------------------------------
        //----------------------------------------------------------------------------------------------

        //--------------------------------------------------------------------------------------
        //-------------------------Header Information start here--------------------------------
        //--------------------------------------------------------------------------------------
        if ($this->input->post('submit_header')) {
//Encoding into json array start here
            $h_info=array(
                'site_name'=> $this->input->post('site_name'),
                'place_name'=> $this->input->post('place_name')
            );
            $header_info=json_encode($h_info);
//Encoding into json array end here
            $data=array(
                'meta_key' => 'header',
                'meta_value' => $header_info
            );
            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme Successfully Saved",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add('site_meta', $data), $msg_array);
        }

        //Insert end here
        //update start here

        if ($this->input->post('update_header')) {
            $where=array(
                'meta_key'   => 'header',
            );
//Encoding into json array start here
            $h_info=array(
                'site_name'=> $this->input->post('site_name'),
                'place_name'=> $this->input->post('place_name')
            );
            $header_info=json_encode($h_info);
//Encoding into json array end here
            $data=array(

                'meta_value' => $header_info
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme Successfully Updated",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->update('site_meta', $data,$where), $msg_array);
        }
        //----------------------------------------------------------------------------------------------
        //----------------------------------Header Information end here---------------------------------
        //----------------------------------------------------------------------------------------------


        //Footer Setting Start*****Footer Setting Start*****Footer Setting Start*****Footer Setting Start*****
        //Footer Setting Start*****Footer Setting Start*****Footer Setting Start*****Footer Setting Start*****
        //Footer Setting Start*****Footer Setting Start*****Footer Setting Start*****Footer Setting Start*****
        //--------------------------------------------------------------------------------------
        //----------------------------------------Last footer Text change start here------------
        //--------------------------------------------------------------------------------------
        if ($this->input->post('submit_footer')) {

//Encoding into json array start here
            $f_info=array(
                'l_footer_text' => $this->input->post('l_footer_text'),
                'addr_moblile'  => $this->input->post('addr_moblile'),
                'addr_email'    => $this->input->post('addr_email'),
                'addr_address'  => $this->input->post('addr_address')
            );

//Uploading Footer Image Start here            
            if ($_FILES["attachFile"]["name"]!=null && $_FILES["attachFile"]["name"]!="" ) {
                $config['upload_path'] = './public/img';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="footer_".rand(111111,999999); 
                $config['overwrite']=true;   
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload("attachFile")){
                    /*
                    if (is_file('./'.$this->input->post('old_faveicon'))) {
                        unlink('./'.$this->input->post('old_faveicon'));
                    }*/

                    $upload_data=$this->upload->data();
                   //Encoding into json array start here
                    $f_info['footer_img']= "public/img/".$upload_data['file_name'];
                }
                else{
                    $msg_array=array(
                    "title"=>"Error",
                    "emit"=>$this->upload->display_errors(),
                    "btn"=>true
                    );
                    $this->data['confirmation']=message("warning",$msg_array);
                }
            }
            else{
                $f_info['footer_img']=$this->input->post('footer_img');
            }
//Uploading Footer Image End here            

            $footer_info=json_encode($f_info);
//Encoding into json array end here

            $data=array(
                'meta_key'   => 'footer',
                'meta_value' => $footer_info
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme Successfully Saved",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add('site_meta', $data), $msg_array);
        }

//Edit Start here--------------------------------------------------------------------------------------------
        if ($this->input->post('update_footer')) {
            $where=array(
                'meta_key'=>'footer',
            );
//Encoding into json array start here
            $f_info=array(
                'l_footer_text' => $this->input->post('l_footer_text'),
                'addr_moblile'  => $this->input->post('addr_moblile'),
                'addr_email'    => $this->input->post('addr_email'),
                'addr_address'  => $this->input->post('addr_address')
            );

//Uploading Footer Image Start here            
            if ($_FILES["attachFile"]["name"]!=null && $_FILES["attachFile"]["name"]!="" ) {
                $config['upload_path'] = './public/img';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="footer_".rand(111111,999999); 
                $config['overwrite']=true;   
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload("attachFile")){
                    if (is_file('./'.$this->input->post('footer_img'))) {
                        unlink('./'.$this->input->post('footer_img'));
                    }

                    $upload_data=$this->upload->data();
                   //Encoding into json array start here
                    $f_info['footer_img']= "public/img/".$upload_data['file_name'];
                }
                else{
                    $msg_array=array(
                    "title"=>"Error",
                    "emit"=>$this->upload->display_errors(),
                    "btn"=>true
                    );
                    $this->data['confirmation']=message("warning",$msg_array);
                }
            }
            else{
                $f_info['footer_img']=$this->input->post('footer_img');
            }
            //Uploading Footer Image End here 
            $footer_info=json_encode($f_info);
            //Encoding into json array end here


            $data=array(
                'meta_value' => $footer_info
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme successfully Updated",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->update('site_meta', $data,$where), $msg_array);
        }

        //----------------------------------------------------------------------------------------------
        //----------------------------------Last footer Text change end here----------------------------
        //----------------------------------------------------------------------------------------------
        //Footer Setting End****Footer Setting End****Footer Setting End****Footer Setting End****Footer Setting End****
        //Footer Setting End****Footer Setting End****Footer Setting End****Footer Setting End****Footer Setting End****
        //Footer Setting End****Footer Setting End****Footer Setting End****Footer Setting End****Footer Setting End****

        //--------------------------------------------------------------------------------------
        //-----------------------------Social Icon start here-----------------------------------
        //--------------------------------------------------------------------------------------
        if ($this->input->post('submit_social')) {

//Encoding into json array start here
            $s_icon=array(
                's_facebook'   => $this->input->post('s_facebook'),
                's_twitter'    => $this->input->post('s_twitter'),
                's_gplus'      => $this->input->post('s_gplus'),
                's_pinterest'  => $this->input->post('s_pinterest'),
                's_youtube'    => $this->input->post('s_youtube')
            );
            $social_link=json_encode($s_icon);
//Encoding into json array end here
            $data=array(
                'meta_key' => 'social_icon',
                'meta_value' => $social_link
            );
            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme successfully Saved",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add('site_meta', $data), $msg_array);
        }

        if ($this->input->post('update_social')) {
            $where=array(
                'meta_key' => 'social_icon',
            );
//Encoding into json array start here
            $s_icon=array(
                's_facebook'   => $this->input->post('s_facebook'),
                's_twitter'    => $this->input->post('s_twitter'),
                's_gplus'      => $this->input->post('s_gplus'),
                's_pinterest'  => $this->input->post('s_pinterest'),
                's_youtube'    => $this->input->post('s_youtube')
            );
            $social_link=json_encode($s_icon);
//Encoding into json array end here
            $data=array(
                'meta_value' => $social_link
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme successfully Updated",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->update('site_meta', $data,$where), $msg_array);
        }
        //----------------------------------------------------------------------------------------------
        //------------------------------------Social Icon end here--------------------------------------
        //----------------------------------------------------------------------------------------------

        //Converting array to object
        $meta = $this->action->read("site_meta");
        $meta_info=array();
        foreach ($meta as $meta_value) {
            $meta_info[$meta_value->meta_key] = $meta_value->meta_value;
        }
        $meta_data = (object) $meta_info;
        $this->data["meta"] = $meta_data;
        //Converting array to object

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/theme/nav', $this->data);
        $this->load->view('components/theme/theme_tools', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

    public function theme_basic() {
        $this->data['meta_title'] = 'Themt';
        $this->data['active'] = 'data-target="theme_menu"';
        $this->data['subMenu'] = 'data-target="basic"';
        $this->data['confirmation'] = null;


        //----------------------------------------------------------------------------------------------
        //----------------------------------------Theme Color change End here---------------------------
        //----------------------------------------------------------------------------------------------
        if ($this->input->post('submit')) {
            $data=array(
                'meta_key' => 'theme_color',
                'meta_value ' => $this->input->post('themeColor')
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme successfully Saved",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add('site_meta', $data), $msg_array);
        }

        if ($this->input->post('update')) {
            $where=array(
                'meta_key' => 'theme_color',
            );
            $data=array(
                'meta_key' => 'theme_color',
                'meta_value '=>$this->input->post('themeColor')
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme Successfully Updated",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->update('site_meta', $data,$where), $msg_array);
        }

        //----------------------------------------------------------------------------------------------
        //----------------------------------------Theme Color change End here---------------------------
        //----------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------
        //------------------------------------Theme Background change Start here------------------------
        //----------------------------------------------------------------------------------------------
        if ($this->input->post('submit_bg')) {
            $data=array();

            if ($_FILES["attachFile"]["name"]!=null or $_FILES["attachFile"]["name"]!="" ) {

                $config['upload_path'] = './public/img';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="background"; 
                $config['overwrite']=true;   
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload("attachFile")){
                    $upload_data = $this->upload->data();
                    
                    $data["meta_key"]='background_pattern';
                    $data["meta_value"]="public/img/".$upload_data['file_name'];

                } else {
                    $msg_array=array(
                        "title" => "Error",
                        "emit"  => $this->upload->display_errors(),
                        "btn"   => true
                    );
                    $this->data['confirmation'] = message("warning", $msg_array);
                }

            }

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme successfully Saved",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add('site_meta', $data), $msg_array);
        }

        if ($this->input->post('update_bg')) {
            $where=array(
                'meta_key'=>'background_pattern'
            );
            $data=array();

            if ($_FILES["attachFile"]["name"]!=null or $_FILES["attachFile"]["name"]!="" ) {

                $config['upload_path'] = './public/img';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="background".rand(); 
                $config['overwrite']=true;   
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload("attachFile")){
                    $upload_data = $this->upload->data();  
                
                if (is_file("./".$this->input->post("old_image"))) {
                    unlink("./".$this->input->post("old_image"));
                }

                    $data["meta_value"]="public/img/".$upload_data['file_name'];


                } else {
                    $msg_array=array(
                        "title" => "Error",
                        "emit"  => $this->upload->display_errors(),
                        "btn"   => true
                    );
                    $this->data['confirmation'] = message("warning", $msg_array);
                }

            }

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme successfully Updated",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->update('site_meta', $data,$where), $msg_array);
        }

        //----------------------------------------------------------------------------------------------
        //------------------------------------Theme Background change end here------------------------
        //----------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------
        //------------------------------------Login Background change Start here------------------------
        //----------------------------------------------------------------------------------------------
        if ($this->input->post('submit_login_bg')) {
            $data=array();

            if ($_FILES["attachFile"]["name"]!=null or $_FILES["attachFile"]["name"]!="" ) {

                $config['upload_path'] = './public/img';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="background"; 
                $config['overwrite']=true;   
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload("attachFile")){
                    $upload_data = $this->upload->data();
                    
                    $data["meta_key"]='login_background';
                    $data["meta_value"]="public/img/".$upload_data['file_name'];


                } else {
                    $msg_array=array(
                        "title" => "Error",
                        "emit"  => $this->upload->display_errors(),
                        "btn"   => true
                    );
                    $this->data['confirmation'] = message("warning", $msg_array);
                }

            }

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme successfully Saved",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add('site_meta', $data), $msg_array);
        }

        if ($this->input->post('update_login_bg')) {
            $where=array(
                'meta_key'=>'login_background'
            );
            $data=array();

            if ($_FILES["attachFile"]["name"]!=null or $_FILES["attachFile"]["name"]!="" ) {

                $config['upload_path'] = './private/images';
                $config['allowed_types'] = 'png|jpeg|jpg|gif';
                $config['max_size'] = '4096';
                $config['max_width'] = '3000'; /* max width of the image file */
                $config['max_height'] = '3000';
                $config['file_name'] ="background".rand(); 
                $config['overwrite']=true;   
                
                $this->upload->initialize($config);
                
                if ($this->upload->do_upload("attachFile")){
                    $upload_data = $this->upload->data();  
                
                if (is_file("./".$this->input->post("old_image"))) {
                    unlink("./".$this->input->post("old_image"));
                }

                    $data["meta_value"]="private/images/".$upload_data['file_name'];


                } else {
                    $msg_array=array(
                        "title" => "Error",
                        "emit"  => $this->upload->display_errors(),
                        "btn"   => true
                    );
                    $this->data['confirmation'] = message("warning", $msg_array);
                }

            }

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme successfully Updated",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->update('site_meta', $data,$where), $msg_array);
        }

        //----------------------------------------------------------------------------------------------
        //------------------------------------Login Background change end here------------------------
        //----------------------------------------------------------------------------------------------

        //----------------------------------------------------------------------------------------------
        //----------------------------------------Google Map change End here---------------------------
        //----------------------------------------------------------------------------------------------
        if ($this->input->post('submit_map')) {
            $data=array(
                'meta_key'   => 'google_map',
                'meta_value' => $this->input->post('gmap')
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme successfully Saved",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->add('site_meta', $data), $msg_array);
        }

        if ($this->input->post('update_map')) {
            $where=array(
                'meta_key'   => 'google_map'
            );
            $data=array(
                'meta_value' => $this->input->post('gmap')
            );

            $msg_array = array(
                "title" => "Success",
                "emit"  => "Theme successfully Updated",
                "btn"   => true
            );
            $this->data['confirmation'] = message($this->action->update('site_meta', $data,$where), $msg_array);
        }

        //----------------------------------------------------------------------------------------------
        //----------------------------------------Google Map change End here---------------------------
        //----------------------------------------------------------------------------------------------

        //Converting array to object
        $meta = $this->action->read("site_meta");
        $meta_info=array();
        foreach ($meta as $meta_value) {
            $meta_info[$meta_value->meta_key] = $meta_value->meta_value;
        }
        $meta_data = (object) $meta_info;
        $this->data["meta"] = $meta_data;
        //Converting array to object

        $this->data['theme_data']=$this->action->read('theme_setting');

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/theme/nav', $this->data);
        $this->load->view('components/theme/themeColor', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }
    
    public function deleteProfile() {
        $confirm = $this->action->deleteData('users', array('id' => $this->input->get('id')));

        return $confirm;
    }

}
       