<?php

class BarcodeSetting extends Admin_controller {

    function __construct() {
        parent::__construct();
        $this->holder();
        $this->load->model('action');
        $this->load->helper('barcode');

        $this->data['meta_title'] = 'Barcode';
        $this->data['active'] = 'data-target="barcode_menu"';
    }

    public function index() {
        $this->data['subMenu'] = 'data-target="setting"';
        $this->data['confirmation'] = null;

        if(isset($_POST['bc_setting'])){
            $data = array(
                'img_height'  => $this->input->post('im_height'),
                'img_width'   => $this->input->post('im_width'),
                'code_width'  => $this->input->post('bar_width'),
                'code_height' => $this->input->post('b_height'),
                'pos_x'       => $this->input->post('x_pos'),
                'pos_y'       => $this->input->post('y_pos'),
                'code_type'   => $this->input->post('code_type')
            );
            // save Home page Information
            //$this->data['confirmation'] = message($this->action->add('barcode', $data));
            $this->data['confirmation'] = message($this->action->update('barcode', $data, array("id" => 1)));
        }
        $this->data['bc_data']=$this->action->read("barcode"); //Fatching About table

        //Generate All Barcode data
        $codes = array();
        foreach($this->action->read_col("products","product_code") as $key => $val){
        	$codes[] = $val->product_code;
        }
        $this->data['product_codes'] = json_encode($codes);

        //Generate All Barcode data
        // after form submit

        $this->load->view($this->data['privilege'].'/includes/header', $this->data);
        $this->load->view($this->data['privilege'].'/includes/aside', $this->data);
        $this->load->view($this->data['privilege'].'/includes/headermenu', $this->data);
        $this->load->view('components/barcode/menu', $this->data);
        $this->load->view('components/barcode/barcode-Setting', $this->data);
        $this->load->view($this->data['privilege'].'/includes/footer', $this->data);
    }

//Bar code Start here=======================================================================
    public function mk_barcode(){
        $path=$this->input->post('path');
        $receive = filter_input(INPUT_POST, 'data');
        $data = json_decode($receive, TRUE); // json object to array
        //echo $this->action->add("message", $data);



        //Bar code generating Start here----------------
         $font     = './private/fonts/arialbd.ttf';
          // - -

          $fontSize = 12;   // GD1 in px ; GD2 in point
          $marge    = 10;   // between barcode and hri in pixel
          $x        = $data["x_pos"];  // barcode center
          $y        = $data["y_pos"];;  // barcode center
          $height   = $data["b_height"];   // barcode height in 1D ; module size in 2D
          $width    = $data["bar_width"];    // barcode height in 1D ; not use in 2D
          //$width    = 2;    // barcode height in 1D ; not use in 2D
          $angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation

          $code     = $data["test_data"]; // barcode, of course ;)
          $type     = $data["code_type"];

          // -------------------------------------------------- //
          //                    USEFUL
          // -------------------------------------------------- //

          // -------------------------------------------------- //
          //            ALLOCATE GD RESSOURCE
          // -------------------------------------------------- //
          $im     = imagecreatetruecolor($data["im_width"], $data["im_height"]);
          $black  = ImageColorAllocate($im,0x00,0x00,0x00);
          $white  = ImageColorAllocate($im,0xff,0xff,0xff);
          $red    = ImageColorAllocate($im,0xff,0x00,0x00);
          $blue   = ImageColorAllocate($im,0x00,0x00,0xff);
          imagefilledrectangle($im, 0, 0, $data["im_width"], $data["im_height"], $white);

          // -------------------------------------------------- //
          //                      BARCODE
          // -------------------------------------------------- //
          $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);

