<?php 
class Payment_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->table = 'tblPayment';
        $this->load->database();
    }

    // Inserting in Table(fax) 
    public function add_payment_data($data){
       
         $abs=$this->db->insert('tblPayment', $data);
         if($abs)
         {
            return true;
         }
         else
         {
            return false;
         }
    }

     public function getAllpayment($shorting_by){

       $this->db->select('*');
       $this->db->from('tblPayment'); 
       if($shorting_by=="all")
       {
         //no condition for all
       }
      
       if($shorting_by=="charged")
       {
        // for charged
         $this->db->where('txtStatus', $shorting_by);
       }
      if($shorting_by=="payment_declined")
      {
         // for draft
         $this->db->where('txtStatus', "payment declined");
       }
        $this->db->order_by("txtDate", "desc");
        $query= $this->db->get()->result();
         // echo $this->db->last_query(); 
         // exit();
        return $query;
      
    }
    
    /* -- use for dashbord recent payment -- */
     public function get_recent_payment($limit=null,$start=null){
       
         $this->db->select('*');
         $this->db->from('tblPayment');
         // $this->db->order_by('txtPaymentID', 'desc');
         $this->db->order_by('txtDate', 'desc');
         $this->db->limit($limit, $start);
         $query= $this->db->get()->result();
         //  echo $this->db->last_query(); 
         // exit();
        return $query;
    }
    
    /* use for SMS */
       public function getMobileNumber(){

         $this->db->select('txtvalue');
         $this->db->from('tblsetting');
         $this->db->where('txtkey','admin_mobile_number');
         $this->db->where('txtlable','mobile_number');
         $query= $this->db->get()->result();
         return $query;

    }


    public function get_payment_by($shorting,$by){

         $this->db->select('Count(*) AS total,txtDate');
         $this->db->from('tblPayment');
         $this->db->where('txtStatus',$shorting);
         $this->db->group_by('MONTH(txtDate)');
         $query= $this->db->get()->result();
          //echo $this->db->last_query(); 
          //exit();
        return $query;
    }

    public function get_payment_by_week($shorting,$by){

        $query = $this->db->query("SELECT DISTINCT
    (SELECT count(*) FROM `tblPayment` WHERE  txtStatus='$shorting' and WEEKOFYEAR(`txtDate`)=WEEKOFYEAR(NOW())-6) as 'week7',
    (SELECT count(*) FROM `tblPayment` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtDate`)=WEEKOFYEAR(NOW())-5) as 'week6',
    (SELECT count(*) FROM `tblPayment` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtDate`)=WEEKOFYEAR(NOW())-4) as 'week5',
    (SELECT count(*) FROM `tblPayment` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtDate`)=WEEKOFYEAR(NOW())-3) as 'week4',
    (SELECT count(*) FROM `tblPayment` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtDate`)=WEEKOFYEAR(NOW())-2) as 'week3',
    (SELECT count(*) FROM `tblPayment` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtDate`)=WEEKOFYEAR(NOW())-1) as 'week2',
    (SELECT count(*) FROM `tblPayment` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtDate`)=WEEKOFYEAR(NOW())) as 'week1'
    FROM `tblPayment`");
      $results = $query->row_array();
      //echo $this->db->last_query(); 
        // exit();
     return $results;
    }


    public function get_payment_by_day($shorting,$by){

        $query = $this->db->query("SELECT DISTINCT
    (SELECT count(*) FROM `tblPayment` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtDate`)=DAYOFYEAR(NOW())-6) as 'day6',
    (SELECT count(*) FROM `tblPayment` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtDate`)=DAYOFYEAR(NOW())-5) as 'day5',
    (SELECT count(*) FROM `tblPayment` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtDate`)=DAYOFYEAR(NOW())-4) as 'day4',
    (SELECT count(*) FROM `tblPayment` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtDate`)=DAYOFYEAR(NOW())-3) as 'day3',
    (SELECT count(*) FROM `tblPayment` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtDate`)=DAYOFYEAR(NOW())-2) as 'day2',
    (SELECT count(*) FROM `tblPayment` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtDate`)=DAYOFYEAR(NOW())-1) as 'day1',
    (SELECT count(*) FROM `tblPayment` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtDate`)=DAYOFYEAR(NOW())) as 'day'
 
    FROM `tblPayment`");
      $results = $query->row_array();
      //echo $this->db->last_query(); 
       //  exit();
     return $results;
    }
    
}// end of class


?>
