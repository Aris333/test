<?php
/*
 * This is used to manage Promocode  
 *  */

class Payment extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('user_model');
        $this->load->model("payment_model");
        $this->load->model("fax_model");
        $this->load->helper( "my_custom_helper" );
        $this->load->library('session');
        
    }
    
    // public function index(){
        
    // }

     public function payment_shorting(){
        
        if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");} 
        $shorting_by=$this->uri->segment(3);  
      
        $data["title"] = "Payment";
        $data["allpayment"] = $this->payment_model->getAllpayment($shorting_by);

        //$data["allUsers"] = $this->user_model->getAllUser(); 
        
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('payment/index', $data);
        $this->load->view('layout/footer', $data);
    }
    
    /* ------------------- API --------------------------------- */
    public function add_paymentdata(){
        $txtOrderID = $this->input->post("txtOrderID");
        $txtDate = $this->input->post("txtDate");
        $txtApp = $this->input->post("txtApp");
        $txtType = $this->input->post("txtType");
        $txtStatus = $this->input->post("txtStatus");
        $txtTotal = $this->input->post("txtTotal");
        $txtURL = $this->input->post("txtURL");
        
        if($txtOrderID=='' || $txtDate=='' || $txtApp=='' || $txtType=='' || $txtStatus=='' || $txtTotal=='')
        {
           $status = array("code"  =>400,"msg"   =>"please provided required fileds","status" =>1); 
           echo json_encode($status);
        }
        else{    
      
            if(isset($txtOrderID) && !empty($txtOrderID))
            {    
               $postdata = array(
                            'txtOrderID' => $txtOrderID,
                            'txtDate' => $txtDate,
                            'txtApp' => $txtApp,
                            'txtType' => $txtType,
                            'txtStatus' => $txtStatus,
                            'txtTotal' => $txtTotal,
                            'txtURL' => $txtURL,
                            'created'=>date("Y-m-d H:i:s")
                            );

                $insert=$this->payment_model->add_payment_data($postdata);
               
                if($insert)
                {  
                    if($txtStatus=="payment declined")
                    {   
                        $Message="Payment is declined for Order Id:-'".$txtOrderID."'.";
                        $mobileno=$this->fax_model->getMobileNumber();
                        //$admin_mobile_num=$mobileno[0]->txtvalue; 
                        $admin_mobile_num=array_filter([$mobileno[0]->txtvalue,$mobileno[1]->txtvalue]);
                        
                        configTwilio($admin_mobile_num,$Message ); // call to helper function
                        $status = array("code"  =>200,"msg"   =>"Payment data added successfully but payment declined","status" =>1);
                    }
                    else
                    {
                        $status = array("code"  =>200,"msg"   =>"Payment data added successfully","status" =>1);
                    }
                }
                else
                {
                   $status = array( "code"  =>400, "msg"   =>"Payment data Not added","status" =>0);

                }

                echo json_encode($status);
            }
        }
    }// end of function

       /* ------------------- API --------------------------------- */
    
} // end of class
