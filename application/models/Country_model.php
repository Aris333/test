<?php 
class Country_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->table = 'tblCountry';
        $this->load->database();
    }

    
    /* use for api */
      public function getAllCountry()
      {
          $this->db->select('*');
          $this->db->from('tblCountry'); 
          $this->db->where('status',1);
          //$this->db->where('txtEmail', $txtEmail);
          $query= $this->db->get()->result();
          return $query;
      }

    /* use for api */
    public function getCountryByCode($county_code)
    {

         $this->db->select('*');
         $this->db->from('tblCountry');
         $this->db->where('status',1);
         $this->db->where('county_code',$county_code);
         $query= $this->db->get()->result();
         return $query;
    }
    
       
     public function getCountry_and_credits()
    {
       
        $query = $this->db->query('SELECT a.id,a.county_name,a.county_code,a.flage_image,b.credits FROM tblCountry a LEFT JOIN tblcredits b ON FIND_IN_SET(a.id, b.county_id) > 0 GROUP BY a.id');
        $b=$query->result();
        if(count($b)>0){

            return $arrayName = array('data' =>$b);
        }else{

            return "no";
        }
        
    }

 /* use  for admin panel */
    public function remain_Cdata($id){
          $this->db->select('*');
          $this->db->from('tblCountry'); 
          $this->db->where('status',1);
          $this->db->where('id',$id);
          $query= $this->db->get()->result();
          //echo $this->db->last_query(); exit();
          return $query;


      }


}// end of class


?>