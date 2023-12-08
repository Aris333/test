<?php
/*
 * This is used to manage Promocode  
 *  */

class Country extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');
    
        $this->load->model("country_model");
        $this->load->model("credits_model");

        $this->load->library('session');
        $this->load->helper('date');
    }
    
    // public function index(){
        
    // }
    
    /* #################  API FOR LIST COUNTY  ################################# */

     /*
       URL:192.168.0.151/speedyfax_h/country/getAllCountry_list
       image_link: http://localhost/speedyfax_h/assests/images/country/img.png
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

  
      /*
         URL:192.168.0.151/speedyfax_h/country/get_credits_perpage
         Req:county_code=+91
         Response:{"credits_per_page":"15","status":1,"code":200}

      */

      public function get_credits_perpage()
      {
          $county_code = !empty($this->input->post("county_code"))?$this->input->post("county_code"):'';
          if($county_code==''){
             
             $status=array("status"=>0,"code"=>400,"msg"=>"provide req parameter & not it empty");
             echo json_encode($status); exit();
          } 

          $get_Country_bycode = $this->country_model->getCountryByCode($county_code);
         

          if(count($get_Country_bycode)>0)
          {
              $id=$get_Country_bycode[0]->id;
             
              $getCreditsperpage = $this->credits_model->getCredits($id);

              $credits_per_page=$getCreditsperpage[0]->credits; 
             
              if($getCreditsperpage){

                $status=array("credits_per_page"=>$credits_per_page,"status"=>1,"code"=>200);
              }else
              {
                $status=array("status"=>0,"code"=>400,"msg"=>"Error");  
              }
           }
           else{
               
               $status=array("status"=>0,"code"=>400,"msg"=>"Country not found");
           }  

          echo json_encode($status); exit();
      }

    public function base64_encode_image ($filename=string,$filetype=string) {
          if ($filename) {
              if(file_exists($filename)){
              $imgbinary = fread(fopen($filename, "r"), filesize($filename));
              //return 'data:image/' . $filetype . ';base64,' . base64_encode($imgbinary);
              return base64_encode($imgbinary);
            }else{
              return '';
            }
          }
      }

      public function  getCountry_with_credits()
      {
     
         $getCountry_and_credit = $this->country_model->getCountry_and_credits();
         
         $newArry=array();
         foreach ($getCountry_and_credit['data'] as $key => $value) {
        
                 $newArry[$key]['id']=$value->id; 
                 $newArry[$key]['county_name']=$value->county_name;
                 $newArry[$key]['county_code']=$value->county_code;
                 $path=$this->config->item('upload_path')."country/".$value->flage_image;
                 $newArry[$key]['flage_image'] =$this->base64_encode_image ($path,'png');
                 //$newArry[$key]['flage_image']=base64_encode($path);
                 $newArry[$key]['credits']=$value->credits;         

         }
        

         if(!empty($getCountry_and_credit['data'])){

              $status=array("status"=>1,"code"=>200,"msg"=>"Data found","data"=>$newArry);
           
         }else{

              $status=array("status"=>0,"code"=>400,"msg"=>"Data not found");
         }
        echo json_encode($status); exit();
      }


     
} // end of class



