<?php
/*
 * This is used to manage Promocode  
 *  */

class Dashboard extends CI_Controller{
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
    
    public function index(){
   if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
 /* ----------------------   for Recent FAX & PAYMENT REnder -------- -----------------------*/   
        $limit=5;
        $data["recent_fax"] = $this->fax_model->get_recent_fax($limit);
        $data["recent_payment"] = $this->payment_model->get_recent_payment($limit);

/* ----------------------   for Recent FAX & PAYMENT REnder end-------- -----------------------*/  

/* ----------------------   for Brachart of Fax MOnthwise -------- -----------------------*/

            //$shorting_by=$this->uri->segment(3); 
       
        $fax_sent = $this->fax_model->get_fax_by("success","month");
        $fax_draft = $this->fax_model->get_fax_by("draft","month");
        $fax_failed = $this->fax_model->get_fax_by("failure","month");

       /* (1)for sent */
        $result = array();
        $revenuDays = array();
          
        foreach($fax_sent as $row){
            $d = date_parse_from_format("Y-m-d", $row->txtCompletedAt);
            $month=$d["month"];
            $revenuDays[$month-1] = $row->total;
         }
           //print_r($revenuDays); exit();
        for ($i = 0; $i < 12; $i++) {
            if (array_key_exists($i, $revenuDays)) {
                //$data[$i]['y'] = $i;
                $result[$i] = $revenuDays[$i];
            } else {
                //$data[$i]['y'] = $i;
                $result[$i] = 0;
            }
        }
        $data['sent'] =  $result;

        /* (2) for draft */
        $result2 = array();
        $revenuDays2 = array();
        foreach($fax_draft as $row){
            $d = date_parse_from_format("Y-m-d", $row->txtCompletedAt);   
            $month=$d["month"];
            $revenuDays2[$month-1] = $row->total;
         }

        for ($i = 0; $i < 12; $i++) {
            if (array_key_exists($i, $revenuDays2)) {
                //$data[$i]['y'] = $i;
                $result2[$i] = $revenuDays2[$i];
            } else {
                //$data[$i]['y'] = $i;
                $result2[$i] = 0;
            }
        }

        /* (3)for failed */
          
            $result3 = array();
            $revenuDays3 = array();
          foreach($fax_failed as $row){
            $d = date_parse_from_format("Y-m-d", $row->txtCompletedAt);
            $month=$d["month"];
            $revenuDays3[$month-1] = $row->total;
         }
    
         for ($i = 0; $i < 12; $i++) {
            if (array_key_exists($i, $revenuDays3)) {
                //$data[$i]['y'] = $i;
                $result3[$i] = $revenuDays3[$i];
            } else {
                //$data[$i]['y'] = $i;
                $result3[$i] = 0;
            }
        }


        $data['sent'] =  $result;
        $data['draft'] = $result2; 
        $data['failed'] = $result3; 

/* --------------------   for Brachart of Fax  MOnthwise end-------------------------------- */

/* --------------------   for Brachart of Fax  Weekwise-------------------------------- */


$fax_sent_W = $this->fax_model->get_fax_by_week("success","week"); 
$data['sent_week']=array_values($fax_sent_W); 

$fax_fail_W = $this->fax_model->get_fax_by_week("failure","week"); 
$data['fail_week']=array_values($fax_fail_W); 
        

/* --------------------   for Brachart of Fax  Weekwise-------------------------------- */
/* --------------------   for Brachart of Fax  daywise-------------------------------- */


$fax_sent_D = $this->fax_model->get_fax_by_day("success","day"); 
$data['sent_day']=array_values($fax_sent_D); 

$fax_fail_D = $this->fax_model->get_fax_by_day("failure","day"); 
$data['fail_day']=array_values($fax_fail_D); 
        
/* --------------------   for Brachart of Fax  daywise-------------------------------- */


/* -------------------------for barchart of Payment monthwise------------------------------- */
        $payment_charged = $this->payment_model->get_payment_by("charged","month");

        $result_ch = array();
        $revenuDays_ch = array();
          
        foreach($payment_charged as $row){
            $d = date_parse_from_format("Y-m-d", $row->txtDate);
            $month=$d["month"];
            $revenuDays_ch[$month-1] = $row->total;
         }
           //print_r($revenuDays); exit();
        for ($i = 0; $i < 12; $i++) {
            if (array_key_exists($i, $revenuDays_ch)) {
                //$data[$i]['y'] = $i;
                $result_ch[$i] = $revenuDays_ch[$i];
            } else {
                //$data[$i]['y'] = $i;
                $result_ch[$i] = 0;
            }
        }
        $data['payment_charged'] =  $result_ch;

        $payment_declined = $this->payment_model->get_payment_by("payment declined","month");
        $result_de = array();
        $revenuDays_de = array();
        foreach($payment_declined as $row){
            $d = date_parse_from_format("Y-m-d", $row->txtDate);
            $month=$d["month"];
            $revenuDays_de[$month-1] = $row->total;
         }
           //print_r($revenuDays); exit();
        for ($i = 0; $i < 12; $i++) {
            if (array_key_exists($i, $revenuDays_de)) {
                //$data[$i]['y'] = $i;
                $result_de[$i] = $revenuDays_de[$i];
            } else {
                //$data[$i]['y'] = $i;
                $result_de[$i] = 0;
            }
        }
        $data['payment_declined'] =  $result_de;
       /* -------------------------for barchart of Payment monthwise end------------------------------- */
       /* -------------------------for barchart of Payment weekwise------------------------------- */
        
        $payment_charged_W = $this->payment_model->get_payment_by_week("charged","week"); 
        $data['payment_charged_W']=array_values($payment_charged_W); 

        $payment_declined_W = $this->payment_model->get_payment_by_week("payment declined","week"); 
        $data['payment_declined_W']=array_values($payment_declined_W);    

      /* -------------------------for barchart of Payment weekwise- end------------------------------ */

      /* -------------------------for barchart of Payment daywise------------------------------- */

        $payment_charged_D= $this->payment_model->get_payment_by_day("charged","day"); 
        $data['payment_charged_D']=array_values($payment_charged_D); 

        $payment_declined_D = $this->payment_model->get_payment_by_day("payment declined","day"); 
        $data['payment_declined_D']=array_values($payment_declined_D); 

        /* -------------------------for barchart of Payment daywise end------------------------------- */                                 
       
        $this->load->view('layout/header');
        $this->load->view('layout/sidebar');
        $this->load->view('dashboard/index',$data);
        $this->load->view('layout/footer');
        
    }

  
    
} // end of class
