<?php 
class Setting_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->table = 'tblPayment';
        $this->load->database();
    }

       
    public function getSettings(){
        $this->db->select("");
        $this->db->from("tblsetting");
        $result = $this->db->get()->result_array();
        return $result;
    }
    

    public function update_setting1($where,$set){
        $this->db->where('txtkey',$where);
        $update=$this->db->update('tblsetting', array('txtValue' => $set));
        if($update){ return true; } else{ return false; }
   }
}// end of class


?>