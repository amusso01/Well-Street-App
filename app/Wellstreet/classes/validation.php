<?php
/**
 * Created by PhpStorm.
 * User: desktop
 * Date: 1/16/2018
 * Time: 5:21 PM
 */

namespace Wellstreet\classes;

use Wellstreet\classes\apiCurl;
use Wellstreet\classes\user;

class validation
{
    public $valid;
    public $errorArray;
    public $sessionArray;
    protected $postArray;
    protected $mysqli;

    function __construct($postArray,$mysqli)
    {
        $this->mysqli=$mysqli;
        $this->postArray=$postArray;
        $this->errorArray=array();
        $this->redisplayArray=array();
        $this->sessionArray=array();
        $this->valid=false;
    }
//validate the login process
    protected function validateLogin(){
        $post=$this->postArray;
        /*if form has been submitted with both credentials sanitize the entries*/
        if (!empty($post['pass']) && !empty($post['username'])){
            $uPass=$post['pass'];
            $uPass=mysqli_real_escape_string($this->mysqli,$uPass);
            $uName=$post['username'];
            $uName=trim($uName);
            $uName=strtolower($uName);
            $uName=mysqli_real_escape_string($this->mysqli,$uName);
            /* === prepare statement ===  */
            $query="SELECT * FROM users WHERE username='$uName'";
            $result=mysqli_query($this->mysqli,$query);
            if($result==false){
                die($this->mysqli->error);
            }else{
                $user= $result->fetch_assoc();//user associative array credentials
                /* === check if password and username match === */
                if(password_verify($uPass,$user['password']) && $uName==$user['username']){
    /* === if has admin access priviledge store in session and redirect to the admin page === */
                    if ($user['adminaccess']==1){
                        $_SESSION = array();
                        $_SESSION['uName']=$uName;
                        $_SESSION['admin']='admin';
                        $this->mysqli->close();
                        header('location:?page=admin');
                        die();
                    }else{
                        $_SESSION = array();
                        $_SESSION['uName']=$uName;
                        $_SESSION['user']='user';
                        $this->mysqli->close();
                        header('location:?page=user');
                        die();
                    }
                /*=== if username is correct redisplay it with a password error message === */
                }elseif($uName==$user['username']){
                    $this->errorArray['passError']='Password is incorrect';
                    $this->errorArray['redisplayUser']=htmlentities($uName);
                }else{
                    $this->errorArray['passError']='Username is incorrect';
                }
            }
        }else{
            $this->errorArray['passError']='Password is required';
        }
    }


        //sanitize, trim and lower the user entry in th registration form
    public function sanitizeEntry(){
        foreach ($this->postArray as $key=>$value){
            if($value=='pass'){
                continue;
            }else{
                $value=trim($value);
                $value=strtolower($value);
                $this->postArray[$key]=mysqli_real_escape_string($this->mysqli,$value);
            }
        }
    }

    //This function validate the username and password for a new employee/admin registration
    protected function setUsername()
    {
        $this->sanitizeEntry();
        $uname = $this->postArray['uname'];
    /*=== username validation ===*/
        if ($uname != '') {
            if (strlen($uname) < 6 || strlen($uname) > 45) { //check username length
                $this->errorArray['unameError'] = 'Maximum 45 minimum 6 characters for username';
            } else {
                $number = preg_match_all("/[0-9]/", $uname);
                if ($number < 1) {//check if username contains number, at least one
                    $this->errorArray['unameError'] = 'Username must contains at least 1 number';
                } else {
                    $query = "SELECT * FROM users WHERE username='$uname'";
                    $result = mysqli_query($this->mysqli, $query);
                    if ($result->num_rows !== 0) {//check if the username was already selected by someone else
                        $this->errorArray['unameError'] = 'Username already exist please choose a different one';
                    } else {
                        $this->sessionArray['uname'] = $uname;
                        $pass = $this->postArray['pass'];
             /*=== password validation ===*/
                        if ($pass != '') {
                            if (strlen($pass) < 8 ) {
                                $this->errorArray['redisplayUser'] = $uname;
                                $this->errorArray['passError'] = 'Maximum 15 minimum 8 characters for password';
                            } else {
                                $number = preg_match_all("/[0-9]/", $pass);
                                if ($number < 2) {
                                    $this->errorArray['redisplayUser'] = $uname;
                                    $this->errorArray['passError'] = 'Password must contains at least 2 numbers';
                                } else {
                                    $this->sessionArray['pass'] = $pass;
                                    unset($this->errorArray);
                                }
                            }
                        }

                    }
                }
            }
        }
    }

