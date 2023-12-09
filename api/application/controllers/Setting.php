<?php
/*
 * This is used to manage Promocode  
 *  */

class Setting extends CI_Controller{
      public function __construct(){
          parent::__construct();
          $this->load->library('form_validation');
          $this->load->helper('form');
          $this->load->model('user_model');
          $this->load->model("setting_model");
          $this->load->model("fax_model");
          $this->load->helper( "my_custom_helper" );
          $this->load->library('session');
          
      }

      public function index()
      {
         if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
          $data["allSettings"] = $this->setting_model->getSettings(); 
          $this->load->view('layout/header', $data);
          $this->load->view('layout/sidebar', $data);
          $this->load->view('setting/index', $data);
          $this->load->view('layout/footer', $data);
      }
      
      public function save()
      {
         if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
          $variable = $this->input->post();
          foreach ($variable as $key => $value)
          {
              $this->setting_model->update_setting1($key,$value);  
          }
          redirect("setting");
      }

        /* For Api */

         public function get_version()
      {
          $get_version=$this->setting_model->getSettings();
          if(isset($get_version) && !empty($get_version)){
          $app_setting_data=$get_version[2];
          $status=array("code"=>200,"msg"=>"success","data"=>$app_setting_data);
          }else{
            $status=array("code"=>400,"msg"=>"error","data"=>"no data get");
          }
          echo json_encode($status);
      }
} // end of class



  