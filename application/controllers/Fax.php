<?php
/*
 * This is used to manage Promocode  
 *  */

class Fax extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->model('user_model');
        $this->load->model("fax_model");
        $this->load->helper( "my_custom_helper" );
        $this->load->library('session');
        $this->load->helper('date');
    }

    // public function index(){

    // }
    
    public function fax_shorting()
    {
        if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
        $shorting_by=$this->uri->segment(3);
        $data["shorting_by"] = $shorting_by;
        // $data["title"] = "Feeds";
        $data["allfax"] = $this->fax_model->getAllfax($shorting_by);

        $data['from_date'] = '';
        $data['to_date'] = '';
        $data['month_name'] = '01';
        $data['month_year'] = date('Y');
        $data['year'] = date('Y');
        $data["filter_by"] = 0;
        //$data["allUsers"] = $this->user_model->getAllUser();
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('fax/index', $data);
        $this->load->view('layout/footer', $data);
    }


    public function filterby()
    {
        if(!$this->session->has_userdata('txtEmail')){ redirect("user/login");}
        $shorting_by=$this->uri->segment(3);

        $data["shorting_by"] = $shorting_by;
        $data["filter_by"] = $this->input->post('filter_by');
        if($data["filter_by"] == 1)
        {
            $data['from_date'] = $this->input->post('from_date');
            $data['to_date'] = $this->input->post('to_date');
            $data['month_name'] = '01';
            $data['month_year'] = date('Y');
            $data['year'] = date('Y');
        }
        else if($data["filter_by"] == 2)
        {
            $data['month_name'] = $this->input->post('month_name');
            $data['month_year'] = $this->input->post('month_year');
            $data['year'] = date('Y');
            $data['from_date'] = '';
            $data['to_date'] = '';
        }
        else if($data["filter_by"] == 3)
        {
            $data['year'] = $this->input->post('year');
            $data['month_name'] = '01';
            $data['month_year'] = date('Y');
            $data['from_date'] = '';
            $data['to_date'] = '';
        }
        else
        {
            $data['year'] = date('Y');
            $data['month_name'] = '01';
            $data['month_year'] = date('Y');
            $data['from_date'] = '';
            $data['to_date'] = '';
        }

        $data["allfax"] = $this->fax_model->getfaxFilter($this->input->post());

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('fax/index', $data);
        $this->load->view('layout/footer', $data);

    }
    /* use for download link on view page */
    public function fax_download()
    {
        $OrderNo = $_REQUEST['orderno'];
        // $login = "889a71a51359a59f5bed1c6727386f487f76090c";
        // $password = "63d381d917bb2b9b134a030fcb5454bdab9cbnof50";
        //63d381d917bb2b9b134a030fcb5454bdab9cbf50

        $login = "lliivslpw8s6ttxjsjpbghtevgk0bvx7zstkbf91";
        $password = "ambyairbkzzf8quv4em31nmfddsn96r52j6zsqic";
        
        $url = "https://api.phaxio.com/v2/faxes/" . $OrderNo . "/file?api_key=$login&api_secret=$password";
        header("Location: $url");
        exit;
    }

    public function pamfax_download()
    {
        $uuid = $_REQUEST['orderno'];
        $this->load->library('pam/pam'); // load lib
        $response=$this->pam->get_pdf_report($uuid);

        exit;
    }


    function testImage($images,$id){
        // Assuming you received the comma-separated base64 images via POST request as 'imageData'

// Create an array to store uploaded image names
$uploadedImages = [];
$this->db->where('fax_id',$id)->delete('tblFaxImages');
// Process each image
foreach ($images as $imageData) {
    // Remove the 'data:image/png;base64,' or similar part from the data
    list($type, $imageData) = explode(';', $imageData);
    list(, $imageData)      = explode(',', $imageData);

    // Extract the file extension from the 'data:' part
    $extension = strtolower(preg_replace('/^data:image\/(.*);base64/', '$1', $type));
    $extension = explode('/',$extension)[1];
   
    // Decode the base64 data
    $decodedImage = base64_decode($imageData);

    // Set a unique name and path for the uploaded image
    $imageName = uniqid() . '.' . $extension;
    $uploadPath = 'assests/uploads/' . $imageName;

    // Save the decoded image to the server
    if (file_put_contents($uploadPath, $decodedImage)) {
        $uploadedImages[] = $imageName;        
       $this->db->insert('tblFaxImages',['fax_id' => $id,'image_name' => $imageName]);
    } else {
        // echo "Error uploading image: " . $imageName;
    }
}
return true;
    }

    /* ------------------- API --------------------------------- */
    public function addfaxdata()
    {
        try{  
            log_message('error', 'add_fax_data.gchgvjhvjhvj');


        $images = isset($_POST['images']) ? $_POST['images'] : '';
        if(isset($images) && $images != ''){
        $images = explode('<<------>>',$images);
        }else{
            $images = [];
        }
        // print_r($images);die;
        
        //   log_message('error', 'addfaxdata->Start');

        //     log_message('error', 'postdata.'.json_encode($images));
        //     log_message('error', 'addfaxdata->End');
        if(!empty($this->input->post('fax')))
        {
            
           
           
           log_message('error', 'Faxio api response postdata.'.json_encode($_POST));

           $this->db->insert('jsondata',['data'=> json_encode($_REQUEST)]);
           // table me jana ab db kaise access kru pahle vo batao
           
           // public me kr do
            
            $json = $this->input->post('fax');
            $txtUID = $this->input->post('txtUID');
            $mobile = $this->input->post('mobile');
            // $json='{"id": 123456, "direction": "sent", "num_pages": 3, "status": "failure", "is_test":true, "created_at": "2015-09-02T11:28:02.000-05:00", "caller_id":"+18476661235", "from_number": null, "completed_at": "2015-09-02T11:28:54.000-05:00", "caller_name": "Catherine Lee", "cost": 21, "tags":{ "order_id": "1234" }, "recipients":[{"phone_number":"+14141234567", "status":"failure", "retry_count":0, "completed_at":"2015-09-02T11:28:54.000-05:00", "bitrate":14400, "resolution":8040, "error_type":null, "error_id":null, "error_message":null } ], "to_number": null, "error_id": null, "error_type": null, "error_message": null,"barcodes": []}';
            $newArray=array();
            $newArray=json_decode($json,true);
            $txtOrderNo=$newArray['id'];
            $txtNoOfPage=$newArray['num_pages'];
            $txtCost=$newArray['cost'];
            $direction=$newArray['direction'];
            $txtStatus=$newArray['status'];
            $is_test=$newArray['is_test'];

            $date1 = new DateTime();
            $date1->setTimestamp($newArray['requested_at']);
            // $date1 = DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $newArray['created_at']);
            $txtRequestedAt=$date1->format('y/m/d H:i:s');
            
            $date2 = new DateTime();
            $date2->setTimestamp($newArray['completed_at']);
            // $date2 = DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $newArray['completed_at']);
            $txtCompletedAt=$date2->format('y/m/d H:i:s');
            
            

            $date3 = new DateTime();
            $date3->setTimestamp($newArray['requested_at']);
            // $date3 = DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $newArray['created_at']);
            $txtRequestedAt1=$date3->format('m/d/y H:i:s');
            
            $date4 = new DateTime();
            $date4->setTimestamp($newArray['completed_at']);
            // $date4 = DateTime::createFromFormat('Y-m-d\TH:i:s.uP', $newArray['completed_at']);
            $txtCompletedAt1=$date4->format('m/d/y H:i:s');

            $datetime1 = new DateTime($txtRequestedAt1);
            $datetime2 = new DateTime($txtCompletedAt1);
            $interval = $datetime1->diff($datetime2);
            $txtTotalDuration=$interval->format(" %i minutes %s seconds");

            $reception_number=!empty($newArray['recipients'][0]['phone_number']) ? $newArray['recipients'][0]['phone_number'] : '';
            $status=!empty($newArray['recipients'][0]['status']) ? $newArray['recipients'][0]['status'] : '';
            $retry_count=!empty($newArray['recipients'][0]['retry_count'])? $newArray['recipients'][0]['retry_count']:'';
            $error_code=!empty($newArray['recipients'][0]['error_id'])? $newArray['recipients'][0]['error_id']:'';
            $error_type=!empty($newArray['recipients'][0]['error_type'])?$newArray['recipients'][0]['error_type']:'';
            $error_msg=!empty($newArray['recipients'][0]['error_code'])?$newArray['recipients'][0]['error_code']:'';
            $bitrate=!empty($newArray['recipients'][0]['bitrate'])?$newArray['recipients'][0]['bitrate']:'';
            $resolution=!empty($newArray['recipients'][0]['resolution'])?$newArray['recipients'][0]['resolution']:'';

            $check=$this->fax_model->checkdata($txtOrderNo);

            if($check && sizeof($check) > 0)
            {
                $data = array(
                    'txtUID' => $txtUID != '' ? $txtUID : $check[0]->txtUID,
                    'txtDeviceId' => $check[0]->txtDeviceId,
                    'tokenid' => $check[0]->tokenid,
                    'req_from' => $check[0]->req_from,
                    'txtcredits_per_page' => $check[0]->txtcredits_per_page,
                    'txtNoOfPage' => $txtNoOfPage,
                    // 'txtCost' => $txtCost,
                    'txtStatus' => $txtStatus,
                    'txtRequestedAt' => $txtRequestedAt,
                    'txtCompletedAt' => $txtCompletedAt,
                    'txtTotalDuration' =>$txtTotalDuration,
                    'r_number'=>$reception_number,
                    'r_status'=>$status,
                    'r_retry_count'=>$retry_count,
                    'r_error_code'=>$error_code,
                    'r_error_type'=>$error_type,
                    'r_error_msg'=>$error_msg,
                    'r_bitrate'=>$bitrate,
                    'r_resolution'=>$resolution,
                    //'mobile'=>$mobile,
                    'created'=>date("Y-m-d H:i:s"),
                );
                $update=$this->fax_model->update_fax_to_new_data($txtOrderNo,$data);
                if(!empty($images)){
                    $this->db->where('txtOrderNo',$txtOrderNo);
                    $query=$this->db->get('tblFax')->row();
                    //self::testImage($images,$query->txtFaxID);
                }
                // UPLOAD FAX IMAGES

                $tokenid = $check[0]->tokenid;
                $req_from = $check[0]->req_from;

                if($update)
                {
                    if($status=="failure")
                    { 
                        $Message="Fax ".$txtOrderNo." is Failed.Reason for failed:".$error_code.".";
                        /*$mobileno=$this->fax_model->getMobileNumber();
                        //$admin_mobile_num=$mobileno[0]->txtvalue;
                        $admin_mobile_num=array_filter([$mobileno[0]->txtvalue,$mobileno[0]->txtvalue2]); 
                        configTwilio($admin_mobile_num,$Message ); // call to helper function*/
                        $mobileno=$this->fax_model->getMobileNumber();
                        $admin_mobile_num=array_filter([$mobileno[0]->txtvalue,$mobileno[1]->txtvalue]);
                        configTwilio($admin_mobile_num,$Message ); // call to helper function

                        /// Send Push Notification

                        /*push notification Integrate */
                        if($req_from=="android"){
                            $this->send_android_notification($tokenid,$Message); //send android notification
                        }else{
                            $this->send_ios_notification($tokenid,$Message); //send iphone notification
                        }
                    } else {
                        $Message="Your Fax ".$txtOrderNo." was delivered successfully to ".$reception_number.".";
                        /*push notification Integrate */
                        if($req_from=="android"){
                            $this->send_android_notification($tokenid,$Message); //send android notification
                        }else{
                            $this->send_ios_notification($tokenid,$Message); //send iphone notification
                        }
                    }
                    $status = array("code"  =>200,"msg"   =>"fax data updated successfull","status" =>1);
                }
            }
            else
            {
                $postdata = array(
                    'txtUID' => $txtUID ,
                    'txtOrderNo' => $txtOrderNo,
                    'txtNoOfPage' => $txtNoOfPage,
                    // 'txtCost' => $txtCost,
                    'txtStatus' => $txtStatus,
                    'txtRequestedAt' => $txtRequestedAt,
                    'txtCompletedAt' => $txtCompletedAt,
                    'txtTotalDuration' =>$txtTotalDuration,
                    'r_number'=>$reception_number,
                    'r_status'=>$status,
                    'r_retry_count'=>$retry_count,
                    'r_error_code'=>$error_code,
                    'r_error_type'=>$error_type,
                    'r_bitrate'=>$bitrate,
                    'r_resolution'=>$resolution,
                    // 'mobile'=>$mobile,
                    'created'=>date("Y-m-d H:i:s")
                );
                $insert=$this->fax_model->add_fax_data($postdata);
                if($insert)
                {
                    if(!empty($images)){                        
                        // self::testImage($images,$insert);
                    }
                    if($status=="failure")
                    {  $Message="Fax".$txtOrderNo." is Failed.Reason for failed:".$error_code.".";
                        $mobileno=$this->fax_model->getMobileNumber();

                        //$admin_mobile_num=$mobileno[0]->txtvalue;
                        $admin_mobile_num=array_filter([$mobileno[0]->txtvalue,$mobileno[0]->txtvalue]);
                        configTwilio($admin_mobile_num,$Message ); // call to helper function
                    }
                    $status = array("code"  =>200,"msg"   =>"fax data added successfull","status" =>1);
                }
            }
        }
        /*andy*/else
        
        {   $txtCoverPage = $this->input->post("txtCoverPage");
            $txtUID = $this->input->post("txtUID");
            $txtDeviceId = $this->input->post("txtDeviceId");
            $txtOrderNo = $this->input->post("txtOrderNo");
            $txtNoOfPage = $this->input->post("txtNoOfPage");
            $txtCost = $this->input->post("txtCost");
            $txtStatus = $this->input->post("txtStatus");
            $txtRequestedAt = $this->input->post("txtRequestedAt");
            $txtCompletedAt = $this->input->post("txtCompletedAt");
            $txtTotalDuration = $this->input->post("txtTotalDuration");
            $mobile = $this->input->post('mobile');
            

            if($txtOrderNo=='' ||  $txtStatus=='')
            {
                $status = array("code"  =>400,"msg"   =>"please provided required fileds","status" =>0);
                //echo json_encode($status);
            }
            else
            {
                $check=$this->fax_model->checkdata($txtOrderNo);
                if($check && sizeof($check) > 0)
                {
                    $data = array(
                        'txtUID' => $txtUID,
                        'txtDeviceId' => $txtDeviceId,
                        'txtCoverPage' => $txtCoverPage,
                        'mobile'=>$mobile,
                    );
                    
                    $update=$this->fax_model->update_fax_to_new_data($txtOrderNo,$data);
                    if($update){
                        $this->db->where('txtOrderNo',$txtOrderNo);
                    $query=$this->db->get('tblFax')->row();
                    // Commented by D and need to uncomment after live ********************************
                     if(isset($images) && !empty($images) && count($images) > 0){
                    self::testImage($images,$query->txtFaxID);
                     }
                        $status = array("code"  =>200,"msg"   =>"Fax data Updated successfull","status" =>1);
                    }else{
                        $status = array("code"  =>400,"msg"   =>"Fax data not Updated","status" =>0);
                    }
                }
                else
                {
                    $postdata = array(
                        'txtOrderNo' => $txtOrderNo,
                        'txtUID'=>$txtUID,
                        'txtDeviceId'=>$txtDeviceId,
                        'txtNoOfPage' => $txtNoOfPage,
                        'txtCost' => $txtCost,
                        'txtStatus' => $txtStatus,
                        'txtRequestedAt' => $txtRequestedAt,
                        'txtCompletedAt' => $txtCompletedAt,
                        'txtTotalDuration' =>$txtTotalDuration,
                        'txtCoverPage' => $txtCoverPage,
                        'mobile'=>$mobile,
                    );

                    $insert=$this->fax_model->add_fax_data($postdata);
                    if($insert){
                        if(!empty($images)){   
                    // Commented by D and need to uncomment after live ********************************
                            // if(isset($images) && !empty($images))
                            // self::testImage($images,$insert);
                            if(isset($images) && !empty($images) && count($images) > 0){
                                
                                 log_message('error', 'Image_error___________');

            log_message('error', 'postdata.'.json_encode($images));
            log_message('error', 'End________________--');
            
                    self::testImage($images,$insert);
                     }
                        }
                        $status = array("code"  =>200,"msg" =>"Fax data added successfull","status" =>1);
                    }else{
                        $status = array("code"  =>400,"msg" =>"Fax data not added","status" =>0);
                    }
                }
            }
        }//
        echo json_encode($status);
        
        }catch(\Throwable $e){
        
                log_message('error', 'add_fax_data.'.$e->getMessage(). ' On Line '. $e->getLine());

    }
    
    }//end of function


    public function getfaxdata()
    {
        $txtUID = $this->input->post("txtUID");
        $txtDeviceId = $this->input->post("txtDeviceId");
        $txtOrderNo = $this->input->post("txtOrderNo");

        if($txtOrderNo=='')
        {
            $status = array("code"=>400,"msg"=>"please provided required fileds","status"=>0);
        }
        else
        {
            $getfaxdata=$this->fax_model->getFaxdata($txtUID,$txtDeviceId,$txtOrderNo);
            if($getfaxdata)
            {
                $base_url = base_url('assests/uploads/');                
                foreach($getfaxdata as $val){                
                $val->images = $this->db
                ->select('CONCAT("' . $base_url . '", image_name) as image_name')
                ->where('fax_id',$val->txtFaxID)->get('tblFaxImages')->result();
                }

                $status = array("code"=>200,"msg"=>"Data are Found","status"=>1,"Data"=>$getfaxdata);
            }
            else{

                $status = array("code"=>400,"msg"=>"Data are not Found","status" =>0,"Data"=>$getfaxdata);
            }
        }
        echo json_encode($status);
    }



    public function getfaxalldata()
    {
        $txtUID = $this->input->post("txtUID");
        $txtDeviceId = $this->input->post("txtDeviceId");
        

        if(false)
        {
            $status = array("code"=>400,"msg"=>"please provided required fileds","status"=>0);
        }
        else
        {
            $getfaxdata=$this->fax_model->getfaxalldata($txtUID,$txtDeviceId);
            if($getfaxdata)
            {
                $base_url = base_url('assests/uploads/');                
                foreach($getfaxdata as $val){                
                $val->images = $this->db
                ->select('CONCAT("' . $base_url . '", image_name) as image_name')
                ->where('fax_id',$val->txtFaxID)->get('tblFaxImages')->result();
                }

                $status = array("code"=>200,"msg"=>"Data are Found","status"=>1,"Data"=>$getfaxdata);
            }
            else{

                $status = array("code"=>400,"msg"=>"Data are not Found","status" =>0,"Data"=>$getfaxdata);
            }
        }
        echo json_encode($status);
    }




    /* ------------------- API --------------------------------- */



    /* ************************ PAMFAX ****************

   URL: 192.168.0.151/speedyfax_latest/fax/pamfax_api
   Req:
       txtDeviceId
       fileToUpload[]
       r_number
       txtcredits_per_page
   Response:


 */

    public function pamfax_api()
    {
        set_time_limit(0);
        ini_set('max_execution_time', 600); //300 seconds = 5 minutes
        ini_set('post_max_size', '128M');
        ini_set('upload_max_filesize', '128M');

        $txtDeviceId = $this->input->post("txtDeviceId");
        $r_number = $this->input->post("r_number");
        $txtcredits_per_page = $this->input->post("txtcredits_per_page");
        $txtCoverPage=1;  //$this->input->post("txtCoverPage");
        $tokenid = $this->input->post("tokenid");
        $req_from = $this->input->post("req_from");


        log_message('error', 'postdata.'.json_encode($_POST));

        log_message('error', 'filedata.'.json_encode($_FILES));



        if($txtDeviceId=='' || $r_number=='' || empty($_POST) || empty($_FILES) || $tokenid=='' || $req_from=='')
        {
            log_message('error', 'required fields deviced id & fax number.'.$txtDeviceId);
            $status = array("code"=>400,"msg"=>"please provide required fileds","status"=>0);
            echo json_encode($status); exit();
        }

        if(empty($_FILES["fileToUpload"]))
        {
            log_message('error', 'file not get.'.$_FILES["fileToUpload"]);
            $status = array("code"=>400,"msg"=>"Please provide decument for send fax!","status"=>0);
            echo json_encode($status); exit();
        }

        for($i=0;$i<count($_FILES["fileToUpload"]["name"]);$i++)
        {

            $target_dir = "assests/images/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
            $uploadOk = 0;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file))
            {
                log_message('error', 'moove files done.');
                $uploadOk = 1;
                $filepath[] = "@" .$this->config->item('upload_path').$_FILES["fileToUpload"]["name"][$i];
                //echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";

            } else {
                log_message('error', 'error for upload file.');
                $uploadOk = 0;
                echo "Sorry, there was an error uploading your file."; exit();
            }
        }


        if($uploadOk == 1)
        {

            //$filepath = $this->config->item('upload_path').$_FILES["fileToUpload"]["name"];


            $this->load->library('pam/pam'); // load lib
            $response=$this->pam->sendFax($filepath,$txtDeviceId,$r_number);
            log_message('error', 'response of send fax.'.json_encode($response));
            //echo "<pre>sendfax response:-"; print_r($response);
            if(isset($response['state']) && $response['state'] =="Error preparing the fax")
            {
                log_message('error', 'Error preparing the fax.'.$response['state']);
                $Message="Fax is Failed.Reason for failed:".$response['state'].".";
                $mobileno=$this->fax_model->getMobileNumber();
                //$admin_mobile_num=$mobileno[0]->txtvalue;
                $admin_mobile_num=array_filter([$mobileno[0]->txtvalue,$mobileno[1]->txtvalue]);
                configTwilio($admin_mobile_num,$Message ); // call to helper function
                $status = array("code"  =>400,"msg" =>"Error on preparing the fax, Please try again!","status" =>0);
                echo json_encode($status); exit();
            }

            if(isset($response['send_response']['result']['code']) && $response['send_response']['result']['code'] =="failure")
            {
                log_message('error', 'failure if o/p of sendfax.'.$response['send_response']['result']['code']);
                /* twilio */
                // $Message="Fax".$response['txtOrderNo']." is Failed.Reason for failed:".$response['send_response']['result']['code'].".";
                // $mobileno=$this->fax_model->getMobileNumber();
                // $admin_mobile_num=array_filter([$mobileno[0]->txtvalue,$mobileno[1]->txtvalue]);
                // configTwilio($admin_mobile_num,$Message ); // call to helper function
                /* -- */
                $status = array("code"  =>400,"msg" =>"Error preparing the fax","status" =>0);
                echo json_encode($status); exit();
            }



            if(isset($response['send_response']['result']['code']) && $response['send_response']['result']['code']=="success")
            {
                log_message('error', 'on sent success.'.$response['send_response']['result']['code']);
                $postdata = array(
                    'txtOrderNo' => $response['txtOrderNo'],
                    'txtDeviceId'=>$txtDeviceId,
                    'txtNoOfPage' => $response['txtNoOfPage'],
                    'txtCost' => $response['txtCost'],
                    'txtStatus' => 'ready to send', //$response['txtStatus'],
                    'txtRequestedAt' => $response['txtRequestedAt'],
                    'txtCompletedAt' => $response['txtCompletedAt'],
                    'txtTotalDuration' =>$response['txtTotalDuration'],
                    'txtCoverPage' => $txtCoverPage,
                    'r_error_code'=>$response['send_response']['result']['message'],
                    'r_number'=>$r_number,
                    'txtcredits_per_page'=>$txtcredits_per_page,
                    'tokenid'=>$tokenid,
                    'req_from'=>$req_from
                );

                $insert=$this->fax_model->add_fax_data($postdata);
                if($insert){
                    log_message('error', 'insert in to DB success.'.$insert);
                    $getfaxdata=$this->fax_model->getFaxdata($txtDeviceId,$response['txtOrderNo']);
                    $status = array("code"  =>200,"msg" =>"Fax data added successfull","status" =>1,'data'=>$getfaxdata);
                }else{
                    log_message('error', 'insert in to DB failed.'.$insert);
                    $status = array("code"  =>400,"msg" =>"Fax sent success but Fax data not added","status" =>0);
                }

            } else{
                log_message('error', 'fax not send.'.$response['send_response']['result']['message']);
                $status = array("code"=>400,"msg"=>"Fax not send","status" =>0,'Error'=>$response['send_response']['result']['message']);
            }

        }else
        {   log_message('error', 'File not uploded.');
            $status = array("code" =>400,"msg"=>"File not uploded","status" =>0);

        }

        echo json_encode($status);
    }

    /* ************************ PHAXIO ****************

   URL: 192.168.0.151/speedyfax_latest/fax/phaxioax_api_android
   Req:
       txtDeviceId
       fileToUpload[]
       r_number
       txtcredits_per_page
   Response:


 */

    public function phaxiofax_api_android()
    {
        set_time_limit(0);
        ini_set('max_execution_time', 600); //300 seconds = 5 minutes
        ini_set('post_max_size', '128M');
        ini_set('upload_max_filesize', '128M');

        $txtDeviceId = $this->input->post("txtDeviceId");
        $r_number = $this->input->post("r_number");
        $txtcredits_per_page = $this->input->post("txtcredits_per_page");
        $txtCoverPage=1;  //$this->input->post("txtCoverPage");
        $tokenid = $this->input->post("tokenid");
        $req_from = $this->input->post("req_from");


        log_message('error', 'postdata.'.json_encode($_POST));

        log_message('error', 'filedata.'.json_encode($_FILES));


        if($txtDeviceId=='' || $r_number=='' || empty($_POST) || empty($_FILES) || $tokenid=='' || $req_from=='')
        {
            log_message('error', 'required fields deviced id & fax number.'.$txtDeviceId);
            $status = array("code"=>400,"msg"=>"please provide required fileds","status"=>0);
            echo json_encode($status); exit();
        }

        if(empty($_FILES["fileToUpload"]))
        {
            log_message('error', 'file not get.'.$_FILES["fileToUpload"]);
            $status = array("code"=>400,"msg"=>"Please provide decument for send fax!","status"=>0);
            echo json_encode($status); exit();
        }

        for($i=0;$i<count($_FILES["fileToUpload"]["name"]);$i++)
        {

            $target_dir = "assests/images/";
            $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"][$i]);
            $uploadOk = 0;
            $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);


            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"][$i], $target_file))
            {
                log_message('error', 'moove files done.');
                $uploadOk = 1;
                $filepath[] = $this->config->item('upload_path').$_FILES["fileToUpload"]["name"][$i];
                //echo "The file ". basename( $_FILES["fileToUpload"]["name"][$i]). " has been uploaded.";

            } else {
                log_message('error', 'error for upload file.');
                $uploadOk = 0;
                echo "Sorry, there was an error uploading your file."; exit();
            }
        }


        if($uploadOk == 1)
        {
            $this->load->library('phaxio/phaxio');
            $response = $this->phaxio->sendFax($r_number, $filepath);
            log_message('error', 'response of fax.'.json_encode($response));
            //echo "<pre>sendfax response:-"; print_r($response);
            if (!$response->succeeded()) {
                log_message('error', 'Error preparing the fax.' . json_encode($response->getMessage()));

                $Message = "Fax is Failed.Reason for failed:" . $response->getMessage() . ".";
                $mobileno = $this->fax_model->getMobileNumber();
                //$admin_mobile_num=$mobileno[0]->txtvalue;
                $admin_mobile_num = array_filter([$mobileno[0]->txtvalue, $mobileno[1]->txtvalue]);
                configTwilio($admin_mobile_num, $Message); // call to helper function
                $status = array("code" => 400, "msg" => "Error on preparing the fax, Please try again!", "status" => 0);
                echo json_encode($status);
                exit();
            } else {
                $responseData = $response->getData();
                $faxId = $responseData["faxId"];
                /// Successed
                log_message('error', 'success.'.json_encode($faxId));
                $postdata = array(
                    'txtOrderNo' => $faxId,
                    'txtDeviceId'=>$txtDeviceId,
                    'txtStatus' =>'ready to send',
                    'txtCoverPage' => $txtCoverPage,
                    'r_error_code'=>$response->getMessage(),
                    'r_number'=>$r_number,
                    'txtcredits_per_page'=>$txtcredits_per_page,
                    'tokenid'=>$tokenid,
                    'req_from'=>$req_from
                );

                $insert=$this->fax_model->add_fax_data($postdata);
            }

            $data["txtOrderNo"] = $response->getData()["faxId"];
            $status = array("code"=>200,"msg"=>"Fax sent","status" =>1, "data" => $data);
        } else {
            log_message('error', 'File name not get so last else condition.');
            $status = array("code" =>400,"msg"=>"File name not get","status" =>0);

        }

        echo json_encode($status);
    }

    /*
        URL: 192.168.0.151/speedyfax_latest/fax/getfaxdetails
        Req:
          uuid
          txtDeviceId
          req_from
          token_id
          
      Response:
    */

    function getfaxdetails_HA()
    {

        //$uuid ="lmXqROUoDGLRcA";//819aoS4B9NjgH6f5,Pu6HIQnERqgV7Z,lmXqROUoDGLRcA
        $uuid = $this->input->post("uuid");
        $txtDeviceId = $this->input->post("txtDeviceId");
        $req_from = $this->input->post("req_from");
        $TokenId = $this->input->post("token_id");

        $this->load->library('pam/pam'); // load lib


        $response=$this->pam->getfaxdetails($uuid);
        $json_decode=json_decode($response,true);


        //if in progress
        if (array_key_exists("FaxRecipient",$json_decode))
        {
            if(isset($json_decode['FaxRecipient']) && !empty($json_decode['FaxRecipient']))
            {
                $status = array("code" =>200,"status" =>1,"msg"=>"inprogress","info"=>"Fax ".$uuid."in progrss");

            }
        }

        //if sent or failure
        if (array_key_exists("FaxHistoryModel",$json_decode))
        {

            if(isset($json_decode['FaxHistoryModel']) && !empty($json_decode['FaxHistoryModel']))
            {

                $getfaxdata=$this->fax_model->getFaxdata($txtDeviceId,$uuid); //fetch from tbl
                // echo "<pre>"; print_r($getfaxdata); exit();
                $txtRequestedAt=$getfaxdata[0]->txtRequestedAt;
                $delivered_time=$json_decode['FaxHistoryModel']['sent'];
                $date1=date_create($txtRequestedAt);
                $date2=date_create($delivered_time);
                $diff=date_diff($date1,$date2);
                $txtTotalDuration=$diff->format("%h hours %i minutes %s seconds");

                $txtOrderNo=$uuid;
                $txtStatus=$json_decode['FaxHistoryModel']['state'];
                $r_error_code=$json_decode['FaxHistoryModel']['status_message'];
                $activity_date_display=date("Y-m-d H:i:s");
                $data = array(
                    'txtStatus' => $txtStatus,
                    'r_error_code' => $r_error_code,
                    'created'=>date("Y-m-d H:i:s"),
                    'tokenid'=>$TokenId,
                    'req_from'=>$req_from,
                    'txtCompletedAt'=>$delivered_time,
                    'txtTotalDuration'=>$txtTotalDuration
                );

                $update=$this->fax_model->update_fax_data($txtDeviceId,$txtOrderNo,$data); // update into tbl

                if($update=="yes")
                {
                    $getfaxdata=$this->fax_model->getFaxdata($txtDeviceId,$uuid); //fetch from tbl
                    $Message="";
                    if($txtStatus!='failure'){

                        $Message="Fax ".$txtOrderNo." is Sent Successfully";
                        $msg = "sent";

                    }else{

                        $Message="Fax ".$txtOrderNo." is Failed. Reason for failed: ".$r_error_code.".";
                        $mobile_num  = '+917023934474';
                        configTwilioUser( $mobile_num, $Message );
                        $msg = "failure";

                        /*Twilio Integrate */
                        $mobileno=$this->fax_model->getMobileNumber(); //get mobile no from tbl
                        $admin_mobile_num=array_filter([$mobileno[0]->txtvalue,$mobileno[0]->txtvalue]);
                        configTwilio($admin_mobile_num,$Message ); // call to helper function
                        /*Twilio Integrate */

                    }
                    $status = array("code" =>200,"status" =>1,"msg"=>$msg,"info"=>$Message,"activity_date_display"=>$activity_date_display,"data"=>$getfaxdata);

                    /*push notification Integrate */
                    if($req_from=="android"){
                        $this->send_android_notification($TokenId,$Message); //send android notification
                    }else{
                        $this->send_ios_notification($TokenId,$Message); //send iphone notification
                    }
                    /*push notification Integrate */
                }
                else{

                    $status = array("code" =>400,"status" =>0,"msg"=>"data not found","Reason"=>"uuid or deviced id not matched");
                }

            }
        }

        echo json_encode($status); exit();

    }


    public function send_android_notification($regId,$message)
    {

        require_once APPPATH.'third_party/notification/firebase.php';
        require_once APPPATH.'third_party/notification/push.php';

        $firebase = new Firebase();
        $push = new Push();

        $title ="SpeedyFax";
        $push_type="individual";

        $include_image ="";
        $payload='';

        $push->setTitle($title);
        $push->setMessage($message);
        $push->setImage($include_image);
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);
        $json = $push->getPush();

        $response = $firebase->send($regId, $json);
        // echo "<pre>"; print_r($response); exit();

    }

    /* call this function when u have required to test from postman or web */
    public function ios_notification()
    {

        //$deviceToken =$this->input->post('token_id');
        $deviceToken ='f68a17299effa4491ea7c07540a285c9092692af9c351f8828b4045f531afd05';
        //8b2e3980ef2cbd86996e55a5caf31c7312be22f9c0db44d924673ee495a78ade';
        // My message
        $message = 'My first push notification send to my frnd !';
        $result = $this->send_ios_notification($deviceToken,$message);
        // Debug your result
        var_dump($result);

    }
    
    /* call this function when you have required to test sms on postman or web */
    public function sms_test() {
        $mobileno=$this->fax_model->getMobileNumber();
        $admin_mobile_num=array_filter([$mobileno[0]->txtvalue,$mobileno[1]->txtvalue]);
        print_r($admin_mobile_num);
        die;
        configTwilio($phoneNumbers, 'testing');
    }

    public function send_ios_notification($deviceToken,$message)
    {
return true;
        $ctx = stream_context_create();
        //$filename = 'Ober_Customer_DEV_CK.pem';
        $passphrase = 'admin';

        $filename=APPPATH.'third_party/notification/ios/speedyfax_DEV_CK.pem'; //for Devlopment

        //$filename = 'HoponDriver_CK.pem';
        stream_context_set_option($ctx, 'ssl', 'local_cert', $filename);
        stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);

        // Open a connection to the APNS server
        $fp = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $err,$errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);

        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);

        //echo 'Connected to APNS' . PHP_EOL;

        // Create the payload body
        $body['aps'] = array(
            'alert' => $message,
            'sound' => 'notification.m4r'
        );

        // Encode the payload as JSON
        $payload = json_encode($body);

        // Build the binary notification
        $msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;

        // Send it to the server
        $result = fwrite($fp, $msg, strlen($msg));

        if (!$result)
            return 'Message not delivered' . PHP_EOL;
        else
            return 'Message successfully delivered'.PHP_EOL;

        // Close the connection to the server
        fclose($fp);

    }

    /* code for ios on 30th Nov 2017 */

    public function fileupload_ios(){
        log_message('error', 'filedata.'.json_encode($_FILES));
        if(empty($_FILES["fileToUpload"]))
        {
            $status = array("code"=>400,"msg"=>"Please provide decument for send fax!","status"=>0);
            echo json_encode($status); exit();
        }

        $target_dir = "assests/images/";
        $fileRename=time(). basename($_FILES["fileToUpload"]["name"]);
        log_message('error', 'filename.'.json_encode($fileRename));
        $target_file = $target_dir.$fileRename;
        $uploadOk = 0;
        $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
        {
            $uploadOk = 1;
            $filepath[] = "@" .$this->config->item('upload_path').$_FILES["fileToUpload"]["name"];
            log_message('error', 'filename.'.json_encode($filepath));
            $status = array("code"=>200,"msg"=>"file uploaded success","status"=>1,"file_name"=>$fileRename);

        } else {
            $uploadOk = 0;
            $status = array("code"=>400,"msg"=>"Sorry, there was an error uploading your file.","status"=>0);
        }
        
        file_put_contents(APPPATH.'controllers/test.txt', '\\n-----fileupload_ios()------\\n'.http_build_query($status).'\\n-----------\\n', FILE_APPEND);

        echo json_encode($status); exit();
    }

    public function phaxiofax_test() {
        $this->load->library('phaxio/phaxio');
    }

    public function phaxiofax_api_ios()
    {
        set_time_limit(0);
        ini_set('max_execution_time', 600); //300 seconds = 5 minutes
        ini_set('post_max_size', '128M');
        ini_set('upload_max_filesize', '128M');

        $tokenid = $this->input->post("tokenid");
        $txtDeviceId = $this->input->post("txtDeviceId");
        $r_number = $this->input->post("r_number");
        $txtcredits_per_page = $this->input->post("txtcredits_per_page");
        $txtCoverPage=1;  //$this->input->post("txtCoverPage");
        $files_names=$this->input->post("all_file_name");
        $req_from = $this->input->post("req_from");

        log_message('error', 'postdata.'.json_encode($_POST));

        if($txtDeviceId=='' || $r_number=='' || empty($files_names) || $tokenid =='' || $req_from=='')
        {
            $status = array("code"=>400,"msg"=>"please provided required fileds","status"=>0);
            echo json_encode($status); exit();
        }

        $filename_array=explode(",",$files_names);
        log_message('error', 'file name in array formate.'.json_encode($filename_array));
        if(count($filename_array)>0){
            for($i=0;$i<count($filename_array);$i++)
            {
                $uploadOk = 1;//flage
                $filepath[] = $this->config->item('upload_path') . $filename_array[$i];
//                $filepath[] = "@" .$this->config->item('upload_path').$filename_array[$i];
            }
        }else{
            $uploadOk == 0;//flage
        }

        log_message('error', 'file name in array formate.'.json_encode($filepath));
        if($uploadOk == 1)
        {
            $this->load->library('phaxio/phaxio');
            $response = $this->phaxio->sendFax($r_number, $filepath);
            log_message('error', 'response of fax.'.json_encode($response));
            // echo "<pre>sendfax response:-"; print_r($response);
            if (!$response->succeeded()) {
                log_message('error', 'Error preparing the fax.' . json_encode($response->getMessage()));

                $Message = "Fax is Failed.Reason for failed:" . $response->getMessage() . ".";
                $mobileno = $this->fax_model->getMobileNumber();
                //$admin_mobile_num=$mobileno[0]->txtvalue;
                $admin_mobile_num = array_filter([$mobileno[0]->txtvalue, $mobileno[1]->txtvalue]);
                configTwilio($admin_mobile_num, $Message); // call to helper function
                $status = array("code" => 400, "msg" => "Error on preparing the fax, Please try again!", "status" => 0);
                echo json_encode($status);
                exit();
            } else {
                $responseData = $response->getData();
                $faxId = $responseData["faxId"];
                /// Successed
                log_message('error', 'success.'.json_encode($faxId));
                $postdata = array(
                    'txtOrderNo' => $faxId,
                    'txtDeviceId'=>$txtDeviceId,
                    'txtStatus' =>'ready to send',
                    'txtCoverPage' => $txtCoverPage,
                    'r_error_code'=>$response->getMessage(),
                    'r_number'=>$r_number,
                    'txtcredits_per_page'=>$txtcredits_per_page,
                    'tokenid'=>$tokenid,
                    'req_from'=>$req_from
                );

                $insert=$this->fax_model->add_fax_data($postdata);
            }
//            if($insert){
//                $getfaxdata=$this->fax_model->getFaxdata($txtDeviceId,$response['txtOrderNo']);
//                $status = array("code"  =>200,"msg" =>"Fax data added successfull","status" =>1,'data'=>$getfaxdata);
//            }else{
//                $status = array("code"  =>400,"msg" =>"Fax sent success but Fax data not added","status" =>0);
//            }
            $data["txtOrderNo"] = $response->getData()["faxId"];
            $status = array("code"=>200,"msg"=>"Fax sent","status" =>1, "data" => $data);
        } else {
            log_message('error', 'File name not get so last else condition.');
            $status = array("code" =>400,"msg"=>"File name not get","status" =>0);

        }
        
        file_put_contents(APPPATH.'controllers/test.txt', '\\n-----phaxiofax_api_ios()------\\n'.http_build_query($status).'\\n-----------\\n', FILE_APPEND);

        echo json_encode($status);
    }


    public function pamfax_api_ios()
    {
        set_time_limit(0);
        ini_set('max_execution_time', 600); //300 seconds = 5 minutes
        ini_set('post_max_size', '128M');
        ini_set('upload_max_filesize', '128M');

        $tokenid = $this->input->post("tokenid");
        $txtDeviceId = $this->input->post("txtDeviceId");
        $r_number = $this->input->post("r_number");
        $txtcredits_per_page = $this->input->post("txtcredits_per_page");
        $txtCoverPage=1;  //$this->input->post("txtCoverPage");
        $files_names=$this->input->post("all_file_name");
        $req_from = $this->input->post("req_from");

        log_message('error', 'postdata.'.json_encode($_POST));

        if($txtDeviceId=='' || $r_number=='' || empty($files_names) || $tokenid =='' || $req_from=='')
        {
            $status = array("code"=>400,"msg"=>"please provided required fileds","status"=>0);
            echo json_encode($status); exit();
        }

        $filename_array=explode(",",$files_names);
        log_message('error', 'file name in array formate.'.json_encode($filename_array));
        if(count($filename_array)>0){
            for($i=0;$i<count($filename_array);$i++)
            {
                $uploadOk = 1;//flage
                $filepath[] = "@" .$this->config->item('upload_path').$filename_array[$i];
            }
        }else{
            $uploadOk == 0;//flage
        }

        log_message('error', 'file name in array formate.'.json_encode($filepath));
        if($uploadOk == 1)
        {

            $this->load->library('pam/pam'); // load lib
            $response=$this->pam->sendFax($filepath,$txtDeviceId,$r_number);
            log_message('error', 'response of fax.'.json_encode($response));
            //echo "<pre>sendfax response:-"; print_r($response);
            if(isset($response['state']) && $response['state'] =="Error preparing the fax")
            {
                log_message('error', 'Error preparing the fax.'.json_encode($response['state']));

                $Message="Fax is Failed.Reason for failed:".$response['state'].".";
                $mobileno=$this->fax_model->getMobileNumber();
                //$admin_mobile_num=$mobileno[0]->txtvalue;
                $admin_mobile_num=array_filter([$mobileno[0]->txtvalue,$mobileno[1]->txtvalue]);
                configTwilio($admin_mobile_num,$Message ); // call to helper function
                $status = array("code"  =>400,"msg" =>"Error on preparing the fax, Please try again!","status" =>0);
                echo json_encode($status); exit();
            }

            if(isset($response['send_response']['result']['code']) && $response['send_response']['result']['code'] =="failure")
            {
                log_message('error', 'failure for errr preparing the fax.'.json_encode($response['send_response']['result']['code']));
                /* twilio */
                // $Message="Fax".$response['txtOrderNo']." is Failed.Reason for failed:".$response['send_response']['result']['code'].".";
                // $mobileno=$this->fax_model->getMobileNumber();
                // $admin_mobile_num=array_filter([$mobileno[0]->txtvalue,$mobileno[1]->txtvalue]);
                // configTwilio($admin_mobile_num,$Message ); // call to helper function
                /* -- */
                $status = array("code"  =>400,"msg" =>"Error preparing the fax","status" =>0);
                echo json_encode($status); exit();
            }



            if(isset($response['send_response']['result']['code']) && $response['send_response']['result']['code']=="success")
            {
                log_message('error', 'success.'.json_encode($response['send_response']['result']['code']));
                $postdata = array(
                    'txtOrderNo' => $response['txtOrderNo'],
                    'txtDeviceId'=>$txtDeviceId,
                    'txtNoOfPage' => $response['txtNoOfPage'],
                    'txtCost' => $response['txtCost'],
                    'txtStatus' =>'ready to send',// $response['txtStatus'],
                    'txtRequestedAt' => $response['txtRequestedAt'],
                    'txtCompletedAt' => $response['txtCompletedAt'],
                    'txtTotalDuration' =>$response['txtTotalDuration'],
                    'txtCoverPage' => $txtCoverPage,
                    'r_error_code'=>$response['send_response']['result']['message'],
                    'r_number'=>$r_number,
                    'txtcredits_per_page'=>$txtcredits_per_page,
                    'tokenid'=>$tokenid,
                    'req_from'=>$req_from
                );

                $insert=$this->fax_model->add_fax_data($postdata);
                if($insert){
                    $getfaxdata=$this->fax_model->getFaxdata($txtDeviceId,$response['txtOrderNo']);
                    $status = array("code"  =>200,"msg" =>"Fax data added successfull","status" =>1,'data'=>$getfaxdata);
                }else{
                    $status = array("code"  =>400,"msg" =>"Fax sent success but Fax data not added","status" =>0);
                }

            } else{
                log_message('error', 'Fax not send.');
                $status = array("code"=>400,"msg"=>"Fax not send","status" =>0);
            }

        }else
        {
            log_message('error', 'File name not get so last else condition.');
            $status = array("code" =>400,"msg"=>"File name not get","status" =>0);

        }

        echo json_encode($status);
    }


    public function get_NumberInfo()
    {

        $r_number = $this->input->post("r_number");
        if($r_number=='')
        {
            $status = array("code"=>400,"msg"=>"please provided required fileds","status"=>0);

        }else{
            $this->load->library('pam/pam'); // load lib
            $response=$this->pam->NumberInfo($r_number);
            $decode_response=json_decode($response);
            // echo "<pre>"; print_r($decode_response->result); exit();
            if($decode_response->result->code=="invalid_fax_number" && $decode_response->result->type=="error"){
                $status = array("code"=>400,"msg"=>"invalid fax Number","status"=>0);
            }else{
                $status = array("code"=>200,"msg"=>"successfully information get","status"=>1,"data"=>$decode_response);
            }
        }
        echo json_encode($status); exit();

    }

    /* 5th dec */
    function getfaxdetails()
    {

        //$uuid ="lmXqROUoDGLRcA";//819aoS4B9NjgH6f5,Pu6HIQnERqgV7Z,lmXqROUoDGLRcA
        $uuid = $this->input->post("uuid");
        $txtDeviceId = $this->input->post("txtDeviceId");
        $req_from = $this->input->post("req_from");
        $TokenId = $this->input->post("token_id");
        $flage = $this->input->post("flage"); // get from get_readytosend_fax

        $this->load->library('pam/pam'); // load lib


        $response=$this->pam->getfaxdetails($uuid);
        $json_decode=json_decode($response,true);


        //if in progress
        if (array_key_exists("FaxRecipient",$json_decode))
        {
            if(isset($json_decode['FaxRecipient']) && !empty($json_decode['FaxRecipient']))
            {
                $status = array("code" =>200,"status" =>1,"msg"=>"inprogress","info"=>"Fax ".$uuid."in progrss");

            }
        }

        //if sent or failure
        if (array_key_exists("FaxHistoryModel",$json_decode))
        {

            if(isset($json_decode['FaxHistoryModel']) && !empty($json_decode['FaxHistoryModel']))
            {
                //echo "<pre>"; print_r($json_decode['FaxHistoryModel']); exit();
                $getfaxdata=$this->fax_model->getFaxdata($txtDeviceId,$uuid); //fetch from tbl
                //$txtRequestedAt=$getfaxdata[0]->txtRequestedAt;
                $txtRequestedAt=$json_decode['FaxHistoryModel']['created'];
                $delivered_time=$json_decode['FaxHistoryModel']['sent'];
                // echo "<pre>"; print_r($txtRequestedAt);
                // echo "<pre>"; print_r($delivered_time);exit();
                $date1=date_create($txtRequestedAt);
                $date2=date_create($delivered_time);
                $diff=date_diff($date1,$date2);
                $txtTotalDuration=$diff->format("%h hours %i minutes %s seconds");


                $txtOrderNo=$uuid;
                $txtStatus=$json_decode['FaxHistoryModel']['state'];
                $r_error_code=$json_decode['FaxHistoryModel']['status_message'];
                $activity_date_display=date("Y-m-d H:i:s");
                $data = array(
                    'txtStatus' => $txtStatus,
                    'r_error_code' => $r_error_code,
                    'created'=>date("Y-m-d H:i:s"),
                    'tokenid'=>$TokenId,
                    'req_from'=>$req_from,
                    'txtCompletedAt'=>$delivered_time,
                    'txtTotalDuration'=>$txtTotalDuration,
                    'txtRequestedAt'=>$txtRequestedAt

                );

                $update=$this->fax_model->update_fax_data($txtDeviceId,$txtOrderNo,$data); // update into tbl

                if($update=="yes")
                {
                    $getfaxdata=$this->fax_model->getFaxdata($txtDeviceId,$uuid); //fetch from tbl

                    if($txtStatus!='failure'){

                        $Message="Fax".$txtOrderNo." is Sent Successfully";
                        if($flage==1)
                        {
                            if($req_from=="android")
                            {
                                $this->send_android_notification($TokenId,$Message); //send android notification
                            }else{
                                $c=$this->send_ios_notification($TokenId,$Message); //send iphone notification
                                log_message('error', 'ios_notification-.'.json_encode($c));
                            }
                        }

                        $status = array("code" =>200,"status" =>1,"msg"=>"sent","info"=>"Fax ".$uuid." is sent","activity_date_display"=>$activity_date_display,"data"=>$getfaxdata);


                    }elseif($txtStatus =='failure'){

                        $Message="Fax".$txtOrderNo." is Failed.Reason for failed:".$r_error_code.".";
                        $mobile_num  = '+917023934474';
                        configTwilioUser( $mobile_num, $Message );
                        if($flage==1)
                        {
                            if($req_from=="android")
                            {
                                $this->send_android_notification($TokenId,$Message); //send android notification
                            }else{
                                $c=$this->send_ios_notification($TokenId,$Message); //send iphone notification
                                log_message('error', 'ios_notification-.'.json_encode($this->send_ios_notification($TokenId,$Message)));
                            }
                        }

                        $status = array("code" =>200,"status" =>1,"msg"=>"failure","info"=>"Fax ".$uuid." is failed","activity_date_display"=>$activity_date_display,"data"=>$getfaxdata);

                        /*Twilio Integrate */
                        $mobileno=$this->fax_model->getMobileNumber(); //get mobile no from tbl
                        $admin_mobile_num=array_filter([$mobileno[0]->txtvalue,$mobileno[0]->txtvalue]);
                        configTwilio($admin_mobile_num,$Message ); // call to helper function
                        /*Twilio Integrate */

                    }else{

                        $status = array("code" =>400,"status" =>0,"msg"=>"data not found");
                    }
                }
                else{

                    $status = array("code" =>400,"status" =>0,"msg"=>"data not found","Reason"=>"uuid or deviced id not matched");
                }
                //
            }
        }

        echo json_encode($status); exit();
    }

    public  function get_readytosend_fax()
    {
        //echo base_url("fax/getfaxdetails"); exit();
        $getReadyToSend=$this->fax_model->getReadyToSend();
        //echo "<pre>"; print_r($getReadyToSend); 
        $TokenArray=array();
        foreach($getReadyToSend as $key=>$value)
        {


            $fields = array("uuid"=>$value->txtOrderNo,"txtDeviceId"=>$value->txtDeviceId,"req_from"=>$value->req_from,"token_id"=>$value->tokenid,"flage"=>1);


            $url=base_url("fax/getfaxdetails");
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);     // url set here
            curl_setopt($ch, CURLOPT_POST, true);    // post type here
            //curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);  // set header type
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // set return transfer true means json false means string

            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);  //set post data or fields in json formate

            // Execute post 
            $result = curl_exec($ch);

            // Check errors
            if ($result) {
                echo $result . "\n";
            } else {
                $error = curl_error($ch). '(' .curl_errno($ch). ')';
                echo $error . "\n";
            }

            // Close connection 
            curl_close($ch);

        }


    }

    
    public function getPhaxioErrorString($error_type, $error_code) {
        if ($error_type == 'documentConversionError') {     /// 
            if ($error_code == 4) {
                return 'There was a problem in converting and merging files to the output file format.';
            } else if ($error_code == 51) {
                return 'There was a problem in converting and merging files to the output file format. Contact Phaxio support.';
            } else if ($error_code == 54) {
                return 'Could not access the url you provided.';
            } else if ($error_code == 55) {
                return 'The string_data URL you provided is invalid';
            } else if ($error_code == 57) {
                return 'There was a problem storing the file you provided.';
            } else if ($error_code == 69) {
                return 'There was a problem in converting and merging files to the output file format.';
            } else if ($error_code == 122) {
                return 'User simulated Document Conversion Error';
            }
        } else if ($error_type == 'documentConversionError') {
            if ($error_code == 11) {
                return 'The call dropped prematurely';
            } else if ($error_code == 15) {
                return 'Congestion';
            } else if ($error_code == 16) {
                return 'Ring Timeout';
            } else if ($error_code == 17) {
                return 'Busy';
            } else if ($error_code == 19) {
                return 'Immediate Hangup';
            } else if ($error_code == 30) {
                return 'No answer from the fax machine.';
            } else if ($error_code == 32) {
                return 'Incompatible destination';
            } else if ($error_code == 34) {
                return 'Phone number not operational';
            } else if ($error_code == 35) {
                return 'Busy';
            } else if ($error_code == 36) {
                return 'Telephony error';
            } else if ($error_code == 37) {
                return 'Telephony error';
            } else if ($error_code == 39) {
                return 'Ring Timeout';
            } else if ($error_code == 43) {
                return 'Problem establishing connection';
            } else if ($error_code == 47) {
                return 'Phone number not operational';
            } else if ($error_code == 49) {
                return 'The Receiving Phone Number Is Not Operational';
            } else if ($error_code == 50) {
                return 'Call rejected';
            } else if ($error_code == 52) {
                return 'No route available';
            } else if ($error_code == 56) {
                return 'Telephony Error';
            } else if ($error_code == 58) {
                return 'Telephony error';
            } else if ($error_code == 59) {
                return 'Telephony error';
            } else if ($error_code == 61) {
                return 'Telephony error';
            } else if ($error_code == 62) {
                return 'Telephony error';
            } else if ($error_code == 64) {
                return 'The call dropped prematurely';
            } else if ($error_code == 71) {
                return 'Incompatible destination';
            } else if ($error_code == 73) {
                return 'Number changed';
            } else if ($error_code == 74) {
                return 'Congestion';
            } else if ($error_code == 81) {
                return 'Telephony error';
            } else if ($error_code == 83) {
                return 'Telephony error';
            } else if ($error_code == 85) {
                return 'Call rejected';
            } else if ($error_code == 87) {
                return 'No answer from the fax machine';
            } else if ($error_code == 88) {
                return 'Network Error';
            } else if ($error_code == 89) {
                return 'The call dropped prematurely';
            } else if ($error_code == 90) {
                return 'Busy';
            } else if ($error_code == 91) {
                return 'Phone number not operational';
            } else if ($error_code == 92) {
                return 'Incompatible destination';
            } else if ($error_code == 93) {
                return 'The call dropped prematurely';
            } else if ($error_code == 94) {
                return 'No answer from the fax machine';
            } else if ($error_code == 95) {
                return 'Incompatible destination';
            } else if ($error_code == 96) {
                return 'The call dropped prematurely';
            } else if ($error_code == 97) {
                return 'Telephony error';
            } else if ($error_code == 98) {
                return 'Congestion';
            } else if ($error_code == 99) {
                return 'Telephony error';
            } else if ($error_code == 100) {
                return 'Problem with remote carrier';
            } else if ($error_code == 101) {
                return 'Congestion';
            } else if ($error_code == 102) {
                return 'Congestion';
            } else if ($error_code == 103) {
                return 'The call dropped prematurely';
            } else if ($error_code == 104) {
                return 'The call dropped prematurely';
            } else if ($error_code == 106) {
                return 'The call dropped prematurely';
            } else if ($error_code == 107) {
                return 'The call dropped prematurely';
            } else if ($error_code == 108) {
                return 'The call dropped prematurely';
            } else if ($error_code == 109) {
                return 'The call dropped prematurely';
            } else if ($error_code == 110) {
                return 'Network error';
            } else if ($error_code == 111) {
                return 'Congestion';
            } else if ($error_code == 112) {
                return 'No answer';
            } else if ($error_code == 114) {
                return 'The call dropped prematurely';
            } else if ($error_code == 115) {
                return 'The phone number has been changed';
            } else if ($error_code == 116) {
                return 'Phone number not operational';
            } else if ($error_code == 118) {
                return 'Busy';
            } else if ($error_code == 121) {
                return 'User requested simulated lineError';
            } else if ($error_code == 123) {
                return 'Phone number not operational';
            } else if ($error_code == 124) {
                return 'Congestion';
            }
        } else if ($error_type == 'lineError') {
            if ($error_code == 6) {
                return 'There was an error communicating with the far side.';
            } else if ($error_code == 7) {
                return 'Far end cannot receive at the size of image';
            } else if ($error_code == 8) {
                return 'No response after sending a page';
            } else if ($error_code == 10) {
                return 'Disconnected after permitted retries';
            } else if ($error_code == 12) {
                return 'Received no response to DCS or TCF';
            } else if ($error_code == 13) {
                return 'Timed out waiting for the first message';
            } else if ($error_code == 14) {
                return 'Timed out waiting for initial communication';
            } else if ($error_code == 18) {
                return 'Unexpected message received';
            } else if ($error_code == 20) {
                return 'The HDLC carrier did not stop in a timely manner';
            } else if ($error_code == 21) {
                return 'Received a DCN from remote after sending a page';
            } else if ($error_code == 22) {
                return 'Received bad response to DCS or training';
            } else if ($error_code == 25) {
                return 'Far end cannot receive at the resolution of the image';
            } else if ($error_code == 26) {
                return 'The remote fax machine failed to respond';
            } else if ($error_code == 28) {
                return 'Failed to train with any of the compatible modems';
            } else if ($error_code == 29) {
                return 'Invalid response after sending a page';
            } else if ($error_code == 31) {
                return 'Fax machine incompatibility';
            } else if ($error_code == 33) {
                return 'Fax machine incompatibility';
            } else if ($error_code == 38) {
                return 'The remote fax machine hung up before receiving fax';
            } else if ($error_code == 40) {
                return 'Telephony error';
            } else if ($error_code == 41) {
                return 'Unexpected DCN while waiting for DCS or DIS';
            } else if ($error_code == 42) {
                return 'Telephony error';
            } else if ($error_code == 44) {
                return 'Telephony Error';
            } else if ($error_code == 45) {
                return 'Fax machine incompatibility';
            } else if ($error_code == 46) {
                return 'Insufficient funds to send fax and not able to auto recharge: There was a problem charging your credit card. Please check your payment information and try again.';
            } else if ($error_code == 48) {
                return 'No answer (The Receiving Machine May Be Out Of Paper)';
            } else if ($error_code == 53) {
                return 'Unexpected DCN after EOM or MPS sequence';
            } else if ($error_code == 60) {
                return 'Transmission error after page break';
            } else if ($error_code == 63) {
                return 'Fax protocol error';
            } else if ($error_code == 65) {
                return 'Fax protocol error';
            } else if ($error_code == 66) {
                return 'Fax protocol error';
            } else if ($error_code == 67) {
                return 'Fax protocol error';
            } else if ($error_code == 68) {
                return 'Far end is not compatible';
            } else if ($error_code == 70) {
                return 'Fax protocol error';
            } else if ($error_code == 72) {
                return 'Fax protocol error';
            } else if ($error_code == 75) {
                return 'Manually canceled by user';
            } else if ($error_code == 76) {
                return 'Canceled automatically because timeout exceeded';
            } else if ($error_code == 77) {
                return 'Timed out waiting for receiver ready (ECM mode)';
            } else if ($error_code == 78) {
                return 'Telephony error';
            } else if ($error_code == 79) {
                return 'Can not cancel the fax, it is already complete!';
            } else if ($error_code == 80) {
                return 'Received a DCN while waiting for a DIS';
            } else if ($error_code == 82) {
                return 'There was an error communicating with the far side';
            } else if ($error_code == 84) {
                return 'Unexpected command after page received';
            } else if ($error_code == 113) {
                return 'The file for this fax has been deleted or is not accessible.';
            } else if ($error_code == 117) {
                return 'No pages received';
            } else if ($error_code == 119) {
                return 'User requested simulated faxError';
            }
        } else if ($error_type == 'faxError') {
            if ($error_code == 4) {

            } else if ($error_code == 51) {

            }
        } else if ($error_type == 'fatalError') {
            if ($error_code == 9) {
                return 'Could not send the file to the fax server for spooling';
            } else if ($error_code == 23) {
                return 'There was a problem in the final stages of sending your fax. Contact Phaxio support.';
            } else if ($error_code == 24) {
                return 'Error 500 - There was a problem in processing your request';
            } else if ($error_code == 126) {
                return 'User requested simulated fatalError';
            }
        } else if ($error_type == 'generalerror') {
            if ($error_code == 3) {
                return 'General error. Contact Phaxio support.';
            } else if ($error_code == 5) {
                return 'Insufficient funds to send fax and not able to auto recharge.';
            } else if ($error_code == 86) {
                return 'Insufficient funds to send fax and not able to auto recharge: Cannot autorecharge. There have been 4 or more failed billing attempts for this card.';
            } else if ($error_code == 105) {
                return 'Insufficient funds to send fax and not able to auto recharge.';
            } else if ($error_code == 120) {
                return 'User requested generalError';
            } else if ($error_code == 125) {
                return 'Insufficient funds to send fax and not able to auto recharge: Cannot autorecharge at this time. We have attempted to charge repeatedly in the past 2 hours.';
            }
        }

        return 'unknown';
    }

} // end of class
