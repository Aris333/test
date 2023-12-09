<?php 
class Credits_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->table = 'tblcredits';
        $this->load->database();
    }

     public function xyz($id)
      {

          $this->db->select('*');
          $this->db->from('tblcredits'); 
          $this->db->where('status',1);
          $this->db->where("county_id LIKE '$id'");
          $this->db->or_where("county_id  LIKE '%,$id'");
          $this->db->or_where("county_id LIKE '%,$id,%'");
          $this->db->or_where("county_id LIKE '$id,%'");
          $query= $this->db->get()->result();
          //echo $this->db->last_query(); exit();
          return $query;
      }

      public function rowByCid($id)
      {

          $this->db->select('*');
          $this->db->from('tblcredits'); 
         // $this->db->where('status',1);
          $this->db->where("county_id LIKE '$id'");
          $this->db->or_where("county_id  LIKE '%,$id'");
          $this->db->or_where("county_id LIKE '%,$id,%'");
          $this->db->or_where("county_id LIKE '$id,%'");
          $query= $this->db->get()->result();
          //echo $this->db->last_query(); exit();
          return $query;
      }
    
     function row_delete($id)
      {

       $this->db->where('id', $id);
       $this->db->delete('tblcredits'); 
      }

      /* use for api*/
      public function getCredits($id)
      {

          $this->db->select('*');
          $this->db->from('tblcredits'); 
          $this->db->where('status',1);
          $this->db->where("county_id LIKE '$id'");
          $this->db->or_where("county_id LIKE '%,$id'");
          $this->db->or_where("county_id LIKE '%,$id,%'");
          $this->db->or_where("county_id LIKE '$id,%'");
          $query= $this->db->get()->result();
          //echo $this->db->last_query(); exit();
          return $query;
      }
    
 
     /* use for adminpanel */
    public function get_all_creditsdata(){

         $this->db->select('*');
         $this->db->from('tblcredits');
         //$this->db->where('status',1);
         $query= $this->db->get()->result();
         return $query;

    }

    public function add_credits($postdata){

     
      $abs=$this->db->insert('tblcredits', $postdata);
         if($abs)
         {
            return true;
         }
         else
         {
            return false;
         }

    }
  public function getcredits_BYID($id){
 
         $this->db->select('*');
         $this->db->from('tblcredits');
         $this->db->where_in('id',$id);
         $query= $this->db->get()->result();
         return $query;
  }
  
 function update_credits($id,$data){
     $this->db->where('id',$id);
     $query=$this->db->update('tblcredits', $data);
      if($query)
      {
        return true;
      }
      else
      {
        return false;
      }
    }










     /* use for add fax data api */
     public function getFaxdata($txtDeviceId,$txtOrderNo){
 
         $this->db->select('*');
         $this->db->from('tblFax');
         $this->db->where('txtDeviceId',$txtDeviceId);
         $this->db->where_in('txtOrderNo', explode(',', $txtOrderNo));
         $query= $this->db->get()->result();
          //echo $this->db->last_query(); 
         //exit()
         return $query;
     }


    function update_fax_data($txtOrderNo,$data){
     $this->db->where('txtOrderNo',$txtOrderNo);
     $query=$this->db->update('tblFax', $data);
      if($query)
      {
        return true;
      }
      else
      {
        return false;
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