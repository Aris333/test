<?php
/*
 * This is used to manage Users  
 *  */
define('Success', 'Success');
define('Failure', 'Failure');
class User extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('form');
        $this->load->helper('my_custom_helper');
        $this->load->library('session');
        $this->load->model('user_model');
    }

function test(){
    
    $to       = 'davidatoz309@gmail.com';
    $subject  = 'OTP verify';
    $body     = 'This is your one time password 1234';
    parent::_sendMail($to, $subject, $body);
}


    function enableNotification()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                "status" => 0,
                "code" => 400,
                "msg" => 'bad request method'
            );
            echo json_encode($output);
            die();
        } else {
            $this->form_validation->set_rules('user_id', 'User Id', 'required');
            $this->form_validation->set_rules('key_name', 'Key Name', 'required');
            $this->form_validation->set_rules('status', 'Status', 'required');
            if ($this->form_validation->run() == FALSE) {
                $ddd = current(array_values($this->form_validation->error_array()));
                $output = array("status" => 0, "code" => 400, "msg" => $ddd);
                echo json_encode($output);
                die;
            }
            $key_name = isset($_POST['key_name']) ? $_POST['key_name'] : '';
            $status = isset($_POST['status']) ? $_POST['status'] : '';
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';
            // echo $status;die;
            if ($status == "1" || $status == "0") {
                // echo 'sss',$status;die;
                if ($key_name == 'txtEmailNotification' || $key_name == 'txtPushNotification' || $key_name == 'txtAttachEmailToFax') {
                    if ($this->checkUserId($user_id)) {
                        $data = [$key_name => $status];
                        // print_r($data);die;
                        $this->db->where('txtUID', $user_id)->update('tblUsers', $data);
                        $output = array("status" => 1, "code" => 200, "message" => 'Status change successfully', 'data' => $data);
                    } else {
                        $output = array(
                            "status" => 400,
                            "message" => 'User id not Exist.',
                            'data' => array(),
                        );
                    }
                } else {
                    $output = array(
                        "status" => 400,
                        "message" => 'keyname only accepted txtEmailNotification, txtPushNotification, or txtAttachEmailToFax',
                        'data' => array(),
                    );
                }

            } else {
                $output = array(
                    "status" => 400,
                    "message" => 'status only accepted 0 or 1',
                    'data' => array(),
                );
            }
            echo json_encode($output);
            exit();
        }
        echo json_encode($output);
        die;
    }

    public function version()
    {
        // print_r($_REQUEST);die();
        // print_r($_GET['txtTotalCredit']);die;
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                "status" => Failure,
                "message" => 'bad request',
                'data' => array(),
            );
        } else {

            $version = $this->db->get('tblVersion')->row()->version;

            $output = array(
                "status" => 1,
                "message" => 'version',
                'data' => ['version' => $version],
            );
        }
        echo json_encode($output);
        die;

    }



