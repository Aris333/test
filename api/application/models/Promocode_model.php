<?php 
class Promocode_model extends CI_Model{
    public function __construct() {
        parent::__construct();
        $this->table = 'tblPromocode';
        $this->load->database();
    }

    public function checkdate($txtPromoCode){
       $today=date("Y-m-d");
       $this->db->select('*');
       $this->db->from('tblPromocode');
       $this->db->where('txtStatus','Active');
       $this->db->where('txtPromoCode',$txtPromoCode);
       $this->db->where("txtStartDate <=", $today);
       $this->db->where("txtEndDate >=", $today);
       $query= $this->db->get()->result();
       // echo $this->db->last_query(); exit();
       //echo "<pre>"; print_r($query);
       if(empty($query)){
        return "no_data";
       }else{
        return "yes_data"; 
       }
    }
    
    public function getAllPromo($NumberOfUserd){
        $this->db->order_by("txtStatus", 'ASC');
        if($NumberOfUserd == 0){
            $this->db->where('NumberOfUserd', $NumberOfUserd);    
        }else{
            $this->db->where('NumberOfUserd != ',0);
        }
        $row = $this->db->get($this->table);
        return $row->result();
    }
    
    public function generatePromo( $txtPromoCounter ){
        $i=0;
        $allResult = array();
        while($i<$txtPromoCounter){
            $rand_str = $this->randString(6);
            //$rand_str = "Promo1";
            if( $this->isUsed($rand_str) == 1 ){
                //return 0;
            }else{
                $data = array(
                            "txtPromoCode"  => $rand_str,
                            "txtTotalCredit"   =>  "10",
                            "txtStatus"   =>  "Inactive"
                            );
                $result = $this->db->insert( "tblPromocode", $data );
                $row = $this->get_promo($rand_str);
                $allResult[] = $row;
            }
            $i++;
        }
        return $allResult;
    }
    
    public function get_promo($txtPromocode ) {
            $row = $this->db->get_where('tblPromocode', array('txtPromocode' => $txtPromocode))->row();
            return $row;
    }
    
    public function getPromoById( $txtPromoID ) {
            $row = $this->db->get_where('tblPromocode', array('txtPromoID' => $txtPromoID))->row();
            return $row;
    }
    
    
    function isUsed($uid){
        $stmt=$this->db->query("SELECT * FROM tblPromocode WHERE txtPromoCode='".$uid."'");
        if ($stmt->num_rows() > 0) {
           return 1;
        } else {            
           return 0;
           $this->generatePromo();            
        }
    }
    
    public function addPromo( $data ){ 
       $result = $this->db->insert( "tblPromocode", $data );      
    }
    
    public function updatePromo( $txtPromoID, $data ){ 
       
       $this->db->where('txtPromoID', $txtPromoID);
       $result = $this->db->update( "tblPromocode", $data );      
    }
    
    public function randString( $length ) {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0,$length);
    }
    
    public function verifyPromoCode($txtPromoCode){
        $row = $this->db->get_where('tblPromocode', array("txtPromoCode" => $txtPromoCode, "txtStatus"=>"Active"));
        if($row->num_rows() == 1){         
          $fetPromoID = $row->row();
          $d["txtTotalCredit"] = $fetPromoID->txtTotalCredit;
          $d["NumberOfUserd"] = $fetPromoID->NumberOfUserd;
          $d["txtPromoID"] = $fetPromoID->txtPromoID; 
          $d["txtStartDate"] = $fetPromoID->txtStartDate;  
          $d["txtEndDate"] = $fetPromoID->txtEndDate;           
          return $d;
        }else{
            return 0;
        }
    }
    
    public function deletePromoCode( $txtPromoID ){
        $this->db->where( "txtPromoID", $txtPromoID );
        $delete = $this->db->delete( "tblPromocode" );
        if( $delete ){
            return 1;
        }else{
            return 0;
        }
    }
    
    public function updateUserPromo( $txtPromoID, $txtTotalCredit,$txtUID,$txtDeviceToken,$txtDeviceName){
        $data = array(
                        "txtPromoID"=> $txtPromoID,
                        "txtTotalCredit"=>$txtTotalCredit,
                        "txtDeviceToken"=> $txtDeviceToken,
                        "txtUID"=> $txtUID,
                        "txtDeviceName"=>$txtDeviceName,
                        "txtDateUsed"   => date("Y-m-d H:i:s")
                );
        return $this->db->insert( "tblUserPromo", $data );
        /*if( $insert ){
            if($NumberOfUserd == $PromoUsedCount){
                $this->disablePromoCode( $txtPromoID );    
            }
            
        }*/
    }
    
    public function disablePromoCode( $txtPromoID ){
        $this->db->set("txtStatus", "Used");
        $this->db->where("txtPromoID", $txtPromoID);
        $this->db->update("tblPromocode");
    }
    
    public function updatePromoCode( $txtPromoID, $txtStatus ){
        $this->db->set( "txtStatus", $txtStatus );
        $this->db->where("txtPromoID", $txtPromoID);
        $this->db->update("tblPromocode");
    }
    
   public function getUsersPromo( $txtPromoID ){
        //$this->db->select('UP.*, PC.*, U.*, UP.txtTotalCredit as TotalUserCredit');        
        $this->db->select('*');        
        $this->db->from('tblPromocode');
        //$this->db->join('tblUserPromo UP', 'UP.txtPromoID = PC.txtPromoID', 'right');
        //$this->db->join('tblUsers U', 'U.txtUID = UP.txtUID', 'right');
        $this->db->where( 'txtPromoID', $txtPromoID );
        $query = $this->db->get()->row();        
        return $query;
   } 
   
   public function checkForPromocode( $txtPromocode ){
       $row = $this->db->get_where('tblPromocode', array('txtPromocode' => $txtPromocode));
       if( $row->num_rows() > 0){
           return 1;
       }else{
           return 0;
       }
   }

    public function checkUsedPromoCount($txtPromoID){
        $this->db->where( 'txtPromoID', $txtPromoID );
        $num_rows = $this->db->count_all_results('tblUserPromo');
        return $num_rows;       
    }

   
}
?>