<?php
/*
 * This is used to manage Promocode  
 *  */

class Promocodemaster extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('user_model');
        $this->load->model("promocode_model");
        $this->load->helper( "my_custom_helper" );
        $this->load->library('session');
    }
    
    public function index(){
        if( $this->session->userdata("txtEmail") == ""){
            redirect("user/login");
        }
        $data["title"] = "Promocode";
        $NumberOfUserd = 0;
        $data["allPromocodes"] = $this->promocode_model->getAllPromo($NumberOfUserd); 
        $data["allUsers"] = $this->user_model->getAllUser(); 
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('promocode/promocodemaster', $data);
        $this->load->view('layout/footer', $data);
    }
    
    public function add(){
        if( $this->session->userdata("txtEmail") == ""){
            redirect("user/login");
        }
       $data["title"] = "Add Promocode"; 
       $this->load->view('layout/header', $data);
       $this->load->view('layout/sidebar', $data);
       $this->load->view('promocode/masteradd', $data);
       $this->load->view('layout/footer', $data);
    }
    
    public function edit( $id ){
        if( $this->session->userdata("txtEmail") == ""){
            redirect("user/login");
        }
       $data["title"] = "Edit Promocode"; 
       $data["promocodeData"] = $this->promocode_model->getPromoById( $id ); 
       $this->load->view('layout/header', $data);
       $this->load->view('layout/sidebar', $data);
       $this->load->view('promocode/masteredit', $data);
       $this->load->view('layout/footer', $data);
    }
    
    public function view( $id ){
        if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
       $data["title"] = "Edit Promocode"; 
       $data["promocodeData"] = $this->promocode_model->getUsersPromo( $id ); 
       //echo $data["promocodeData"]; die();
       $this->load->view('layout/header', $data);
       $this->load->view('layout/sidebar', $data);
       $this->load->view('promocode/masterview', $data);
       $this->load->view('layout/footer', $data);
    }
    
    public function delete( $id ){
        if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
        $delete = $this->promocode_model->deletePromoCode( $id );
        if( $delete == 1 ){
            redirect( "promocodemaster/index?msg=1" );
        }else{
            redirect( "promocodemaster/index?msg=2" );
        }
    }
    
    
    public function generatepromo(){
       $data["title"] = "Generate Promocode"; 
       $this->load->view('layout/header', $data);
       $this->load->view('layout/sidebar', $data);
       $this->load->view('promocode/generatepromo', $data);
       $this->load->view('layout/footer', $data);
    }
    
    public function generateAllPromo(){
        $txtPromoCounter = $this->input->get( "txtPromoCounter" );
        $all = $this->promocode_model->generatePromo( $txtPromoCounter );
    }
    
    
    public function sendPromoEmailToUser(){
        $this->load->library('email'); 
        $txtEmailPromoCode = $this->input->post( "promocodeData[txtEmailPromoCode]" );
        $txtEmailTotalCredit = $this->input->post( "promocodeData[txtEmailTotalCredit]" );
        $txtEmailUser = $this->input->post( "promocodeData[txtEmailUser]" );
        $from = "admin@speedyfax.com";
        $this->email->from( $from, 'SpeedyFax Admin' ); 
        $this->email->to( $txtEmailUser );
        $this->email->subject( 'New Promocode | SpeedyFax' ); 
        $message = "Use this promocode into app '".$txtEmailPromoCode."' which has '".$txtEmailTotalCredit."' credits...";
        $this->email->message( $message ); 
        //Send mail 
        if($this->email->send()) {
            echo 1;
        }else {
            echo 0;
        }
    }
    
    /* Check for Promocode is exist */
    public function addPromo(){
        $txtPromoCode = $this->input->post( "txtPromoCode" );
        $txtStatus = $this->input->post( "txtStatus" );
        $txtTotalCredit = $this->input->post( "txtTotalCredit" );
        $txtStat = ( $txtStatus == "on" ? "Active" : "Inactive");
        if( $this->promocode_model->checkForPromocode($txtPromoCode) == 1 ){
            redirect("promocodemaster/add?msg=2");
        }else{
             $data = array(
                        "txtPromoCode"  => $txtPromoCode,
                        "txtTotalCredit"   =>  $txtTotalCredit,
                        "txtStatus"   =>  $txtStat
                        );
            $result = $this->promocode_model->addPromo( $data );
            redirect("promocodemaster");
        }
    }
    
    /* Update Promocode */
    public function updatePromoCode( $txtPromoID )
    {
        $txtStatus = $this->input->post( "txtStatus" );
        $txtTotalCredit = $this->input->post( "txtTotalCredit" );
        $txtStat = ( $txtStatus == "on" ? "Active" : "Inactive");
        $data = array(
                    "txtTotalCredit"   =>  $txtTotalCredit,
                    "txtStatus"   =>  $txtStat
                    );
        $this->promocode_model->updatePromo( $txtPromoID, $data );
        redirect("promocodemaster");
    }
    
    /* Change Status of Promocode */
    public function changePromoCodeStatus(){
        $txtStatus = $this->input->post("txtStatus");
        $txtPromoID = $this->input->post("txtPromoID");
        $this->promocode_model->updatePromoCode( $txtPromoID, $txtStatus );
    }
    /* Ends */
    
    /* API */
    public function applyPromocode(){
        $txtUID = null;
        $txtDeviceToken = $this->input->post("txtDeviceToken");
        $txtPromoCode = $this->input->post("txtPromoCode");
        $txtDeviceName = $this->input->post("txtDeviceName");
        if( $this->promocode_model->verifyPromoCode($txtPromoCode ) == 0 ){
            $status = array(
                            "code"  =>422,
                            "msg"   =>"Promocode is not valid or already used"                            
                        );
            echo json_encode( $status );
        }else{
            $credit = $this->promocode_model->verifyPromoCode( $txtUID, $txtPromoCode );
            $status = array(
                            "code"  =>200,
                            "msg"   =>"Promocode is applied",
                            "txtTotalCredit" => $credit["txtTotalCredit"]
                        );
            
            $this->promocode_model->updateUserPromo( $txtUID, $credit["txtPromoID"], $credit["txtTotalCredit"],$txtDeviceToken,$txtDeviceName );
            echo json_encode( $status );
        }
    }
    /* API */
    
}