public function getDeviceToken()
    {
        
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                "status" => Failure,
                "message" => 'bad request',
                'data' => array(),
            );
        } else {
            
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : '';

            $txtDeviceId = $this->db->where('txtUID',$user_id)->get('tblUsers')->row()->txtDeviceId;

            $output = array(
                "status" => 1,
                "message" => 'DeviceId',
                'data' => ['txtDeviceId' => $txtDeviceId],
            );
        }
        echo json_encode($output);
        die;

    }





    public function checkOrderStatus($txtOrderNo = null)
    {
        // print_r($_REQUEST);die();
        // print_r($_GET['txtTotalCredit']);die;
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                "status" => Failure,
                "message" => 'bad request',
                'data' => array(),
            );
        } else {

            $data = $this->db->where('txtOrderNo', $txtOrderNo)
                ->select('txtOrderNo,txtCost,txtStatus')
                ->get('tblFax')
                ->row();

            $output = array(
                "status" => 1,
                "message" => 'data get success',
                'data' =>  $data,
            );
        }
        echo json_encode($output);
        die;

    }


    public function profile($id = null)
    {
        // print_r($_REQUEST);die();
        // print_r($_GET['txtTotalCredit']);die;
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                "status" => Failure,
                "message" => 'bad request',
                'data' => array(),
            );
        } else {
            $txtTotalCredit = $this->input->get('txtTotalCredit');
            $userDetails = $this->db->where('txtUID', $id)->get('tblUsers')->row_array();
            if ($userDetails['txtCreditUpdate'] == '0') {
                $this->db->where('txtUID', $id)->update('tblUsers', ['txtTotalCredit' => $userDetails['txtTotalCredit'] + $txtTotalCredit, 'txtCreditUpdate' => 1]);
            } else {
                if ($txtTotalCredit > 0)
                    $this->db->where('txtUID', $id)->update('tblUsers', ['txtTotalCredit' => $txtTotalCredit]);
            }
        }
        $userDetails = $this->db->where('txtUID', $id)->get('tblUsers')->row_array();

        if (!empty($userDetails)) {
            $output = array(
                "status" => 1,
                "message" => 'User Details',
                'data' => $userDetails,
            );
        } else {
            $output = array(
                "status" => 400,
                "message" => 'Invaild Data User',
                'data' => array(),
            );

        }
        echo json_encode($output);
        die;
    }


    public function updateProfile()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                "status" => Failure,
                "message" => 'bad request',
                'data' => array(),
            );
        } else {
            extract($_POST);
            $this->form_validation->set_rules('user_id', 'UserId', 'required');
            $this->form_validation->set_rules('name', 'name', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required|edit_unique[user.email.' . $user_id . ']');
            $this->form_validation->set_rules('txtPhone', 'Contact Number', 'required|edit_unique[user.txtPhone.' . $user_id . ']');
            if ($this->form_validation->run() == FALSE) {
                $ddd = current(array_values($this->form_validation->error_array())); //die;
                $output = array(
                    'status' => Failure,
                    'message' => $ddd,
                    'data' => array(),
                );
                echo json_encode($output);
                die;
            }
            if ($this->checkUserId($user_id)) {
                $data = array(
                    'name' => $name,
                    'email' => $email,
                    'txtPhone' => $txtPhone,
                    'updated_at' => date('Y-m-d h:i:s')
                );
                $update = $this->db->where('id', $user_id)->update('user', $data);
                $target_dir = BASEPATH . "../assets/uploads/";
                $error_doc = array();
                $documents = array();
                if (isset($_FILES['profile_pic']) && $_FILES['profile_pic']['name'] != '') {
                    $documents['profile_pic'] = $_FILES['profile_pic'];
                }
                if ($documents) {
                    foreach ($documents as $key => $val) {
                        $random_string = rand(1000, 999999);
                        $file_name_arr = $val["name"];
                        $file_name_new = $random_string . '_' . $file_name_arr;
                        $file_name = str_replace(" ", "", $file_name_new);
                        $target_file = $target_dir . basename($file_name);
                        $target_file_arr[] = $target_file;
                        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "pdf") {
                            $error_doc[$key] = 'Sorry, only JPG, JPEG, PNG & PDF files are allowed.';
                        } else {
                            if (move_uploaded_file($val["tmp_name"], $target_file)) {
                                $data = array($key => $file_name);
                                $update = $this->db->where('id', $user_id)->update('user', $data);
                            } else {
                                $error_doc[$key] = 'Sorry, there was an error uploading your file.';
                            }
                        }
                    }
                }
                if ($update != '') {
                    $output = array(
                        "status" => 200,
                        "message" => 'Profile update Successfully',
                        'data' => [],
                    );
                } else {
                    $output = array(
                        "status" => 400,
                        "message" => 'some error occured',
                        'data' => array(),
                    );
                }
            } else {
                $output = array(
                    "status" => 400,
                    "message" => 'User id not Exist.',
                    'data' => array(),
                );
            }
        }
        echo json_encode($output);
        die;
    }


    function userLoginWithMobileEmail()
    {
        try{
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                "status" => 0,
                "code" => 400,
                "msg" => 'bad request method'
            );
            echo json_encode($output);
            die;
        } else {
            $otp = rand(1000, 9999);
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            $this->form_validation->set_rules('txtDeviceId', 'txtDeviceId', 'required');
            if ($this->form_validation->run() == FALSE) {
                $ddd = current(array_values($this->form_validation->error_array()));
                $output = array("status" => 0, "code" => 400, "msg" => $ddd);
                echo json_encode($output);
                die;
            }
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $txtDeviceId = isset($_POST['txtDeviceId']) ? $_POST['txtDeviceId'] : '';
            $is_email = $this->isValidEmail($username);
            if ($is_email) {
                $this->db->where('txtEmail', $username);
            } else {
                $this->db->where('txtPhone', $username);
            }
            $this->db->select('*');
            $check_exists = $this->db->get('tblUsers');
            // print_r($check_exists->num_rows());die;
            
            if ($check_exists->num_rows() > 0) {
                $data = $check_exists->row_array();
                if ($data['txtPassword'] == md5($password)) {
                    // if ($data['txtOtpVerify'] == 1) {
                    if (true) {
                        if ($is_email) {
                            $message = 'Verification code To verify your account, enter the 4 digit code '.$otp;
                            $subject = 'speedyfax: Otp Email';
                        parent::_sendMail($username, $subject, $message);
                            $this->db->where('txtEmail', $username);
                        } else {
                            $message = 'Verification code To verify your account, enter the 4 digit code '.$otp;
                            $mobile = '+'.$username;
                            // $data = configTwilioUser('+917023934474',$message);
                            $this->db->where('txtPhone', $username);
                        }
                        $this->db->update('tblUsers', ['txtDeviceId' => $txtDeviceId]);
                        if ($is_email) {
                            $this->db->where('txtEmail', $username);
                        }else{
                            $this->db->where('txtPhone', $username);
                        }
                        $data = $this->db->get('tblUsers')->row_array();
                        
                        $output = array("status" => 1, "code" => 200, "message" => 'Login successfully', 'data' => $data);
                        echo json_encode($output);
                        die;
                    } else {
                        
                        
                        $this->db->where('txtUID', $data['txtUID'])->update('tblUsers', ['txtOtpVerify', $otp]);
                        $output = array("status" => 1, "code" => 200, "message" => 'OTP sent successfully', 'data' => ['otp' => $otp]);
                        echo json_encode($output);
                        die;
                    }
                } else {
                    $output = array(
                        "status" => 0,
                        "code" => 400,
                        "msg" => 'wrong password'
                    );
                    echo json_encode($output);
                    die;
                }
            } else {
                $message = 'Verification code, To verify your account, Your 4 digit code  '.$otp;
                
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $txtDeviceId = isset($_POST['txtDeviceId']) ? $_POST['txtDeviceId'] : '';
            $is_email = $this->isValidEmail($username);
                    if ($is_email) {
                        $subject = 'speedyfax: Otp Email';
                        parent::_sendMail($username, $subject, $message);
                    } else {
                            $mobile = '+'.$username;
                            // echo $mobile;die;
                            $data = configTwilioUser($mobile,$message);
                    }
            
                        
                $output = array("status" => 1, "code" => 200, "message" => 'OTP sent successfully', 'data' => ['otp' => $otp]);
            }
        }
        echo json_encode($output);
        die;

    }catch(\Throwable $e){
        $output = array(
            'status' => 400,
            'message' => $e->getMessage(). ' On Line '. $e->getLine()
        );
        echo json_encode($output);
        die;
    }
    }


    function userLoginWithSocialMedia()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                "status" => 0,
                "code" => 400,
                "msg" => 'bad request method'
            );
            echo json_encode($output);
            die;
        } else {
            $this->form_validation->set_rules('social_media_id', 'Social Media Id', 'required');
            $this->form_validation->set_rules('type', 'Social Media Type', 'required');
            $this->form_validation->set_rules('txtDeviceId', 'txtDeviceId', 'required');
            // $this->form_validation->set_rules('email', 'Email', 'required');
            if ($this->form_validation->run() == FALSE) {
                $ddd = current(array_values($this->form_validation->error_array()));
                $output = array("status" => 0, "code" => 400, "msg" => $ddd);
                echo json_encode($output);
                die;
            }
            $social_media_id = isset($_POST['social_media_id']) ? $_POST['social_media_id'] : '';
            $txtDeviceId = isset($_POST['txtDeviceId']) ? $_POST['txtDeviceId'] : '';
            $type = isset($_POST['type']) ? $_POST['type'] : '';
            $email = isset($_POST['email']) ? $_POST['email'] : '';
            $this->db->where('txtSocialMediaId', $social_media_id)
            ->or_where('txtEmail',$email);
            $check_exists = $this->db->get('tblUsers');
            if ($check_exists->num_rows() > 0) {
                $data = $check_exists->row_array();
                $output = array("status" => 1, "code" => 200, "message" => 'Login successfully', 'data' => $data);
                echo json_encode($output);
                die;
            } else {
                $this->db->insert('tblUsers', ['txtEmail' => $email, 'txtSocialMediaId' => $social_media_id, 'txtTotalCredit' => 10, 'txtDeviceId' => $txtDeviceId, 'txtLoginType' => $type,
                "txtRole"   =>  2,
                "txtStatus" => "active",
                'txtDateAdded' => date('Y-m-d')]);
                $insert_id = $this->db->insert_id();
                $data = $this->db->where('txtUID', $insert_id)->get('tblUsers')->row_array();
                $output = array("status" => 1, "code" => 200, "message" => 'Login successfully', 'data' => $data);
                echo json_encode($output);
                exit();
            }
        }
        echo json_encode($output);
        die;
    }


    function loginOtpVerify()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                "status" => 0,
                "code" => 400,
                "msg" => 'bad request method'
            );
            echo json_encode($output);
            die();
        } else {
            $this->form_validation->set_rules('username', 'Username', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');
            if ($this->form_validation->run() == FALSE) {
                $ddd = current(array_values($this->form_validation->error_array()));
                $output = array("status" => 0, "code" => 400, "msg" => $ddd);
                echo json_encode($output);
                die;
            }
            $username = isset($_POST['username']) ? $_POST['username'] : '';
            $password = isset($_POST['password']) ? $_POST['password'] : '';
            $txtDeviceId = isset($_POST['txtDeviceId']) ? $_POST['txtDeviceId'] : '';

            $is_email = $this->isValidEmail($username);
            if ($is_email) {
                $usernames = "txtEmail";
            } else {
                $usernames = "txtPhone";
            }

            // start


            if ($is_email) {
                $this->db->where('txtEmail', $username);
            } else {
                $this->db->where('txtPhone', $username);
            }
            $check_exists = $this->db->get('tblUsers');
            if ($check_exists->num_rows() > 0) {
                $data = $check_exists->row_array();
                $is_email = $this->isValidEmail($username);
                if ($is_email) {
                    $this->db->where('txtEmail', $username);
                } else {
                    $this->db->where('txtPhone', $username);
                }

                $this->db->update('tblUsers', ['txtDeviceId' => $txtDeviceId]);


                $output = array("status" => 1, "code" => 200, "message" => 'Login successfully', 'data' => $data);
                echo json_encode($output);
                exit();
            }

            // end



            $this->db->insert('tblUsers', [$usernames => trim($username), 'txtPassword' => md5($password), 'txtTotalCredit' => 10, 'txtDeviceId' => $txtDeviceId ,  "txtRole"   =>  2,
                "txtStatus" => "active", 'txtDateAdded' => date('Y-m-d')]);
            $insert_id = $this->db->insert_id();
            $data = $this->db->where('txtUID', $insert_id)->get('tblUsers')->row_array();
            $output = array("status" => 1, "code" => 200, "message" => 'Login successfully', 'data' => $data);
            echo json_encode($output);
            exit();

        }
        echo json_encode($output);
        die;
    }


    public function forgetPasswordOtp()
    {
        try{
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                "status" => Failure
            );
        } else {
            $this->form_validation->set_rules('username', 'Username', 'required');

            if ($this->form_validation->run() == FALSE) {
                $ddd = current(array_values($this->form_validation->error_array()));
                $output = array(
                    'status' => 400,
                    'message' => $ddd,
                );

                echo json_encode($output);
                die;

            }
            $username = $_POST['username'];
            if ($this->isValidEmail($username)) {
                $userData = $this->db->where('txtEmail', $username)->get('tblUsers')->row();
            } else {
                $userData = $this->db->where('txtPhone', $username)->get('tblUsers')->row();
            }
            if (!empty($userData)) {
                $otp = rand(1000, 9999);
                $message = 'Forgot Password, To reset your password, Your 4 digit code ' .$otp;
                $mobileNo = $userData->txtPhone;

                $to = $userData->txtEmail;
                $subject = 'speedyfax: Otp Email';
                $body = $message;
                // $from = 'dushyant@gmail.com';
                if ($this->isValidEmail($username)) {
                parent::_sendMail($to, $subject, $message);
                } else {
                // $result = parent::_sendOtp($message, $mobileNo);
                
                
                            $mobile = '+' .$username;
                            // $mobile = '+917023934474';
                            // echo $mobile;die;
                            $data = configTwilioUser($mobile,$message);
                }
                if (true) {
                    $userDAta = $this->db->where('txtPhone', $mobileNo)->get('tblUsers')->row();
                    $data = ['user_id' => $userData->txtUID, 'otp' => $otp];
                    $output = array(
                        "status" => 200,
                        "message" => 'Otp sent successfully.',
                        'data' => $data
                    );
                    echo json_encode($output);
                    die;
                } else {
                    $output = array(
                        'status' => 400,
                        'message' => 'Invalid Username.'
                    );
                    echo json_encode($output);
                    die;
                }
            } else {
                $output = array(
                    'status' => 400,
                    'message' => 'Invalid Username'
                );
                echo json_encode($output);
                die;
            }
        }
        echo json_encode($output);
        die;
    }catch(\Throwable $e){
        $output = array(
            'status' => 400,
            'message' => $e->getMessage(). ' On Line '. $e->getLine()
        );
        echo json_encode($output);
        die;
    }
    }


    public function updatePassword()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                "status" => Failure,
                "message" => 'bad request',
                'data' => array(),
            );
        } else {
            $this->form_validation->set_rules('user_id', 'User Id', 'required');
            $this->form_validation->set_rules('password', 'password', 'required');
            if ($this->form_validation->run() == FALSE) {
                $ddd = current(array_values($this->form_validation->error_array()));
                $output = array("status" => 0, "code" => 400, "msg" => $ddd);
                echo json_encode($output);
                die;
            }
            $user_id = $_POST['user_id'];
            $password = $_POST['password'];
            if ($this->checkUserId($user_id)) {
                $update = $this->db->where('txtUID', $user_id)->update('tblUsers', ['txtPassword' => md5($password)]);
                if ($update) {
                    $output = array(
                        "status" => 1,
                        "code" => 200,
                        "message" => 'Password Update successfully.'
                    );
                } else {
                    $output = array("status" => 0, "code" => 400, "msg" => "Some error occured");
                }
            } else {
                $output = array("status" => 0, "code" => 400, "msg" => "wrong User Id");
            }
        }
        echo json_encode($output);
        die;
    }



    private function isValidEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }


    public function changePassword()
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'POST') {
            $output = array(
                "status" => Failure,
                "message" => 'bad request',
                'data' => array(),
            );
        } else {
            $this->form_validation->set_rules('user_id', 'User Id', 'required');
            $this->form_validation->set_rules('new_password', 'New Pasword', 'required');
            $this->form_validation->set_rules('old_password', 'Old Pasword', 'required');
            if ($this->form_validation->run() == FALSE) {
                $ddd = current(array_values($this->form_validation->error_array()));
                $output = array("status" => 0, "code" => 400, "msg" => $ddd);
                echo json_encode($output);
                die;
            }
            $user_id = isset($_POST['user_id']) ? $_POST['user_id'] : 0;
            $old_password = isset($_POST['old_password']) ? $_POST['old_password'] : '';
            $new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
            if ($this->checkUserId($user_id)) {
                $userData = $this->getUserData($user_id);
                if ($userData->txtPassword != md5($old_password)) {
                    $output = array("status" => 0, "code" => 400, "msg" => 'Old Password Not match.');
                    echo json_encode($output);
                    die;
                }
                $data = array('txtPassword' => md5($new_password));
                $update = $this->db->where('txtUID', $user_id)->update('tblUsers', $data);
                if ($update) {
                    $output = array(
                        "status" => 1,
                        "code" => 200,
                        "message" => 'Password Update successfully.'
                    );
                } else {
                    $output = array("status" => 0, "code" => 400, "msg" => 'Some error occured.');
                }
            } else {
                $output = array("status" => 0, "code" => 400, "msg" => 'wrong User Id.');
            }
        }
        echo json_encode($output);
        die;
    }

    public function deleteMyAccount($user_id)
    {
        $method = $this->input->server('REQUEST_METHOD');
        if ($method != 'GET') {
            $output = array(
                "status" => Failure,
                "message" => 'bad request',
                'data' => array(),
            );
        } else {
            if ($this->checkUserId($user_id)) {
                $data = [
                    'txtEmail' => 'delete account',
                    'txtPassword' => 'delete account',
                    'txtName' => 'delete account',
                    'txtPhone' => 'delete account',
                    'txtTotalCredit' => 'delete account',
                ];
                $update = $this->db->where('txtUID', $user_id)->update('tblUsers', $data);
                if ($update) {
                    $output = array(
                        "status" => 1,
                        "code" => 200,
                        "message" => 'delete successfully.'
                    );
                } else {
                    $output = array("status" => 0, "code" => 400, "msg" => 'Some error occured.');
                }
            } else {
                $output = array("status" => 0, "code" => 400, "msg" => 'wrong User Id.');
            }
        }
        echo json_encode($output);
        die;
    }











    private function checkUserId($id)
    {
        $check_exists = $this->db->where('txtUID', $id)->get('tblUsers')->num_rows();
        if ($check_exists > 0) {
            return true;
        } else {
            return false;
        }
    }

    private function getUserData($id)
    {
        $check_exists = $this->db->where('txtUID', $id)->get('tblUsers')->row();
        if (!empty($check_exists)) {
            return $check_exists;
        } else {
            return false;
        }
    }


    public function login($page = "login")
    {
        $data["title"] = "Login";
        if ($user = $this->session->userdata('txtEmail')):
            redirect(site_url('user'));
            $this->logout();
        else:
            $this->load->view('user/' . $page, $data);
        endif;

    }


    public function verifyLogin()
    {
        if ($this->user_model->validateUser($this->input->post('txtEmail'), md5($this->input->post('txtPassword')))):
            $user = $this->user_model->get_user($this->input->post('txtEmail'), md5($this->input->post('txtPassword')));
            $this->session->set_userdata('txtEmail', $user->txtEmail);
            echo 1;
        else:
            echo 0;
        endif;
    }


    public function logout()
    {
        $this->session->unset_userdata('txtEmail');
        redirect(site_url('user/login'));
    }

    public function index()
    {
        if ($this->session->userdata("txtEmail") == "") {
            redirect("user/login");
        }
        $user = $this->user_model->getAllUser();
        $data["allUser"] = $user;
        $data["title"] = "users";
        $this->load->view("layout/header", $data);
        $this->load->view("layout/sidebar", $data);
        $this->load->view("user/index", $data);
        $this->load->view("layout/footer", $data);

    }


    public function edit($id)
    {
        if ($this->session->userdata("txtEmail") == "") {
            redirect("user/login");
        }
        $data["title"] = "Edit User";
        $data["userData"] = $this->user_model->getUserById($id);
        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('user/edit', $data);
        $this->load->view('layout/footer', $data);
    }

    public function addUser()
    {
        if ($this->session->userdata("txtEmail") == "") {
            redirect("user/login");
        }
        $data["title"] = "Add User";

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('user/add', $data);
        $this->load->view('layout/footer', $data);
    }

    public function view($id)
    {
        if ($this->session->userdata("txtEmail") == "") {
            redirect("user/login");
        }
        $data["title"] = "View User";
        $data["userData"] = $this->user_model->getUserById($id);
        $data["usersPromoCodeData"] = $this->user_model->usersPromoCodeHistory($id);

        $this->load->view('layout/header', $data);
        $this->load->view('layout/sidebar', $data);
        $this->load->view('user/view', $data);
        $this->load->view('layout/footer', $data);
    }


    public function delete($id)
    {
        if ($this->session->userdata("txtEmail") == "") {
            redirect("user/login");
        }
        $remove = $this->user_model->deleteUser($id);
        redirect("user");

    }


    public function freeCredit( $id ){
        if( $this->session->userdata("txtEmail") == ""){
            redirect("user/login");
        }

        $this->db->where('txtUID', $id);
        $this->db->set('txtTotalCredit', 'txtTotalCredit+300', FALSE);
        $this->db->set('txtFreeCredit', 'Yes');
        $this->db->update('tblUsers');
        redirect("user");
       
    }



    public function insertUser()
    {
        $data["txtName"] = $this->input->post('txtName');
        $data["txtEmail"] = $this->input->post('txtEmail');
        $data["txtPhone"] = $this->input->post('txtPhone');

        if ($this->user_model->checkUserExist($data["txtEmail"]) == 1) {
            redirect("user/addUser?msg=2");
        } else {
            $insert = $this->user_model->addUser($data);
            redirect("user");
        }

    }




    /* API */
    public function add()
    {

        if ($this->input->post('txtEmail') != "") {
            $txtEmail = $this->input->post('txtEmail');
            //$txtTotalCredit = $this->input->post('txtTotalCredit');
            $txtName = $this->input->post('txtName');
            //$txtPhone = $this->input->post('txtPhone');
            $data["txtEmail"] = $txtEmail;
            $data["txtName"] = $txtName;
            // $data["txtPhone"] = ($txtPhone!=""?$txtPhone:"");
            if ($this->user_model->userExist($txtEmail)):
                $userUpdate = $this->user_model->updateUser($txtEmail, $data);
                $userData = $this->user_model->get_user($txtEmail);
                $txtUID = $userData->txtUID;
                $status = array(
                    "code" => 200,
                    "msg" => "User is already exist",
                    "txtUID" => $txtUID
                );
                echo json_encode($status);
            else:
                $this->user_model->addUser($data);
                $userData = $this->user_model->get_user($txtEmail);
                $txtUID = $userData->txtUID;
                $status = array(
                    "code" => 200,
                    "msg" => "User registered successfully",
                    "txtUID" => $txtUID
                );
                echo json_encode($status);
            endif;
        } else {
            $status = array(
                "code" => 422,
                "msg" => "Email id is not set"

            );
            echo json_encode($status);
        }



    }


    public function updateUserCredit()
    {
        $txtUID = $this->input->post("txtUID");
        $txtTotalCredit = $this->input->post("txtTotalCredit");

        $data["txtUID"] = $txtUID;
        $data["txtTotalCredit"] = $txtTotalCredit;

        $update = $this->user_model->updateUserCredit($txtUID, $txtTotalCredit);
        if ($update == 1) {
            $status = array(
                "code" => 200,
                "msg" => "User credit updated"
            );

            echo json_encode($status);
        } else {
            $status = array(
                "code" => 422,
                "msg" => "Error while update user credit"
            );
            echo json_encode($status);
        }
    }
/* API */

}