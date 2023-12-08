<?php 
class Fax_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->table = 'tblFax';
        $this->load->database();
    }

  

    // Inserting in Table(fax)
    public function add_fax_data($data){

         $abs=$this->db->insert('tblFax', $data);
         if($abs)
         {
          return $this->db->insert_id();

         }
         else
         {
            return false;
         }
    }

      public function getfaxFilter($postArr)
      {
       
        $filter_by = $postArr['filter_by'];
        $sorting_by = $postArr['sorting_by'];

        if($postArr['filter_by'] == 1)
        {
          $from_date = $postArr['from_date'].' 00:00:01';
          $to_date = $postArr['to_date'].' 23:59:59';
        }
        else if($postArr['filter_by'] == 2)
        {
          $month_name = $postArr['month_name'];
          $month_year = $postArr['month_year'];
          $from_date =  date("$month_year-$month_name-01");
          $to_date = date("$month_year-$month_name-t");
        }
        else
        {
          $year = $postArr['year'];
          $from_date =  date("$year-01-01");
          $to_date = date("$year-12-t");
        }

        $this->db->select('*');
        $this->db->from('tblFax'); 
        $this->db->where('txtRequestedAt >=', $from_date);
        $this->db->where('txtRequestedAt <=', $to_date);
        if($sorting_by=="sent")
        {
          $this->db->where('txtStatus','success');
        }
        if($sorting_by=="draft")
        {
          $this->db->where('txtStatus', $sorting_by);
        }
        if($sorting_by=="failed")
        {
          $this->db->where('txtStatus','failure');
        }
        $this->db->order_by("txtRequestedAt", "desc");
        $query = $this->db->get()->result();
        return $query;
      }


      public function getAllfax($shorting_by)
      {
          $this->db->select('*');
          $this->db->from('tblFax'); 
          if($shorting_by=="all")
          {
            //no condition for all
          }
          if($shorting_by=="sent")
          {
            // for sent
            $this->db->where('txtStatus','success');//sent
          }
          if($shorting_by=="draft")
          {
            // for draft
            $this->db->where('txtStatus', $shorting_by);
          }
          if($shorting_by=="failed")
          {
            // for failded
            $this->db->where('txtStatus','failure');
          }
          $this->db->order_by("txtRequestedAt", "desc");
          //$this->db->where('txtEmail', $txtEmail);
          $query= $this->db->get()->result();
          return $query;
      }
    
    /* use for SMS */
    public function getMobileNumber(){
         /*//$this->db->select('txtvalue');  
         $this->db->select('txtvalue,txtvalue2');
         $this->db->from('tblsetting');
         $this->db->where('txtkey','admin_mobile_number');
         $this->db->where('txtlable','mobile_number');
         $query= $this->db->get()->result();
         return $query;*/
         $this->db->select('');
         $this->db->from('tblsetting');
         $query= $this->db->get()->result();
         return $query;
    }
     /* use for add fax data api */
    public function checkdata($txtOrderNo){

         $this->db->select('*');
         $this->db->from('tblFax');
         $this->db->where('txtOrderNo',$txtOrderNo);
         $query= $this->db->get()->result();
         return $query;

    }

     /* use for cron */
    public function getReadyToSend(){

         $this->db->select('*');
         $this->db->from('tblFax');
         $this->db->where('txtStatus','ready to send');
         $query= $this->db->get()->result();
         return $query;

    }

     /* use for add fax data api */
     public function getFaxdata($txtUID,$txtDeviceId,$txtOrderNo){
 
         $this->db->select('*');
         $this->db->from('tblFax')
         ->group_start()
         ->where('txtUID',$txtUID)
         ->or_where('txtDeviceId',$txtDeviceId)
         ->group_end();
        // $this->db->where_in('txtOrderNo', explode(',', $txtOrderNo));
         $this->db->where('txtOrderNo',$txtOrderNo);
         $query= $this->db->get()->result();

         //  echo $this->db->last_query(); 
         // exit();
         return $query;
     }


     /* use for add fax data api */
     public function getfaxalldata($txtUID,$txtDeviceId){
 
      $this->db->select('*');
      $this->db->from('tblFax')
      ->group_start()
      ->where('txtUID',$txtUID)
      ->or_where('txtDeviceId',$txtDeviceId)
      ->group_end();
      $query= $this->db->order_by('txtFaxID','desc')->get()->result();
      return $query;
  }


    function update_fax_data($txtDeviceId,$txtOrderNo,$data){

     $this->db->where('txtOrderNo',$txtOrderNo);
     $this->db->where('txtDeviceId',$txtDeviceId);
     $query=$this->db->update('tblFax', $data);
     $affected_row=$this->db->affected_rows();
       
     //echo "<pre>"; print_r($query); exit();
      if($affected_row > 0)
      {
        return "yes";
      }
      else
      {
        return "no";
      }
    }

    public function  update_fax_to_new_data($txtOrderNo, $data) {
        $this->db->where('txtOrderNo',$txtOrderNo);
        $query=$this->db->update('tblFax', $data);
        $affected_row=$this->db->affected_rows();

        //echo "<pre>"; print_r($query); exit();
        if($affected_row > 0)
        {
            return "yes";
        }
        else
        {
            return "no";
        }
    }


     /* -- use for dashbord recent fax -- */
    public function get_recent_fax($limit=null,$start=null){
       
         $this->db->select('*');
         $this->db->from('tblFax'); 
         $this->db->order_by('txtCompletedAt', 'desc');
         $this->db->limit($limit, $start);
         $query= $this->db->get()->result();
         // echo $this->db->last_query(); 
        // exit();
        return $query;
    }
    


     /* -- use for dashbord  fax chart -- */
    public function get_fax_by($shorting,$by){

         if($by=='month')
         {
           $this->db->select('Count(*) AS total,txtCompletedAt');
         }
         if($by=='week')
         {
           $this->db->select('Count(*) AS total,txtCompletedAt,WEEK(txtCompletedAt) as week');
         }
    
         $this->db->from('tblFax');
         $this->db->where('txtStatus',$shorting);
         if($by=='month')
         {
           $this->db->group_by('MONTH(txtCompletedAt)');
         }
         if($by=='week')
         {
           $this->db->group_by('WEEK(txtCompletedAt)');
         }
         if($by=='day')
         {
           $this->db->group_by('DAY(txtCompletedAt)');
         }
         $query= $this->db->get()->result();
          //echo $this->db->last_query(); 
          //exit();
        return $query;
    }


   public function get_fax_by_week($shorting,$by){

        $query = $this->db->query("SELECT DISTINCT
    (SELECT count(*) FROM `tblFax` WHERE  txtStatus='$shorting' and WEEKOFYEAR(`txtCompletedAt`)=WEEKOFYEAR(NOW())-6) as 'week7',
    (SELECT count(*) FROM `tblFax` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtCompletedAt`)=WEEKOFYEAR(NOW())-5) as 'week6',
    (SELECT count(*) FROM `tblFax` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtCompletedAt`)=WEEKOFYEAR(NOW())-4) as 'week5',
    (SELECT count(*) FROM `tblFax` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtCompletedAt`)=WEEKOFYEAR(NOW())-3) as 'week4',
    (SELECT count(*) FROM `tblFax` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtCompletedAt`)=WEEKOFYEAR(NOW())-2) as 'week3',
    (SELECT count(*) FROM `tblFax` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtCompletedAt`)=WEEKOFYEAR(NOW())-1) as 'week2',
    (SELECT count(*) FROM `tblFax` WHERE txtStatus='$shorting' and WEEKOFYEAR(`txtCompletedAt`)=WEEKOFYEAR(NOW())) as 'week1'
    FROM `tblFax`");
      $results = $query->row_array();
      //echo $this->db->last_query(); 
        // exit();
     return $results;
    }


    public function get_fax_by_day($shorting,$by){

        $query = $this->db->query("SELECT DISTINCT
    (SELECT count(*) FROM `tblFax` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtCompletedAt`)=DAYOFYEAR(NOW())-6) as 'day6',
    (SELECT count(*) FROM `tblFax` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtCompletedAt`)=DAYOFYEAR(NOW())-5) as 'day5',
    (SELECT count(*) FROM `tblFax` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtCompletedAt`)=DAYOFYEAR(NOW())-4) as 'day4',
    (SELECT count(*) FROM `tblFax` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtCompletedAt`)=DAYOFYEAR(NOW())-3) as 'day3',
    (SELECT count(*) FROM `tblFax` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtCompletedAt`)=DAYOFYEAR(NOW())-2) as 'day2',
    (SELECT count(*) FROM `tblFax` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtCompletedAt`)=DAYOFYEAR(NOW())-1) as 'day1',
    (SELECT count(*) FROM `tblFax` WHERE   txtStatus='$shorting' and DAYOFYEAR(`txtCompletedAt`)=DAYOFYEAR(NOW())) as 'day'
 
    FROM `tblFax`");
      $results = $query->row_array();
      //echo $this->db->last_query(); 
       //  exit();
     return $results;
    }

    
}// end of class


?>