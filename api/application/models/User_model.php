<?php 
class User_model extends CI_Model{
    
    public function __construct() {
        parent::__construct();
        $this->table = 'tblUsers';
        $this->load->database();
        $this -> result_mode = 'object';
    }
    
    public function validateUser( $txtEmail, $txtPassword){
        $this->db->select('txtEmail', 'txtPassword');
        $this->db->from('tblUsers');
        $this->db->where('txtEmail', $txtEmail);
        $this->db->where('txtPassword', $txtPassword);
        $this->db->where('txtRole', "1");
// echo ($txtPassword); die;
        $query= $this->db->get();

        if($query->num_rows() == 1)
        {
            
           return true;
        }
        else
        {
            return false;
        }

    }
    
     public function getUserById( $txtUID ) {
            $row = $this->db->get_where('tblUsers', array('txtUID' => $txtUID))->row();
            return $row;
    }
    
    public function get_user($txtEmail ) {
            $row = $this->db->get_where('tblUsers', array('txtEmail' => $txtEmail))->row();
            return $row;
    }
    
    public function getAllUser( ) {
            $row = $this->db->order_by('txtUID', 'DESC')->get_where('tblUsers', array('txtRole'=>"2", 'txtStatus'=>'active'));
            return $row->result();
    }
    
    public function addUser( $data ){
        $txtPhone = ( $data["txtPhone"]!= "" ? $data["txtPhone"] : "");
        
        $allData = array(
                            "txtEmail"   =>  $data["txtEmail"],
                            "txtPassword"   =>  "",
                            "txtName"    => $data["txtName"],
                            "txtRole"   =>  2,
                            "txtPhone"   =>  $txtPhone,
                            "txtTotalCredit"  =>  0,
                            "txtLoginType"   =>  "fb",
                            "txtStatus" => "active",
                            "txtDateAdded" => date("Y-m-d")
                        );
        $this->db->insert("tblUsers", $allData);
    }
    
    public function updateUser( $txtEmail, $data ){
       
        $allData = array(
                            "txtName"    => $data["txtName"],
                            //"txtPhone"   =>  $data["txtPhone"],
                            //"txtTotalCredit"  =>  $data["txtTotalCredit"]
                        );
        $this->db->where( "txtEmail", $txtEmail );
        $this->db->update("tblUsers", $allData);
    }
    
    public function deleteUser( $txtUID ){
       
        $allData = array(
                            "txtStatus"    => "inactive"
                        );
        $this->db->where( "txtUID", $txtUID );
        $this->db->update("tblUsers", $allData);
    }
    
    // Check For User Exist and Is Active or not
    public function checkUserExist( $txtEmail ){
        $query = $this->db->get_where('tblUsers', array( 'txtEmail'=>$txtEmail, 'txtRole'=>"2", 'txtStatus'=>'active'));
       // $query= $this->db->get();

        if($query->num_rows() == 1){            
           return true;
        }else{
           return false;
        }
    }
    
    
    public function userExist( $txtEmail ){
        $this->db->select('txtEmail');
        $this->db->from('tblUsers');
        $this->db->where('txtEmail', $txtEmail);
        $query= $this->db->get();

        if($query->num_rows() == 1){            
           return true;
        }else{
           return false;
        }
    }
    
    public function updateUserCredit( $txtUID, $txtTotalCredit ){
        $this->db->set( "txtTotalCredit", $txtTotalCredit );
        $this->db->where( "txtUID", $txtUID );
        $update = $this->db->update( "tblUsers" );
        if( $update ){
            return 1;
        }else{
            return 0;
        }
    }
    
    // Get User's Promocode used history 
    public function usersPromoCodeHistory( $txtUID ){
        $this->db->select( "UP.*, PC.*, PC.txtTotalCredit");
        $this->db->from( "tblUserPromo UP" );
        $this->db->join( "tblPromocode PC", "UP.txtPromoID=PC.txtPromoID", "left" );
        $this->db->where( "UP.txtUID=".$txtUID);
        $query = $this->db->get()->result_object();
        return $query;
        
    }
    
    
}


?>