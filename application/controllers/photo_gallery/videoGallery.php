<?php

class VideoGallery extends Admin_Controller {

    function __construct() {
        parent::__construct();

        $this->load->model('action');
        $this->load->library('upload');
    }
    
    public function index($emit = NULL) {
        $this->data['meta_title'] = 'gallery';
        $this->data['active'] = 'data-target="header_menu"';
        $this->data['subMenu'] = 'data-target=""';
        $this->data['confirmation'] = null;

        //-----------------------------------------------------------------------
        //------------------------Save Gallery start here------------------------
        //-----------------------------------------------------------------------
        if ($this->input->post('v_gallery_Save')) {
            site_update();//Updating site update time
                $embaded_code='<iframe width="100%" height="100%" src="https://www.youtube.com/embed/'.$this->input->post("embed_code").'" frameborder="0" allowfullscreen></iframe>';
                $data=array(
                    "date"=>date('Y-m-d'),
                    "video_title"=>"",
                    "embed_code"=> $embaded_code
                    );
                $this->data['confirmation']=message($this->action->add("video_gallery",$data));
            }
        //-----------------------------------------------------------------------
        //-------------------------Save Gallery end here-------------------------
        //-----------------------------------------------------------------------

        //-----------------------------------------------------------------------
        //-----------------------Delete Gallery Start here-----------------------
        //-----------------------------------------------------------------------
        if($this->input->get("delete_token")){//Deleting Message
            $this->action->deletedata('video_gallery',array('id'=>$this->input->get("delete_token")));
            redirect('header/videoGallery','refresh');
        }
        //-----------------------------------------------------------------------
        //------------------------Delete Gallery End here------------------------
        //-----------------------------------------------------------------------        
        $this->data["v_gallery_data"]=$this->action->read("video_gallery");

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/header/video-gallery', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer');
    }

}