    //remove escape characters in case  we have to redisplay the field

    protected function RemoveChar($field){
        return str_replace('\\','',$field);
    }


    /*======== user credentials validation =========*/

    protected function validateName($name){
        if($name==''){
            $this->errorArray['nameError']='This field cannot be empty';
            return false;
        }else{
            if (preg_match("/[\p{L}' -]+/", $name)) {
                return true;
            }else{
                $this->errorArray['nameError']='Check this field character not allowed';
                return false;
            }
        }
    }
    protected function validateChoices($choice){
        if($choice==''|| !isset($choice)){
            $this->errorArray['choiceError']='Must choose one';
            return false;
        }else{
            return true;
        }
    }
    protected function validateEmail($email){
        if ($email==''){
            $this->errorArray['emailError']='This field cannot be empty';
            return false;
        }
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    protected function validateDate($date){
        if($date!==''){
            $date= explode('-',$date);
            foreach ($date as $key=>$value){
                $value=(int)$value;
                $date[$key]=$value;
            }
            if (checkdate($date['1'],$date['2'],$date['0'])){
                return true;
            }else{
                return false;
            }
        }
    }
    protected function validateNin($nin){
        if ($nin==''){
            $this->errorArray['ninError']='This field cannot be empty';
            return false;
        }elseif (preg_match("/^([a-zA-Z]){2}( )?([0-9]){2}( )?([0-9]){2}( )?([0-9]){2}( )?([a-zA-Z]){1}?$/",$nin)){
            return true;
        }else{
            return false;
        }
    }
    //Validate the post code using api call to getaddress() service
    //We are using an external api to validate and retrieve the postcode and address
    public function validatePCode($pCode){
        $pCode = preg_replace('/\s+/', '', $pCode);
        $response=new apiCurl('GEpcw5A70k-fLjWoipm_Hg12113','https://api.getAddress.io/find/',$pCode);
        return $response->addressResult();
    }

    protected function validatePhone($phone){
        if($phone==''){
            $this->errorArray['phoenError']='Phone number must be supplied';
            return false;
        }elseif(preg_match("/^(?:0|\+?44)(?:\d\s?){9,10}$/",$phone)){
            return true;
        }else{
            return false;
        }
    }

    protected function validatePayRate($payRate){
        if(preg_match("/[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)/",$payRate)){
            return true;
        }else{
            return false;
        }
    }

    protected function validateHoliday($holiday){
        if($holiday==''){
            $this->errorArray['holidayError']='Select holiday allowed in one year';
            return false;
        }elseif (preg_match("/[+-]?([0-9]+([.][0-9]*)?|[.][0-9]+)/",$holiday)) {
            if ($holiday < 0) {
                $this->errorArray['holidayError'] = 'Holiday must be positive';
                return false;
            } else {
                return true;
            }
        }else{
            $this->errorArray['holidayError']='Must be a number';
            return false;
        }
    }

/*====== finish user credentials validation ======*/



//this function is using the above validator to validate the whole employee details form
//in case of mistake the function will redisplay the correct value and an error message for the fields with mistake
    public function setUser(){
        if($this->validateName($this->postArray['name'])) {
            $this->errorArray['redisplayName'] = $this->removeChar(htmlentities($this->postArray['name']));
            $this->valid = true;
            if ($this->validateName($this->postArray['sname'])){
                $this->errorArray['redisplaySName'] =$this->removeChar(htmlentities($this->postArray['sname']));
                if($this->validateChoices($this->postArray['gender'])){
                    $this->errorArray['gender']=$this->postArray['gender'];
                    if($this->validateChoices($this->postArray['department'])){
                        $this->errorArray['department']=$this->postArray['department'];
                        if($email=$this->validateEmail($this->postArray['email'])){
                            $this->errorArray['redisplayEmail']=$email;
                            if($this->validateDate($this->postArray['sdate'])){
                                $this->errorArray['redisplaySDate']=$this->postArray['sdate'];
                                if($this->validateNin($this->postArray['nin'])){
                                    $this->errorArray['redisplayNin']=$this->postArray['nin'];
                                    if($this->validateDate($this->postArray['dob'])){
                                        $this->errorArray['redisplayDob']=$this->postArray['dob'];
                                        if(is_object($this->validatePCode($this->postArray['pcode']))){
                                            $pCode = preg_replace('/\s+/', '', $this->postArray['pcode']);
                                            $this->errorArray['redisplayPCode']=$pCode;
                                            if($this->validatePhone($this->postArray['phone'])){
                                                $this->errorArray['redisplayPhone']=$this->postArray['phone'];
                                                if($this->validatePayRate($this->postArray['payrate'])){
                                                    $this->errorArray['redisplayPay']=$this->postArray['payrate'];
                                                    if($this->validateHoliday($this->postArray['holiday'])){
                                                        $this->errorArray['redisplayHoliday']=$this->postArray['holiday'];
                                                    }else{
                                                        $this->valid=false;
                                                    }
                                                }else{
                                                    $this->errorArray['payError']='Pay rate must be a number. Please enter a new pay rate';
                                                    $this->valid=false;
                                                }
                                            }else{
                                                $this->errorArray['phoneError']='Phone number was incorrect. Please try again';
                                                $this->valid=false;
                                            }
                                        }else{
                                            $this->errorArray['pCodeError']=$this->validatePCode($this->postArray['pcode']);
                                            $this->valid=false;
                                        }
                                    }else{
                                        $this->errorArray['dobError']='Date format was not valid please enter YYYY-mm-dd';
                                        $this->valid =false;
                                    }
                                }else{
                                    $this->errorArray['ninError']='The NIN was not valid. Please enter a valid NIN';
                                    $this->valid =false;
                                }
                            }else{
                                $this->errorArray['sdateError']='Date format was not valid please enter YYYY-mm-dd';
                                $this->valid =false;
                            }
                        }else{
                            $this->errorArray['emailError']='Email was not a valid. Please enter a valid Email';
                            $this->valid =false;
                        }
                    }else{
                        $this->valid =false;
                    }
                }else{
                    $this->valid =false;
                }
            }else{
                $this->errorArray['snameError']='Please enter this field correctly';
                $this->valid =false;
            }

        }
    }

    /*====== public funtion to call private one =======*/

    //this function prepare the inputed and correct data for the database storing them in the session
    public function buildUser(){
        $this->sessionArray=array(
            'name'=>$this->errorArray['redisplayName'],
            'surname'=>$this->errorArray['redisplaySName'],
            'gender'=>$this->errorArray['gender'],
            'email'=>$this->errorArray['redisplayEmail'],
            'starting_date'=>$this->errorArray['redisplaySDate'],
            'nin'=>$this->errorArray['redisplayNin'],
            'date_of_birthday'=>$this->errorArray['redisplayDob'],
            'post_code'=>$this->errorArray['redisplayPCode'],
            'address'=>$this->postArray['address'],
            'phone_number'=>$this->errorArray['redisplayPhone'],
            'payrate'=>$this->errorArray['redisplayPay'],
            'department'=>$this->errorArray['department'],
            'position'=>$this->postArray['position'],
            'holiday_allowance'=>$this->errorArray['redisplayHoliday'],
        );
        if (isset($_SESSION['adminaccess'])){
            $credentials=array(
                'username'=>$_SESSION['newUName'],
                'password'=>$_SESSION['newPass'],
                'adminaccess'=>$_SESSION['adminaccess']
            );
        }else{
            $credentials=array(
                'username'=>$_SESSION['newUName'],
                'password'=>$_SESSION['newPass']
            );
        }
        return new user($this->sessionArray,$credentials);
    }


    public function validateuser(){
        $this->setUsername();
    }

    public function login(){
        $this->validateLogin();
    }


}
