<?php 
class Fax_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->table = 'tblFax';
        $this->load->database();
    }

    // Inserting in Table(fax) 
    public function get_recent_fax($limit=null,$start=null){
       
         $this->db->select('*');
         $this->db->from('tblFax');
         $this->db->->order_by('txtFaxID', 'desc');
         $this->db->limit($limit, $start);
          $query= $this->db->get()->result();
          echo $this->db->last_query(); 
         exit();
        return $query;
    }

     public function getAllfax($shorting_by){
       $this->db->select('*');
       $this->db->from('tblFax'); 
       if($shorting_by=="all")
       {
         //no condition for all
       }
      
       if($shorting_by=="sent")
       {
        // for sent
         $this->db->where('txtStatus', $shorting_by);
       }
      if($shorting_by=="draft")
      {
         // for draft
         $this->db->where('txtStatus', $shorting_by);
       }
       if($shorting_by=="failed")
       {
         // for failded
         $this->db->where('txtStatus', $shorting_by);
       }
     
      
        //$this->db->where('txtEmail', $txtEmail);
        $query= $this->db->get()->result();
         // echo $this->db->last_query(); 
         // exit();
        return $query;
      
    }
    
    
    
    
}// end of class


?>