          // -------------------------------------------------- //
          //        HRI (Human readable Interpretation)
          // -------------------------------------------------- //
          if ( isset($font) ){
            $box = imagettfbbox($fontSize, 0, $font, $data['hri']);
            $len = $box[2] - $box[0];
            Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
            imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $black, $font, $data['hri']);
          }

          //imagepng($im);
          //header('Content-type: image/png');
          //header('Content-Disposition: attachment; filename='.$code.'.png');
          //addFile(header('Content-Disposition: attachment; filename='.$code.'.png'));
          $random_num=rand();
          $success=imagepng($im, './public/barcode/'.$random_num.image_type_to_extension(IMAGETYPE_PNG));
          imagedestroy($im);
         // echo $code. image_type_to_extension(IMAGETYPE_PNG);
         echo $random_num.image_type_to_extension(IMAGETYPE_PNG);
        //Bar code generating End here----------------
    }

      public function del_barcode(){
        unlink('./public/barcode/'.$_POST["path"]);
        echo $_POST["path"];
    }

    //Bar code End here=======================================================================
    
    //Bar code Start here=======================================================================
    public function save_barcode(){
        $receive = filter_input(INPUT_POST, 'data');
        $data = json_decode($receive, TRUE); // json object to array
        //echo $this->action->add("message", $data);

        //Bar code generating Start here----------------
         $font     = './private/fonts/arialbd.ttf';
          // - -

          $fontSize = 12;   // GD1 in px ; GD2 in point
          $marge    = 10;   // between barcode and hri in pixel
          $x        = $data["x_pos"];  // barcode center
          $y        = $data["y_pos"];;  // barcode center
          $height   = $data["b_height"];   // barcode height in 1D ; module size in 2D
          $width    = $data["bar_width"];    // barcode height in 1D ; not use in 2D
          //$width    = 2;    // barcode height in 1D ; not use in 2D
          $angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation

          $code     = $data["test_data"]; // barcode, of course ;)
          $type     = $data["code_type"];

          // -------------------------------------------------- //
          //                    USEFUL
          // -------------------------------------------------- //

          // -------------------------------------------------- //
          //            ALLOCATE GD RESSOURCE
          // -------------------------------------------------- //
          $im     = imagecreatetruecolor($data["im_width"], $data["im_height"]);
          $black  = ImageColorAllocate($im,0x00,0x00,0x00);
          $white  = ImageColorAllocate($im,0xff,0xff,0xff);
          $red    = ImageColorAllocate($im,0xff,0x00,0x00);
          $blue   = ImageColorAllocate($im,0x00,0x00,0xff);
          imagefilledrectangle($im, 0, 0, $data["im_width"], $data["im_height"], $white);

          // -------------------------------------------------- //
          //                      BARCODE
          // -------------------------------------------------- //
          $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);

          // -------------------------------------------------- //
          //        HRI (Human readable Interpretation)
          // -------------------------------------------------- //
          if ( isset($font) ){
            $box = imagettfbbox($fontSize, 0, $font, $data['hri']);
            $len = $box[2] - $box[0];
            Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
            imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $black, $font, $data['hri']);
          }

          //imagepng($im);
          //header('Content-type: image/png');
          //header('Content-Disposition: attachment; filename='.$code.'.png');
          //addFile(header('Content-Disposition: attachment; filename='.$code.'.png'));
          $random_num=rand();
          $success=imagepng($im, './public/uploaded_barcode/'.$data['hri'].image_type_to_extension(IMAGETYPE_PNG));
          imagedestroy($im);
         // echo $code. image_type_to_extension(IMAGETYPE_PNG);
         echo $random_num.image_type_to_extension(IMAGETYPE_PNG);
        //Bar code generating End here----------------
    }
//Bar code End here=======================================================================

