<?php

class Home extends Frontend_Controller {

    function __construct() {
        parent::__construct();
      
        $this->load->model('retrieve'); 
        $this->load->model('action'); 
        $this->load->library("session");      
    }
    
public function index() {   
        $this->data['meta_title'] = "home";


        $this->data["cementInfo"] = $this->retrieve->read("products", array("product_cat" => "Cement"));  
        $this->data["rodInfo"] = $this->retrieve->read("products", array("product_cat" => "Rod"));  
        $this->data["gasInfo"] = $this->retrieve->read("products", array("product_cat" => "Gass"));
        

        $this->data["sisterConcern"] = $this->retrieve->read("sister_concern");

        $this->data["front_product"] = $this->retrieve->read("front_product");
        $this->data["product_cat"] = $this->action->read_distinct("front_product",array(), "category");
        $this->data["gallery"] = $this->action->readOrderby("gallery","position",array("trash"=>"false"));


        $this->load->view('includes/header', $this->data); 
        $this->load->view('includes/slider', $this->data);       
        $this->load->view('includes/navbar', $this->data);     
        $this->load->view('home', $this->data);        
        $this->load->view('includes/footer', $this->data);
    }  

public function history() {   
        $this->data['meta_title'] = "history";   

        $this->load->view('includes/header', $this->data);        
        $this->load->view('includes/navbar', $this->data);    
        $this->load->view('history', $this->data); 
        $this->load->view('includes/footer', $this->data);      
    }

public function vision() {   
        $this->data['meta_title'] = "vision";   

        $this->load->view('includes/header', $this->data);        
        $this->load->view('includes/navbar', $this->data);    
        $this->load->view('vision', $this->data); 
        $this->load->view('includes/footer', $this->data);      
    }  

public function directors() {   
        $this->data['meta_title'] = "directors";   

        $this->load->view('includes/header', $this->data);        
        $this->load->view('includes/navbar', $this->data);    
        $this->load->view('directors', $this->data); 
        $this->load->view('includes/footer', $this->data);      
    }   

public function csr() {   
        $this->data['meta_title'] = "CSR";   

        $this->load->view('includes/header', $this->data);        
        $this->load->view('includes/navbar', $this->data);    
        $this->load->view('csr', $this->data); 
        $this->load->view('includes/footer', $this->data);      
    } 

public function media() {   
        $this->data['meta_title'] = "media";   

        $this->load->view('includes/header', $this->data);        
        $this->load->view('includes/navbar', $this->data);    
        $this->load->view('media', $this->data); 
        $this->load->view('includes/footer', $this->data);      
    }

public function gallery() {   
        $this->data['meta_title'] = "gallery";   

        $this->load->view('includes/header', $this->data);        
        $this->load->view('includes/navbar', $this->data);    
        $this->load->view('gallery', $this->data); 
        $this->load->view('includes/footer', $this->data);      
    } 

public function visitor_comments(){
        $data = array(
            'date'      => date("Y-m-d"),
            "name"      => $this->input->post("name"),
            "email"     => $this->input->post("email"),
            "subject"   => $this->input->post("subject"),
            "message"   => $this->input->post("message")
        );

        $options = array(
            'title'  => "success",
            'emit'   => "Your Message has been Successfully Sent!",
            'btn'    => false
        );

        $message = message($this->retrieve->add("visitor_comments",$data),$options);
        $this->session->set_flashdata("confirmation",$message);
        redirect("home#contact","refresh");
    }      
}

