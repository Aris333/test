<?php
/*
 * This is used to manage Promocode  
 *  */

class Credits extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model("country_model");
        $this->load->model("credits_model");

        $this->load->library('session');
        $this->load->helper('date');
         
    }
    
    public function index(){

      if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
       $keys=array();
       $values=array();
        $ALL_Country_list = $this->country_model->getAllCountry();
        
        foreach ($ALL_Country_list as $key => $value) {
             array_push($keys,$value->id);
             array_push($values,$value->county_name);
        }
        $country=array_combine($keys, $values);
       
        $allcredtis = $this->credits_model->get_all_creditsdata();
        
        $data['allcredtis']=$allcredtis;
        $data['country']=$country; 

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('credits/index', $data);
        $this->load->view('layout/footer', $data);

    }


       public function add(){

       if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
        if(!empty($this->input->post('countryids')))
        {
          
          $county_id=implode(",",$this->input->post('countryids'));
          $credits=$this->input->post('credits');
          $status=($this->input->post('txtStatus')=='on')?'1':'0';
          
          $postdata = array(
                          'county_id' => $county_id,
                          'credits' => $credits,
                          'status' => $status,
                          'created'=>date("Y-m-d H:i:s")
                          );

          $insert=$this->credits_model->add_credits($postdata);
          if($insert){
           $this->session->set_flashdata('credit_add', 'Credits added Successfully');
           redirect('credits/index');
          }else{
            $this->session->set_flashdata('credit_add', 'Credits Not added.');
            redirect('credits/add');
          }
 
        }


        $ALL_Country_list = $this->country_model->getAllCountry();

        $data["ALL_Country_list"] = $ALL_Country_list;
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('credits/add', $data);
        $this->load->view('layout/footer', $data);

   
    }



        public function edit(){

        if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}



        $id=$this->uri->segment(3); 
        if(!empty($this->input->post('hidenid')))
        {

         $selected_country=$this->input->post('selected_country');

         $remain_country=$this->input->post('remain_country');

         $last_one=$this->input->post('last_one');
         // echo "<pre>sel"; print_r($selected_country);
         // echo "<pre>remain_country"; print_r($remain_country);
         // echo "<pre>"; print_r($last_one); exit();
         // echo "<pre>"; print_r($last_one);
         // echo "<pre>"; print_r($selected_country);
         // echo "<pre>"; print_r($remain_country); exit();
         /* if  $selected_country is null empty then delete checkbox id(cid) from credit table id*/

         if(empty($selected_country) && empty($remain_country)){
          
            $last_country=$this->credits_model->xyz1($last_one);// get id from country id from comma seperated
            //echo "<pre>"; print_r($last_country); exit();
            $delete_last_checkbox_uncheck=$this->credits_model->row_delete($last_country[0]->id);//delete if last checkbox uncheck
            $this->session->set_flashdata('credit_edit', 'Credits Update Successfully');
            redirect('credits/index'); 

         }

         if(empty($selected_country)){ $Two_arry_merge=$remain_country;}
         elseif(empty($remain_country)){ $Two_arry_merge=$selected_country;}
         else{ 
               if(!empty($selected_country) && !empty($remain_country)){
                 $Two_arry_merge=array_merge($selected_country,$remain_country);
               }
             }
         
          $id=$this->input->post('hidenid'); 
          //$county_id=implode(",",$this->input->post('countryids'));
          $county_id=implode(",",$Two_arry_merge);
          $credits=$this->input->post('credits');
          $status=($this->input->post('txtStatus')=='on')?'1':'0';
          
          $postdata = array(
                          'county_id' => $county_id,
                          'credits' => $credits,
                          'status' => $status,
                          'created'=>date("Y-m-d H:i:s")
                          );

          $update=$this->credits_model->update_credits($id,$postdata);
          if($update){
           $this->session->set_flashdata('credit_edit', 'Credits Update Successfully');
           redirect('credits/index');
          }else{
            $this->session->set_flashdata('credit_edit', 'Credits Not Updated.');
            redirect('credits/edit');
          }
 
        }

        $ALL_Country_list = $this->country_model->getAllCountry();

        $getCreditById = $this->credits_model->getcredits_BYID($id);

        $newArray2=array();
        foreach ($ALL_Country_list as $key => $value) {
             array_push($newArray2,$value->id);
             
        }
        
        $abc=array();
        for($i=0;$i<count($newArray2);$i++){

            $match = $this->credits_model->rowByCid($newArray2[$i]);
            // echo "<pre>";print_r($match); echo count($match); exit();
            if(count($match)==0){
                array_push($abc,$newArray2[$i]);
            }

        }
        $remain_Cdata=""; 
        if(!empty($abc)){
          for($i=0;$i<count($abc);$i++){
            $remain_Cdata[] = $this->country_model->remain_Cdata($abc[$i]);
          }
        }  
     
        //echo "<pre>"; print_r($remain_Cdata); exit();
        
        
        $data["ALL_Country_list"] = $ALL_Country_list;
        $data["getCreditById"] = $getCreditById;
        $data["remain_country"] = $remain_Cdata;
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('credits/edit', $data);
        $this->load->view('layout/footer', $data);

   
    }


    public function view(){
 
        if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
        $id=$this->uri->segment(3); 
        
        $keys=array();
        $values=array();
        $ALL_Country_list = $this->country_model->getAllCountry();
        $a=array_keys($ALL_Country_list);
        // echo "<pre>";print_r($a); exit();
        
        foreach ($ALL_Country_list as $key => $value) {
             array_push($keys,$value->id);
             array_push($values,$value->county_name);
        }
        $country=array_combine($keys, $values);

        $getCreditById = $this->credits_model->getcredits_BYID($id);
        
        $data["country"] = $country;
        $data["getCreditById"] = $getCreditById;
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('credits/view', $data);
        $this->load->view('layout/footer', $data);

   
    }

 
    public function check_for_assign(){
     
         $countryid=$this->input->post('counter_id'); 
 
         //echo "<pre>"; print_r($countryid); echo $countryid[0]; exit();
         for($i=0;$i<count($countryid);$i++){

            $credit=$this->credits_model->xyz1($countryid[$i]);
            if($credit)
            {
              $cids[]=$countryid[$i];
              
            }else{
              $cidss[]=array();

            }
           
         }
          
         if(!isset($cids)){
            $cids="";
            $status=array("code"=>400,"is_present"=>"nopresent","data"=>$cids);
           
         }
         else{
            $status=array("code"=>200,"is_present"=>"present","data"=>$cids);
         }
         echo json_encode($status); exit();
         
         exit();
         /*    
         $last_selected_Cid=end($countryid);
         
         $getCreditById = $this->credits_model->getCredits($last_selected_Cid);
       
         if(count($getCreditById)>0){
           echo "present";
         }else{

          echo "nopresent";
         }
         exit();
         */
    }

    public function unassign_countrylist()
    {
     
         // $countryid=$this->input->post('counter_id');   
         // $last_selected_Cid=end($countryid);
         
         // $get = $this->credits_model->unassign_country();
         
         // $newArry=array();
         // foreach ($get as $key => $value) {
         //   array_push($newArry,$value->county_id);
         // }
        
        $ALL_Country_list = $this->country_model->getAllCountry();

        $newArray2=array();
        foreach ($ALL_Country_list as $key => $value) {
             array_push($newArray2,$value->id);
             
        }
        
        $abc=array();
        for($i=0;$i<count($newArray2);$i++){

            $match = $this->credits_model->xyz($newArray2[$i]);
            // echo "<pre>";print_r($match); echo count($match); exit();
            if(count($match)==0){
                array_push($abc,$newArray2[$i]);
            }

        }
        echo "<pre>fg";print_r($abc); 
       

        exit();
    }




    
    /* #################  API FOR LIST COUNTY  ################################# */

     /*
       URL:192.168.0.151/speedyfax_h/country/getAllCountry_list

     */
      public function getAllCountry_list()
      {
         //echo base_url(); exit();http://localhost/speedyfax_h/assests/images/country/img.jpg
         
          $ALL_Country_list = $this->country_model->getAllCountry();
         
          if($ALL_Country_list){

            $status=array("list"=>$ALL_Country_list,"status"=>1,"code"=>200);
          }else
          {
            $status=array("status"=>0,"code"=>400,"msg"=>"Error");  
          }
          echo json_encode($status); exit();
      }

      


     
} // end of class