//Bar code Menual Generator Start here=======================================================================
    public function script_barcode($bc_data){

        //Bar code generating Start here----------------
         $font     = './private/fonts/arialbd.ttf';
          // - -

          $fontSize = 12;   // GD1 in px ; GD2 in point
          $marge    = 10;   // between barcode and hri in pixel
          $x        = 100;  // barcode center
          $y        = 35;  // barcode center
          $height   = 50;   // barcode height in 1D ; module size in 2D
          $width    = 2;    // barcode height in 1D ; not use in 2D
          $angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation

          $code     = $bc_data; // barcode, of course ;)
          $type     = "code128";

          // -------------------------------------------------- //
          //                    USEFUL
          // -------------------------------------------------- //

          // -------------------------------------------------- //
          //            ALLOCATE GD RESSOURCE
          // -------------------------------------------------- //
          $im     = imagecreatetruecolor(200, 61);
          $black  = ImageColorAllocate($im,0x00,0x00,0x00);
          $white  = ImageColorAllocate($im,0xff,0xff,0xff);
          $red    = ImageColorAllocate($im,0xff,0x00,0x00);
          $blue   = ImageColorAllocate($im,0x00,0x00,0xff);
          imagefilledrectangle($im, 0, 0, 200, 61, $white);

          // -------------------------------------------------- //
          //                      BARCODE
          // -------------------------------------------------- //
          $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);

          // -------------------------------------------------- //
          //        HRI (Human readable Interpretation)
          // -------------------------------------------------- //
          if ( isset($font) ){
            $box = imagettfbbox($fontSize, 0, $font, $code);
            $len = $box[2] - $box[0];
            Barcode::rotate(-$len / 2, (50 / 2) + $fontSize + $marge, $angle, $xt, $yt);
            imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $black, $font, $code);
          }

          //imagepng($im);
          //header('Content-type: image/png');
          //header('Content-Disposition: attachment; filename='.$code.'.png');
          //addFile(header('Content-Disposition: attachment; filename='.$code.'.png'));
          $random_num=rand();
          $success=imagepng($im, './public/uploaded_barcode/'.$code.image_type_to_extension(IMAGETYPE_PNG));
          imagedestroy($im);
         // echo $code. image_type_to_extension(IMAGETYPE_PNG);
         echo $random_num.image_type_to_extension(IMAGETYPE_PNG);
        //Bar code generating End here----------------
    }

    public function generator(){
    $datas = array("100001");

    foreach($datas as $data){
	$this->script_barcode($data);
    }
    }
//Bar code Menual Generator End here=======================================================================

public function generate_all_barcode(){
        
        $code = $this->action->read_col("products","product_code");
        $barcode = $this->action->read('barcode');
         
         
         
         
        foreach($code as  $val){
     
           //Bar code generating Start here----------------                
                $product_code = $val->product_code;
            
                 $barcode = $this->action->read('barcode');
                 
                 
                 $font     = './private/fonts/arialbd.ttf';
                  // - -
        
                  $fontSize = 12;   // GD1 in px ; GD2 in point
                  $marge    = 10;   // between barcode and hri in pixel
                  $x        = $barcode[0]->pos_x;  // barcode center
                  $y        = $barcode[0]->pos_y;  // barcode center
                  $height   = $barcode[0]->code_height;   // barcode height in 1D ; module size in 2D
                  $width    =$barcode[0]->code_width;    // barcode height in 1D ; not use in 2D
                  //$width    = 2;    // barcode height in 1D ; not use in 2D
                  $angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
        
                  $code     = $product_code; // barcode, of course ;)
                  $type     = $barcode[0]->code_type;
                  $image_height = $barcode[0]->img_height;
                  $image_width = $barcode[0]->img_width;  
                  // -------------------------------------------------- //
                  //                    USEFUL
                  // -------------------------------------------------- //
        
                  // -------------------------------------------------- //
                  //            ALLOCATE GD RESSOURCE
                  // -------------------------------------------------- //
                  $im     = imagecreatetruecolor($image_width, $image_height);
                  $black  = ImageColorAllocate($im,0x00,0x00,0x00);
                  $white  = ImageColorAllocate($im,0xff,0xff,0xff);
                  $red    = ImageColorAllocate($im,0xff,0x00,0x00);
                  $blue   = ImageColorAllocate($im,0x00,0x00,0xff);
                  imagefilledrectangle($im, 0, 0, $image_width, $image_height, $white);
        
                  // -------------------------------------------------- //
                  //                      BARCODE
                  // -------------------------------------------------- //
                  $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);
        
                  // -------------------------------------------------- //
                  //        HRI (Human readable Interpretation)
                  // -------------------------------------------------- //
                  if ( isset($font) ){
                    $box = imagettfbbox($fontSize, 0, $font, $data['hri']);
                    $len = $box[2] - $box[0];
                    Barcode::rotate(-$len / 2, ($height / 2) + $fontSize + $marge, $angle, $xt, $yt);
                    imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $black, $font, $data['hri']);
                  }
        
    
                  $success=imagepng($im, './public/uploaded_barcode/'.$product_code.image_type_to_extension(IMAGETYPE_PNG));
                  imagedestroy($im);
                 // echo $code. image_type_to_extension(IMAGETYPE_PNG);
                  $product_code.image_type_to_extension(IMAGETYPE_PNG);              
        
        }
        
        
        $msg_array=array(
            'title'=>'success',
            'emit'=>'Barcode Successfully Generated!',
            'btn'=>true
         );
        $this->data['confirmation']=message('success',$msg_array);
        $this->session->set_flashdata('confirmation',$this->data['confirmation']);        
        
        redirect('barcode/barcodeSetting','refresh');
        
         
}






