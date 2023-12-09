<?php
/*
 * This is used to manage Promocode  
 *  */

class Promocode extends CI_Controller{
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
        $NumberOfUserd = 1;
        $data["allPromocodes"] = $this->promocode_model->getAllPromo($NumberOfUserd); 
        $data["allUsers"] = $this->user_model->getAllUser(); 
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('promocode/index', $data);
        $this->load->view('layout/footer', $data);
    }
    
    public function add(){
        if( $this->session->userdata("txtEmail") == ""){
            redirect("user/login");
        }
       $data["title"] = "Add Promocode"; 
       $this->load->view('layout/header', $data);
       $this->load->view('layout/sidebar', $data);
       $this->load->view('promocode/add', $data);
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
       $this->load->view('promocode/edit', $data);
       $this->load->view('layout/footer', $data);
    }
    
    public function view( $id ){
      if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
       $data["title"] = "Edit Promocode"; 
       $data["promocodeData"] = $this->promocode_model->getUsersPromo( $id ); 
       //echo $data["promocodeData"]; die();
       $this->load->view('layout/header', $data);
       $this->load->view('layout/sidebar', $data);
       $this->load->view('promocode/view', $data);
       $this->load->view('layout/footer', $data);
    }
    
    public function delete( $id ){
        if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
        $delete = $this->promocode_model->deletePromoCode( $id );
        if( $delete == 1 ){
            redirect( "promocode/index?msg=1" );
        }else{
            redirect( "promocode/index?msg=2" );
        }
    }
    
        public function deleteAll( ){
        if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
        // $delete = $this->db->delete('tblUserPromo');
        $delete = $this->db->truncate('tblPromocode');
        // echo $delete; die;
        // $delete = true;
        if( $delete){
            redirect( "promocode/index?msg=1" );
        }else{
            redirect( "promocode/index?msg=2" );
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
       // echo '<pre>'; print_r( $all );
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
        $txtStartDate = $this->input->post( "txtStartDate" );
        $txtEndDate = $this->input->post( "txtEndDate" );
        $NumberOfUserd = $this->input->post( "NumberOfUserd" );
        $txtStat = ( $txtStatus == "on" ? "Active" : "Inactive");
        if( $this->promocode_model->checkForPromocode($txtPromoCode) == 1 ){
            redirect("promocode/add?msg=2");
        }else{
             $data = array(
                        "txtPromoCode"  => $txtPromoCode,
                        "txtTotalCredit"   =>  $txtTotalCredit,
                        "txtStartDate"  => MysqliDateFormat($txtStartDate),
                        "txtEndDate"  => MysqliDateFormat($txtEndDate),
                        "txtStatus"   =>  $txtStat,
                        "NumberOfUserd"   =>  $NumberOfUserd
                        );
            $result = $this->promocode_model->addPromo( $data );
            redirect("promocode");
        }
    }
    
    /* Update Promocode */
    public function updatePromoCode( $txtPromoID ){
        $txtStatus = $this->input->post( "txtStatus" );
        $txtTotalCredit = $this->input->post( "txtTotalCredit" );
        $txtStartDate = $this->input->post( "txtStartDate" );
        $txtEndDate = $this->input->post( "txtEndDate" );
        $NumberOfUserd = $this->input->post( "NumberOfUserd" );
        $txtStat = ( $txtStatus == "on" ? "Active" : "Inactive");
        $data = array(
                    "txtTotalCredit"   =>  $txtTotalCredit,
                    "txtStartDate"  => MysqliDateFormat($txtStartDate),
                    "txtEndDate"  => MysqliDateFormat($txtEndDate),
                    "NumberOfUserd"  => $NumberOfUserd,
                    "txtStatus"   =>  $txtStat
                    );
        $this->promocode_model->updatePromo( $txtPromoID, $data );
        redirect("promocode");
    }
    
    /* Change Status of Promocode */
    public function changePromoCodeStatus(){
        $txtStatus = $this->input->post("txtStatus");
        $txtPromoID = $this->input->post("txtPromoID");
        $this->promocode_model->updatePromoCode( $txtPromoID, $txtStatus );
    }
    /* Ends */
    
    /* API */
    public function applyPromocode()
    {
        $txtUID = $this->input->post("txtUID");
        $txtDeviceToken = $this->input->post("txtDeviceToken");
        $txtPromoCode = $this->input->post("txtPromoCode");
        $txtDeviceName = $this->input->post("txtDeviceName");
        
        file_put_contents(APPPATH.'controllers/test.txt', $txtUID.'-----------', FILE_APPEND);
        file_put_contents(APPPATH.'controllers/test.txt', $txtDeviceToken.'-----------', FILE_APPEND);
        file_put_contents(APPPATH.'controllers/test.txt', $txtPromoCode.'-----------', FILE_APPEND);
        file_put_contents(APPPATH.'controllers/test.txt', $txtDeviceName.'-----------', FILE_APPEND);
        
       
        $verifyPromoCode = $this->promocode_model->verifyPromoCode($txtPromoCode );
        // echo "<pre>"; print_r($verifyPromoCode["txtStartDate"]); exit();
        
        $txtTotalCredit = $verifyPromoCode['txtTotalCredit'];
        $NumberOfUserd = $verifyPromoCode['NumberOfUserd'];
        $txtPromoID = $verifyPromoCode['txtPromoID'];
        
        if($verifyPromoCode == 0)
        {
            $status = array("code" => 422, "msg" => "Promocode is not valid or already used");
            file_put_contents(APPPATH.'controllers/test.txt', json_encode($status).'-----------', FILE_APPEND);
            echo json_encode( $status );
        }
        else
        {
            if($NumberOfUserd == 0)
            {
                $credit = $this->promocode_model->verifyPromoCode( $txtPromoCode );
                $status = array("code"  =>200,"msg"   =>"Promocode is applied","txtTotalCredit" => $credit["txtTotalCredit"]);
                $this->promocode_model->updateUserPromo($credit["txtPromoID"], $credit["txtTotalCredit"],$txtUID,$txtDeviceToken,$txtDeviceName);
                file_put_contents(APPPATH.'controllers/test.txt', json_encode($status).'-----------', FILE_APPEND);
                echo json_encode( $status );
            }
            else
            {
                //date condition if 000 then go ahed  if not 000 then check condition of valid date
                //means promocode master generated code use bt promocode generated code not used
                if($verifyPromoCode["txtStartDate"] !="0000-00-00"){
                   
                    $check_valid_date=$this->promocode_model->checkdate($txtPromoCode );
                    if($check_valid_date=="no_data"){
                      $status = array("code" => 400, "msg" => "Promocode is out dated.");
                      file_put_contents(APPPATH.'controllers/test.txt', json_encode($status).'-----------', FILE_APPEND);
                      echo json_encode( $status ); exit(); 
                    }
                   
                }
                  
                $credit = $this->promocode_model->verifyPromoCode( $txtPromoCode );
                $status = array("code"  =>200,"msg"   =>"Promocode is applied","txtTotalCredit" => $credit["txtTotalCredit"]);
                $this->promocode_model->updateUserPromo($credit["txtPromoID"], $credit["txtTotalCredit"],$txtUID,$txtDeviceToken,$txtDeviceName);

                $PromoUsedCount = $this->promocode_model->checkUsedPromoCount($credit["txtPromoID"]);
                if($NumberOfUserd == $PromoUsedCount){
                    $this->promocode_model->disablePromoCode($credit["txtPromoID"]);                    
                }
                file_put_contents(APPPATH.'controllers/test.txt', json_encode($status).'-----------', FILE_APPEND);
                echo json_encode( $status );
            }
        }
    }
    /* API */
}