//Generate Barcode By Ajax request Start here==============================================================

public function ajax_barcode_gen(){

	$code = $this->input->post("code");
        $receive = $this->action->read("barcode");
        $data = $receive[0];

        //Bar code generating Start here----------------
         $font     = './private/fonts/arialbd.ttf';
          // - -

          $fontSize = 12;   // GD1 in px ; GD2 in point
          $marge    = 10;   // between barcode and hri in pixel
          $x        = $data->pos_x;  // barcode center
          $y        = $data->pos_y;;  // barcode center
          $height   = $data->code_height;   // barcode height in 1D ; module size in 2D
          $width    = $data->code_width;   // barcode height in 1D ; not use in 2D
          //$width    = 2;    // barcode height in 1D ; not use in 2D
          $angle    = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation

          $code     = $code; // barcode, of course ;)
          $type     = $data->code_type;

          // -------------------------------------------------- //
          //                    USEFUL
          // -------------------------------------------------- //

          // -------------------------------------------------- //
          //            ALLOCATE GD RESSOURCE
          // -------------------------------------------------- //
          $im     = imagecreatetruecolor($data->img_width, $data->img_height);
          $black  = ImageColorAllocate($im,0x00,0x00,0x00);
          $white  = ImageColorAllocate($im,0xff,0xff,0xff);
          $red    = ImageColorAllocate($im,0xff,0x00,0x00);
          $blue   = ImageColorAllocate($im,0x00,0x00,0xff);
          imagefilledrectangle($im, 0, 0, $data->img_width, $data->img_height, $white);

          // -------------------------------------------------- //
          //                      BARCODE
          // -------------------------------------------------- //
          $data = Barcode::gd($im, $black, $x, $y, $angle, $type, array('code'=>$code), $width, $height);

          // -------------------------------------------------- //
          //        HRI (Human readable Interpretation)
          // -------------------------------------------------- //
          if ( isset($font) ){
            $box = imagettfbbox($fontSize, 0, $font, $code);
            $len = $box[2] - $box[0];
            Barcode::rotate(-$len / 2, ($data['height'] / 2) + $fontSize + $marge, $angle, $xt, $yt);
            imagettftext($im, $fontSize, $angle, $x + $xt, $y + $yt, $black, $font, $code);
          }

          $url = './public/uploaded_barcode/'.$code.image_type_to_extension(IMAGETYPE_PNG);
          $success=imagepng($im,$url);
	  if($success){
	  	echo $url;
	  }
          imagedestroy($im);
         // echo $code. image_type_to_extension(IMAGETYPE_PNG);
        // echo $random_num.image_type_to_extension(IMAGETYPE_PNG);
       // Bar code generating End here----------------
}

//Generate Barcode By Ajax request End here================================================================


    private function holder(){
       if($this->session->userdata('holder') == null){
            $this->membership_m->logout();
            redirect('access/users/login');
        }
    }

}
