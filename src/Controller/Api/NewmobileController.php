<?php
namespace App\Controller\Api;
use App\Controller\Api\AppController;
use App\Controller\App;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Event\Event;
use Cake\Utility\Security;
use Firebase\JWT\JWT;
use Razorpay\Api\Api;
use RNCryptor\RNCryptor\Decryptor;
use RNCryptor\RNCryptor\Encryptor;

include '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
include '../vendor/phpmailer/phpmailer/src/Exception.php';
include '../vendor/phpmailer/phpmailer/src/SMTP.php';
include '../vendor/phpmailer/phpmailer/src/OAuth.php';
include '../vendor/autoload.php';

// include '../vendor/rncryptor/rncryptor/src/RNCryptor/Decryptor.php';

class NewmobileController extends AppController
{

  public function beforeFilter(Event $event)
  {
    parent::beforeFilter($event);
    $this->loadModel('Users');
    $this->loadModel('Categories');
    $this->loadModel('Notifications');
    $this->loadModel('Sliders');
    $this->loadModel('UserAddresses');
    $this->loadModel('Products');
    $this->loadModel('Carts');
    $this->loadModel('Orders');
    $this->loadModel('OrderDetails');
    
  }

  public function initialize()
  {
    parent::initialize();
    $this->Auth->allow(['registration', 'loginOtpVerify','prepareRequestBody', 'registrationOtpVerify', 'login','resendOtp','contactInformation','home','faqCategories','faqQuestion','couponsList','uploadToken']);
  }

  public $helpers = ['CakeJs.Js'];

  public function _setPassword($password)
  {
    return (new DefaultPasswordHasher)->hash($password);
  }

  public function prepareRequestBody()
  {
    $data = json_encode($this->request->data);
    $cryptor = new Encryptor;
    $base64Encrypted = $cryptor->encrypt($data, DECRYPT);
    $response['payload'] = $base64Encrypted;
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response;
  }

  public function dPayload($data)
  {
    $base64Encrypted = $data->payload;
    $cryptor = new Decryptor;
    $plaintext = $cryptor->decrypt($base64Encrypted, DECRYPT);
    $postData = json_decode($plaintext);
    return $postData;
  }

  public function userId()
  {
    $user = $this->Auth->user();
    return $user; 
  }
  
  public function sendmsg($mobile,$msg)
  {
    
    $curl = curl_init();
    $mobil="91".$mobile;
    $msgs=$msg;
    
    $url = 'http://107.20.199.106/sms/1/text/query?username=veggie&password=Veggie302019&to='.$mobil.'&text='.urlencode($msgs);
    //pr($url); die;
    curl_setopt_array($curl, array(
     CURLOPT_URL =>$url,
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => "",
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 30,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => "GET",
     CURLOPT_HTTPHEADER => array(
       "accept: application/json"
     ),
   ));
    
    $response = curl_exec($curl);
    $err = curl_error($curl);
    
    curl_close($curl);
    
    if ($err) {
     echo "cURL Error #:" . $err; die;
   } 
   
 }

 public function registration()
 {
  $this->autoRender = false;
  if ($this->request->is('post')) { 
    $response = array();
    if (empty($this->request->getData()['name']) || empty($this->request->getData()['address']) || empty($this->request->getData()['villageName']) || empty($this->request->getData()['mobile'])  || empty($this->request->getData()['animalCount']) || empty($this->request->getData()['milkQuantity'])) {
      $response['success'] = false;
      $response['message'] = "Invalid Parameters";
      $this->response->type('application/json');
      $this->response->body(json_encode($response));
      return $this->response;
    }
    extract($this->request->getData());
            //pr($name); die;
    $mobileExist = $this->Users->exists(['OR'=>[['mobile'=>$mobile]], 'status' => 1]);
    if ($mobileExist) {
      $response['success'] = false;
      $response['message'] = "Mobile Number already Exist";
      $this->response->type('application/json');
      $this->response->body(json_encode($response));
      return $this->response;
    }
    $user = $this->Users->newEntity();
    $user['name'] = $name;
    $user['address'] = $address;
    $user['villagename'] = $villageName;
    $user['mobile'] = $mobile;
    $user['animalCount'] = $animalCount;
    $user['milkQuantity'] = $milkQuantity;
    $user['email'] = $email;
    $user['status'] = 1;
            $user['otp'] = 1234; //rand(1001, 9999);
            $user['role_id'] = 3;
            
            if ($this->Users->save($user)) {
               // pr($user); die;
              $response['success'] = true;
                //   $message = "OTP for Nusearch Pharma Registration is " . $user['otp'];
                //  $smsUrl = "http://alerts.prioritysms.com/api/web2sms.php?workingkey=Adbefca5cdb1c4ca5fe96bd90a639602c&to=" . trim($user['mobile']) . "&sender=PRIRTY&message=" . $message;
                //   $sendmsg =  file_get_contents($smsUrl);
              $response['message'] = "Registered Successfully";
              $this->response->type('application/json');
              $this->response->body(json_encode($response));
              return $this->response;
            }
          } else {
            $response['success'] = false;
            $response['message'] = "Invalid Data Type";
            echo json_encode($response);
            return;
          }
        }

        public function login()
        {
          $this->autoRender = false;
          if ($this->request->is('post')) {
            $response = array();
            if (empty($this->request->getData()['mobile'])) {
              $response['success'] = false;
              $response['message'] = "Invalid Parameters";
              $this->response->type('application/json');
              $this->response->body(json_encode($response));
              return $this->response;
            }
            $verifiedUser = $this->Users->find('all')->where(['mobile' => $this->request->getData()['mobile']])->order(['id' => 'DESC'])->first();
            if (empty($verifiedUser)) {
              $response['success'] = false;
              $response['message'] = "Not a Registered Number";
              $this->response->type('application/json');
              $this->response->body(json_encode($response));
              return $this->response;
            }
            if ($verifiedUser->status != 1) {

              $response['success'] = false;
              $response['message'] = "Inactive Account";
              $this->response->type('application/json');
              $this->response->body(json_encode($response));
              return $this->response;

            }
            $response = array();
            $response['success'] = true;
            //$verifiedUser['otp'] = rand(1001, 9999);
            $verifiedUser['otp'] = 1234;
            $this->Users->save($verifiedUser);

            // $message = "OTP for Nusearch Pharma Login is " . $verifiedUser['otp'];
            // $smsUrl = "http://alerts.prioritysms.com/api/web2sms.php?workingkey=Adbefca5cdb1c4ca5fe96bd90a639602c&to=" . trim($verifiedUser['mobile']) . "&sender=PRIRTY&message=" . $message;
            //  $sendmsg =  file_get_contents($smsUrl);

            $response['message'] = "OTP Successfully sent to Registered Number";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;

          } else {
            $response = array();
            $response['success'] = false;
            $response['message'] = "Invalid Data Type";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;
          }
        }

        
        public function loginOtpVerify()
        {
          $this->autoRender = false;
          if ($this->request->is('post')) {
            if (empty($this->request->data['otp']) || empty($this->request->data['mobile'])) {
              $response = array();
              $response['success'] = false;
              $response['message'] = "Invalid Parameters";
              $this->response->type('application/json');
              $this->response->body(json_encode($response));
              return $this->response;
            }
            $verifiedUser = $this->Users->find('all')->where(['mobile' => $this->request->data['mobile'], 'otp' => $this->request->data['otp'], 'Users.status' => 1])->first();
            if (empty($verifiedUser)) {
              $response = array();
              $response['success'] = false;
              $response['message'] = "Invalid OTP";
              $this->response->type('application/json');
              $this->response->body(json_encode($response));
              return $this->response;
            }
            $data = array();
            $response = array();
            $response['success'] = true;
            $response['message'] = 'OTP verified successfully';
            $response['userInfo']['id'] = $verifiedUser['id'];
            $response['userInfo']['role'] = 'Customer';
            $response['userInfo']['authToken'] = JWT::encode([
              'sub' => $verifiedUser['id'],
              'exp' => time() + 2592000,
            ],
            Security::salt());

            $udata['token']= $response['userInfo']['authToken'];
            $usavepack = $this->Users->patchEntity($verifiedUser, $udata);
            $uresult=$this->Users->save($usavepack);
            // $cryptor = new Encryptor;
            // $data = json_encode($data);
            // $base64Encrypted = $cryptor->encrypt($data, DECRYPT);
            // $response['payload'] = $base64Encrypted;
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;

          } else {
            $response = array();
            $response['success'] = false;
            $response['message'] = "Invalid Data Type";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;
          }
        }

        public function resendOtp()
        {
          $this->autoRender = false;
          if ($this->request->is('post')) {
            $response = array();
            if (empty($this->request->getData()['mobile'])) {
              $response['success'] = false;
              $response['message'] = "Invalid Parameters";
              $this->response->type('application/json');
              $this->response->body(json_encode($response));
              return $this->response;
            }
            $verifiedUser = $this->Users->find('all')->where(['mobile' => $this->request->getData()['mobile']])->order(['id' => 'DESC'])->first();
            if (empty($verifiedUser)) {
              $response['success'] = false;
              $response['message'] = "Not a Registered Number";
              $this->response->type('application/json');
              $this->response->body(json_encode($response));
              return $this->response;
            }
            
            $verifiedUser['otp'] = 1234;
            $this->Users->save($verifiedUser);
            
            // $message = "OTP for Nusearch Pharma Login is " . $verifiedUser['otp'];
            // $smsUrl = "http://alerts.prioritysms.com/api/web2sms.php?workingkey=Adbefca5cdb1c4ca5fe96bd90a639602c&to=" . trim($verifiedUser['mobile']) . "&sender=PRIRTY&message=" . $message;
            //  $sendmsg =  file_get_contents($smsUrl);
            $response['success'] = true;
            $response['message'] = "OTP Successfully Resent to Registered Number";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;
          } else {
            $response = array();
            $response['success'] = false;
            $response['message'] = "Invalid Data Type";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;
          }
        }
        

        public function uploadToken()
        {
          $this->autoRender = false;
          $this->loadModel('Devices');
          
          if ($this->request->is('post')) {
            if (!isset($this->request->getData()['token']) || empty($this->request->getData()['uniqueDeviceId'])) {
              $response = array();
              $response['success'] = false;
              $response['message'] = "Invalid Parameters";
              echo json_encode($response);
              return;
            }
            extract($this->request->getData());
            $newDevice = $this->Devices->find()->where(['device_id' => $uniqueDeviceId])->first();
            if (empty($newDevice)) {
              $newDevice = $this->Devices->newEntity();
              $newDevice['device_id'] = $uniqueDeviceId;
              
            }
            
      //$newDevice['lat'] = $latitude;
      //$newDevice['longitude'] = $longitude;
      //$location_country  = $this->get_country($latitude,$longitude);

      //$newDevice['location'] = trim($location_country);
            $newDevice['token'] = $token;
            $device = $this->Devices->save($newDevice);
            $response['success'] = true;
            $response['userInfo']['deviceId'] = $device['id'];
      //$response['userInfo']['location'] = "US";
      // $response['userInfo']['location'] =  trim($location_country);
      // if($device['location']=="India"){
      // $response['userInfo']['currency'] = "Rupee"; 
      // }else{
      // $response['userInfo']['currency'] = "Dollar";  
      // }
      
            $response['message'] = "Token Updated Successfully";
            echo json_encode($response);
            return;
          } else {
            $response = array();
            $response['success'] = false;
            $response['message'] = "Invalid Data Type";
            echo json_encode($response);
            return;
          }
        }

        public function notifications()
        {
          $this->autoRender = false;
          $response = array();
          $userId = $this->userId()['id'];
          $notifications=$this->Notifications->find()->where(['OR'=>[['user_id'=>0],['user_id'=>$userId]],'status'=>1,'DATE(created) >='=>date('Y-m-d',strtotime('-31 days'))])->toarray();
          if(!empty($notifications)){
            $response['success']=true;
            foreach($notifications as $notification){
              $data=[];
              $data=['title'=>$notification['title'],'message'=>$notification['message'],'date'=>date('d M,y',strtotime($notification['created']))];
              $response['notifications'][]=$data;
            }
          }else{
            $response['success']=false;
            $response['message']="You have no Notifications";
          }
          $this->response->type('application/json');
          $this->response->body(json_encode($response));
          return $this->response;
          
        }



        public function viewProfile(){

          $this->loadmodel('User');
          $this->autoRender=false;
          $response = array();
          if ($_SERVER['REQUEST_METHOD'] === 'GET') {
           $user_id = $this->userId()['id'];
           $result = $this->Users->find()->where(['Users.id' => $user_id])->first();
           
           $product = array();
           if (count($result) > 0)
           {  
            $response["success"] = true;
            $product["name"]=$result['name'];
            $product["mobile"]=$result['mobile'];
              //$product["email"]=$result['email'];
            
            $response["userProfile"] = $product;
            echo json_encode(($response));
          }
          else
          {
            $response["success"] = false;
            $response["message"] = "Profile Not Found";
            echo json_encode(($response));
          }
        }
        else
        {
         $response["success"] = false;
         $response["message"] = "Ivalid Method";
         echo json_encode(($response));
       }
     }
     
     public function contactInformation(){

      $this->loadmodel('User');
      $this->autoRender=false;
      $response = array();
      if ($_SERVER['REQUEST_METHOD'] === 'GET') {
       $user_id = $this->userId()['id'];
       $result = $this->Users->find()->where(['Users.role_id' => 1])->first();

       $product = array();
       if (count($result) > 0)
       {  
        $response["success"] = true;
        $product["helplineNumber"]=$result['helpline_number'];
        $product["contactEmail"]=$result['contact_email'];
        $product["factoryAddress"]=$result['factroy_address'];
        $product["smsMobile"]=$result['sms_mobile'];
        $product["registerAddress"]=$result['address'];
        $product["address1"]=$result['address_1'];
        $product["pincode1"]=$result['pincode_1'];
        $product["address2"]=$result['address_2'];
        $product["pincode2"]=$result['pincode_2'];
        $product["address3"]=$result['address_3'];
        $product["pincode3"]=$result['pincode_3'];
        $product["accountName"]=$result['account_name'];
        $product["bankName"]=$result['bank_name'];
        $product["accountNumber"]=$result['account_number'];
        $product["ifsc"]=$result['ifsc'];
        $product["branch"]=$result['branch'];
        
        $response["contactInformation"] = $product;
        echo json_encode(($response));
      }
      else
      {
        $response["success"] = false;
        $response["message"] = "Profile Not Found";
        echo json_encode(($response));
      }
    }
    else
    {
     $response["success"] = false;
     $response["message"] = "Ivalid Method";
     echo json_encode(($response));
   }
 }

 

 


 public function editProfile(){
  $this->autoRender=false;
  $response = array();
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         // pr($this->userId())
   $user_id=$this->userId()['id'];
   
   $name = $_POST["name"];
       //$email = $_POST["email"];
   $mobile = $_POST["mobile"];
   
   
   if($name=='' || $mobile==''){
    $response["success"] = false;
    $response["message"] = "Please fill all required fields";
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response;
  }
  //die;
  $user = $this->Users->find()->where(['id' => $user_id])->first();
  $check_mobile = $this->Users->find()->where(['mobile' => $mobile,'id !='=> $user_id])->count();
  if($check_mobile>0){
    $response["success"] = false;
    $response["message"] = "This mobile number is already exist";
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response;
  }
  if(count($user) > 0){
          // $newpack = $this->UserAddresses->newEntity();
          // $addresss['user_id']= $user_id;
          // $addresss['address']= $address;
          // $saveaddress = $this->UserAddresses->patchEntity($newpack, $addresss);
          // $address_results=$this->UserAddresses->save($saveaddress);
    
          // $address_update = $this->UserAddresses->find()->where(['user_id' => $user_id,'id !=' => $address_results['id']])->toarray();
          // $status['status']= 'N';
          // foreach($address_update as $value){
          //     $reslt = $this->UserAddresses->patchEntity($value, $status);    
          //     $address_result=$this->UserAddresses->save($reslt);
          // }
    
    $data['name']= $name;
        //  $data['email']= $email;
    $data['mobile']= $mobile; 
          // $data['firm_name']= $firm_name;
          // $data['gst_no']= $gst_no;
          // $data['state_id']= $state_id;
          // $data['user_address_id']= $address_results['id'];
    
          if ($image['name'] != '')
          {
              $imgname = $image['name'];
              $item = $image['tmp_name'];
              $ext =  end(explode('.',$image['name']));
              $name = md5($image['name']);
              $imagename= $name.'.'.$ext; 
              $dest='images/product_images/'.$imagename;
              if(move_uploaded_file($item,$dest))
              {  //echo $imagename; die;
                 $data['image']=$imagename;
             }
         }
    
    
    $savepack = $this->Users->patchEntity($user, $data);
         //pr($savepack); die;
    $results=$this->Users->save($savepack);
    $response["success"] = true;
    $response["message"] = "Profile Updated Successfully";
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response;
    
  }
  else{
    $response["success"] = false;
    $response["message"] = "Profile Not Updated";
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response;
  }
}
else{
 $response["success"] = false;
 $response["message"] = "Invalid Method";
 $this->response->type('application/json');
 $this->response->body(json_encode($response));
 return $this->response;
}
}

public function home()
{
  $this->autoRender = false;
  $response = array();
  $this->loadModel('Products'); 
  $this->loadModel('ProductImages'); 
  $this->loadModel('ProductAddons'); 
  $this->loadModel('Devices');

  
  //print_r($_POST['uniqueDeviceId']); die;
  $Sliders = $this->Sliders->find()->where(['status' => 'Y'])->order(['Sliders.id'=>'ASC'])->toarray();
  $response['success'] = true;

  $newDevice = $this->Devices->find()->where(['id' => $_GET['uniqueDeviceId']])->first();
   
        //  //to find out user notification count
  $user_notify=$this->Users->find()->select(['notification_counter'])->where(['Users.id'=>$this->request->data['payloadId']])->first();
  $response['details']['userNotificationCountStatus']=$user_notify['notification_counter']!= '0' && $user_notify['notification_counter']!= '' ? true : false;
  $response['details']['userNotificationCount']=$user_notify['notification_counter'];

  $userId = $this->request->getData()['userId'];
  //pr($userId); die;
  if($userId){
  $cartCount = $this->Carts->find()->select(['sum' => 'SUM(Carts.quantity)'])->where(['user_id' => $userId])->first();
  //pr($cartCount); die;
  $response['details']['cartItemCount'] =  ($cartCount['sum']) ? (int)$cartCount['sum'] : 0; 
  }else{
    $response['details']['cartItemCount'] = 0; 
  }


  if (empty($Sliders)) {
    $response['message'] = "No Categories to Display";
    $response['categories'] = null;
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response;
  }
  foreach ($Sliders as $slider) {
    $data = [];
    if(empty($slider['image'])){
      $data['image'] = SITE_URL . 'images/image/default_category.jpg';
    }else{
      $data['image'] = SITE_URL . 'images/image/' . $slider['image'];
    }
    $response['sliders'][] = $data;

  }

  $products = $this->Products->find()->where(['status' => 'Y'])->order(['Products.id'=>'ASC'])->toarray();
  $response['success'] = true; 
  //pr($user_notify['id']); die;
 
  
  foreach ($products as $product) {

    $products_images = $this->ProductImages->find()->where(['product_id' => $product['id']])->toarray();    
    $products_addons = $this->ProductAddons->find()->where(['product_id' => $product['id']])->toarray();   
    $data_product = [];
    $data_product['id'] =  $product['id'];
    $data_product['name'] =  $product['name'];
    $data_product['brandName'] =  $product['brand_name'];
    $data_product['description'] =  $product['description'];  
    $data_product['featuredImage'] =  SITE_URL . 'images/product_images/'.$products_images[0]['image'];
    

    foreach($products_images as $image){
      $data_product['productImage'][] =  SITE_URL . 'images/product_images/'.$image['image'];
    }
    
    foreach($products_addons as $addons){
      $addons_data['id'] =  $addons['id'];
      $addons_data['name'] =  $addons['name']." Kg";
      $addons_data['price'] =  $addons['price'];
      $data_product['productAddons'][] =  $addons_data; 
    }

    $response['product'][] = $data_product;
    
  }   

  $this->response->type('application/json');
  $this->response->body(json_encode($response));
  return $this->response;


}


public function faqCategories()
{
  $this->loadModel('Faq');
  $this->autoRender = false;
  $categories = $this->Faq->find()->where(['status' => 'Y'])->toarray();
  if (empty($categories)) {
    $response = array();
    $response['success'] = false;
    $response['message'] = "No Questions Found";
    echo json_encode($response);
    return;
  }
  $response['success'] = true;
  foreach ($categories as $category) {
    $data = [];
    $data['id'] = $category['id'];
    $data['name'] = $category['name'];
    $data['image'] = SITE_URL . "images/faq/ic_faq.png";
    $response['categories'][] = $data;
  }
  echo json_encode($response);
  return;
}

public function faqQuestion()
{
  $this->autoRender = false;
  if ($this->request->is('post')) {
    if (empty($this->request->getData()['categoryId'])) {
      $response = array();
      $response['success'] = false;
      $response['message'] = "Invalid Parameters";
      echo json_encode($response);
      return;
    }

    $this->loadModel('FaqCatQuestion');
            //echo $this->request->getData()['categoryId']; die;
    $questions = $this->FaqCatQuestion->find()->where(['faq_cat_id' => $this->request->getData()['categoryId'], 'status' => 'Y'])->toarray();
    if (empty($questions)) {
      $response = array();
      $response['success'] = false;
      $response['message'] = "No Questions Found";
      echo json_encode($response);
      return;
    }
    $response = array();
    $response['success'] = true;
    foreach ($questions as $question) {
      $data = [];
      $data['question'] = $question['question'];
      $data['answer'] = $question['answer'];
      $response['questions'][] = $data;
    }
    echo json_encode($response);
    return;
  } else {
    $response = array();
    $response['success'] = false;
    $response['message'] = "Invalid Data Type";
    echo json_encode($response);
    return;
  }
}

public function couponsList()
{
  $this->autoRender = false;
  $userId = $this->userId()['id'];
  $user_type=$this->userId()['user_type'];  
  $this->loadModel('Coupons');
  $today = date('Y-m-d');
  $coupons = $this->Coupons->find()->where(['status' => 1, 'DATE(valid_from) <=' => $today, 'DATE(valid_to) >=' => $today])->toarray();
  $response = array();
  if (empty($coupons)) {
    $response['success'] = false;
    $response['message'] = "No Coupons Found";
    echo json_encode($response);
    return;
  }
  $response['success'] = true;
  $response['coupons'] = [];
  foreach ($coupons as $coupon) {
    $data = [];
    $data['code'] = $coupon['code'];
    $data['description'] = $coupon['description'];
    $data['validTill'] = date('d/m/Y', strtotime($coupon['valid_to']));
    $response['coupons'][] = $data;
  }
  echo json_encode($response);
  return;
}



public function onlinePaymentVerification()
{
  $this->autoRender = false;
  if ($this->request->is('post')) {
    $response = array();
    if (empty($this->request->data['appointmentId']) || empty($this->request->data['onlineOrderId']) || empty($this->request->data['deviceId'])) {
      $response['success'] = false;
      $response['message'] = "Invalid Parameters";
      $this->response->type('application/json');
      $this->response->body(json_encode($response));
      return $this->response;
    }
    if (empty($this->request->data['onlinePaymentId']) || empty($this->request->data['onlineSignature'])) {
      $response['success'] = false;
      $response['message'] = "Payment Failed";
      $this->response->type('application/json');
      $this->response->body(json_encode($response));
      return $this->response;
    }
    extract($this->request->data);
    $userId = $this->userId['id'];
    $api = new Api(RAZOR_API_KEY, RAZOR_API_SECRET);
    $attributes = array(
      'razorpay_order_id' => $onlineOrderId,
      'razorpay_payment_id' => $onlinePaymentId,
      'razorpay_signature' => $onlineSignature,
    );
            // try {
            //     $paymentStatus = $api->utility->verifyPaymentSignature($attributes);
            // } catch (SignatureVerificationError $e) {
            //     $success = false;
            //     $response['message'] = "Invalid Signatures";
            //     $this->response->type('application/json');
            //     $this->response->body(json_encode($response));
            //     return $this->response;
            // }
    $razorOrder = $api->order->fetch($onlineOrderId);
    if (!empty($this->request->data['onlinePaymentId']) && $razorOrder->status == 'paid') {
      $order = $this->Transactions->find()->where(['appointment_id' => $appointmentId, 'type' => 'wallet'])->order(['id' => 'DESC'])->first();
      if (!empty($order) && $order['type']=='wallet') {
        try {
          $wallets = $this->Wallets->newEntity();
          $wallets['order_id'] = $appointmentId;
          $wallets['amount_type'] = 'expense';
          $wallets['wallet_id'] = $order->payment_id;
          $wallets['amount'] = $order->amount;
          $wallets['user_id'] = $userId;
          $newWallets = $this->Wallets->save($allets);
        } catch (\PDOException $e) {
          pr($e);die;
        }
        if (!$newWallets) {
          $response['success'] = false;
          $response['message'] = 'Error while saving your order';
          $this->response->type('application/json');
          $this->response->body(json_encode($response));
          return $this->response;
        }
      }
      $order = $this->Appointments->find()->where(['id' => $appointmentId])->first();
      $coupon = $this->Transactions->find()->where(['appointment_id' => $appointmentId, 'type' => 'coupon'])->order(['id' => 'DESC'])->first();
      if ($order['cashback'] != 0 && $order->coupon_id != "") {
        $coupon = $this->Coupons->find()->where(['id' => $order->coupon_id])->first();
        $wallet = $this->Wallets->newEntity();
        $wallet['order_id'] = $order->id;
        $wallet['user_id'] = $this->request->data['userId'];
        $wallet['amount'] = $order->cashback;
        $wallet['is_expiry'] = 1;
        $wallet['coupon_id'] = $order->coupon_id;
        $wallet['amount_type'] = 'promotional';
        $wallet['expiry_date'] = $coupon->cashback_expiry_date;
        $wallet['max_redeem_type'] = $coupon->max_redeem_type;
        $wallet['max_redeem_rate'] = $coupon->max_redeem_rate;
        $this->Wallets->save($wallet);
      }
      $onlineTrans=$this->Transactions->find()->where(['appointment_id' => $appointmentId, 'type' => 'online','razorpay_order_id'=>$onlineOrderId])->order(['id' => 'DESC'])->first();
      $onlineTrans['payment_id'] = $onlinePaymentId;
      $onlineTrans['razorpay_signature'] = $onlineSignature;
      $onlineTrans['amount'] = (INT)($razorOrder->amount_paid) / 100;
      $this->Transactions->save($onlineTrans);
      $order['payment_status'] = "approved";
      $this->Appointments->save($order);
      $this->Carts->deleteAll(['device_id' => $deviceId]);
      $response['success'] = true;
      $response['cartCount'] = 0;
      $response['message'] = 'Order Saved Successfully';
      $this->response->type('application/json');
      $this->response->body(json_encode($response));
      return $this->response;
    }
    $order['transaction_id'] = $payment->id;
    $order['payment_status'] = "rejected";
    if ($this->Appointments->save($order)) {
      $response['success'] = true;
      $this->response->type('application/json');
      $this->response->body(json_encode($response));
      return $this->response;
    }
    $response['success'] = false;
    $response['message'] = "Please try after sometime";
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response;
  } else {
    $response['success'] = false;
    $response['message'] = "Invalid Data Type";
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response;
  }
}



public function products(){
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $category_id = $_POST['categoryId'];
    $response = array();
    $result = $this->Products->find()->where(['status' => 'Y','category_id' => $category_id])->order(['Products.name'=>'ASC'])->toarray();
           // pr($result); die;
    $product = array();
    if (count($result) > 0)
    {
      $response["success"] = true;
      $response["products"] = array();
      foreach($result as $res) {
       $product["id"]=(int)$res['id'];
       $product["name"]=$res['name'];   
       $product["mrp"]=number_format((float)$res['mrp'], 2, '.', '');
       $product["netPrice"]= number_format((float)$res['net_price'], 2, '.', '');
       $product["doctorMargin"]=number_format((float)$res['margin'], 2, '.', '');
       $product["description"]=trim($res['description']);
       if($res['image']){
        $product["image"]=SITE_URL . 'images/products/' . $res['image'];
      }else{
        $product["image"]=SITE_URL . 'images/noimage.png';
      }
      
      array_push($response["products"], $product);
    }
    echo json_encode(($response));
  }else{
    $response["success"] = false;
    $response["message"] = "No products are found.";
    echo json_encode(($response));
  }
}
else
{
 $response["success"] = false;
 $response["message"] = "Invalid method";
 echo json_encode(($response));
}
$this->autoRender=false;                                    
}


 




public function addToCart(){
  if($this->request->is(['post', 'put'])){   
   $userdata['user_id']=$this->userId()['id'];
   $userdata['product_id']=$_POST['productId'];
   $userdata['quantity']=$_POST["quantity"];
   $addon_id = $_POST["addonId"];

   $user = $this->Users->find()->where(['id' => $userdata['user_id']])->first();
   $cart_item_check = $this->Carts->find()->where(['user_id' => $userdata['user_id'],'product_id' => $userdata['product_id'],'product_addon_id' => $addon_id])->first();

   if(count($cart_item_check)>0){
    $data['quantity']=($userdata['quantity'])+$cart_item_check['quantity'];
    if($data['quantity']<=0){
      $this->Carts->deleteAll(['Carts.id' => $cart_item_check['id']]); 
      $response["success"] = true;
      $response["message"] ="Your Item has been deleted Successfully";
      echo json_encode($response); die;
    }
    $data['product_addon_id']=$addon_id;
    $quantity_savepack = $this->Carts->patchEntity($cart_item_check, $data);
    $quantity_results=$this->Carts->save($quantity_savepack);

    $response["success"] = true;
    $response["message"] = "Item successfully added in cart";
    $response["cartItemCount"] =$quantity_results['quantity'];
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response;
  }else{
    $userdata['product_addon_id']=$addon_id;
    $newpack = $this->Carts->newEntity();
    $savepack = $this->Carts->patchEntity($newpack, $userdata);
    $results=$this->Carts->save($savepack);

    if($results)
    {
     $response["success"] = true;
     $response["message"] ="Your Cart updated Successfully";
     $response["cartItemCount"] =$results['quantity'];
   }
 }
}else{
 $response["success"] = false;
 $response["message"] = "Invalid method";
}
echo json_encode($response); die;
}

public function slots(){
  $this->loadModel('SlotsDay');

  $response["success"] = true;

  $current_date = date('d-M');
  $next_date = date('d-M', strtotime(' +1 day'));
  for($i=0; $i<=6; $i++){
    $slot_data_name =date('l',strtotime("$i day"));
 
    $slots= $this->SlotsDay->find('all')->where(['slots_day_english'=>$slot_data_name])->first(); 
    $slot_data['id']=$slots['id'];
    $slot_data['day']=$slots['slots_day_hindi'];
    if($current_date == date('d-M',strtotime("$i day"))){
      $slot_data['date']="आज"; 
    }else if($next_date  == date('d-M',strtotime("$i day"))){
      $slot_data['date']="कल";
    }else{
      $slot_data['date']=date('d-M',strtotime("$i day"));
    }
  
    $slotreult[] = $slot_data; 
    
    }

    $response["slots"]=$slotreult;
    echo json_encode(($response)); die;
}

public function viewCart(){
  $this->loadModel('ProductImages');
  $this->loadModel('ProductAddons');
  
  $uid = $this->userId()['id'];
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   $response = array();
   $result = $this->Carts->find()->contain(['Products','ProductAddons','ProductImages'])->where(['user_id'=>$uid])->order(['Carts.id'=>'desc'])->toarray();
   //pr($result); die;
  // $products_images = $this->carts->find()->where(['image' => $product['id']])->toarray();
   $admin_state_id = $this->Users->find()->where(['id'=>'1'])->first();
   $user_state_id = $this->Users->find()->where(['id'=>$uid])->first();
   $product = array();
   if (count($result) > 0)
    {   $sum = 0;
      $total_quantity = 0;
      $total_price = 0;

      $response["success"] = true;
      foreach($result as $res) {
        $product["id"]=$res['product']['id'];
        $product["name"]=$res['product']['name'];
        $product['brandName'] =  $res['product']['brand_name'];   
        $product['description'] =  $res['product']['description'];       
        $product["featuredImage"]=!empty($res['product_image']['image']) ? SITE_URL . 'images/product_images/' . $res['product_image']['image'] : null;

        $products_images = $this->ProductImages->find()->where(['product_id' => $res['product']['id']])->toarray();    
        $products_addons = $this->ProductAddons->find()->where(['product_id' => $res['product']['id']])->toarray(); 

    foreach($products_images as $image){
      $product['productImage'][] =  SITE_URL . 'images/product_images/'.$image['image'];
    }
    
    foreach($products_addons as $addons){
      $addons_data['id'] =  $addons['id'];
      $addons_data['name'] =  $addons['name']." Kg";
      $addons_data['price'] =  $addons['price'];
      $product['productAddons'][] =  $addons_data; 
    }

    $product["quantity"]=(int)$res['quantity'];
    $total_quantity += $res['quantity'];
    $product["addOnId"]=(int)$res['product_addon']['id'];
    $product["addOnWeight"]=(int)$res['product_addon']['name'];
    $product["addOnprice"]=(int)$res['product_addon']['price']*$res['quantity'];
    $total_price += $res['product_addon']['price']*$res['quantity'];
        $result1[]=$product;
      }
      $body["productInfo"]=$result1;
      $body["totalQuantity"]=$total_quantity;
      $body["subtotal"]=number_format((float)$total_price, 2, '.', '');
      $body["discount"]=0;
      $body["deliveryCharges"]=0;
      $body["totalAmount"]= number_format((float)$total_price, 2, '.', '');
      $response["cartDetail"]=$body;
      echo json_encode(($response));
    }else{
     $response["success"] = false;
     $response["message"] = "Unfortunately Your Cart Is Empty Go Back And Add New Item";
     echo json_encode(($response));
   }
 }else{
  $response["success"] = false;
  $response["message"] = "Ivalid Method";
  echo json_encode(($response));
}
$this->autoRender=false;                                    
}

public function userAddresses()
{
  $this->loadModel('UserAddresses');
  $this->loadModel('Users');
  $this->autoRender = false;
    if ($this->request->is('post')) {   
      $user_id = $this->userId()['id']; 
      //requesting the data from table
      $useradd['user_id']=$this->userId()['id'];      //fetching id from address table using relation
      $useradd['address']=$_POST['address'];      // address called using POST method.
      $useradd['address_type']=$_POST['address_type'];      // address type called using POST method.
      $useradd['name']=$_POST['name'];      // name called using POST method.
      $useradd['is_permanent']=$_POST['is_permanent'];  
      //pr($useradd); die;
      
      $response = array();  
      if (empty($this->request->getData()['address']))  
      {
        $response['success'] = false;
        $response['message'] = "Invalid Parameters";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      extract($this->request->getData());   //requesting the data from the data base and now can be seen by calling just variables
      //pr($address); die;
      $user = $this->UserAddresses->newEntity();  // connecting to data base if new data added should be added in user addresses table
      $user['user_id']=$user_id; 
      $user['address']=$address; 
      $user['address_type']=$address_type; 
      $user['name']=$name; 
      $user['is_permanent']=$is_permanent; 
      //pr($user); die;
      $user['status']=1;
          if($this->UserAddresses->save($user)){    //if all the above fields are filled and satisfied the data themn it will save the data is database table
            $response['success']=true;
            $response['message']="Address saved successfully";
          //pr($response); die;
          echo json_encode($response);
          return;
          }
    
          $address_update = $this->UserAddresses->find()->where(['user_id' => $user_id,'id !=' => $address_results['id']])->toarray();
          $status['is_permanent']= 'N';
          foreach($address_update as $value){
              $result = $this->UserAddresses->patchEntity($value, $status);    
              $address_result=$this->UserAddresses->save($result);
          }
  }
  else {
    $response['success'] = false;
    $response['message'] = "Invalid Data Type";
    echo json_encode($response);
    return;
  }
}


public function viewAddress(){
  $this->loadModel('UserAddresses');
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
 
    $response = array();
    $user_id = $this->userId()['id'];
    $result = $this->UserAddresses->find()->where(['user_id' => $user_id])->toarray();
    $product = array();
    if (count($result) > 0)
    {
      $response["success"] = true;
      $response["useraddress"] = array();
      foreach($result as $res) {
       $product["id"]=(int)$res['id'];
       $product["address"]=$res['address'];   
       $product["address_type"]=$res['address_type'];   
       $product["name"]=$res['name'];   
       $product["is_permanent"]=$res['is_permanent'];   
      
      array_push($response["useraddress"], $product);
    }
    echo json_encode(($response));
  }else{
    $response["success"] = false;
    $response["message"] = "No useraddress are found.";
    echo json_encode(($response));
  }
}
else
{
 $response["success"] = false;
 $response["message"] = "Invalid method";
 echo json_encode(($response));
}
$this->autoRender=false;                                    
}


// public function viewAddress()
// {
//   $this->loadModel('UserAddresses');
//   $this->loadModel('Users');
//  // $this->autoRender = false;
//   $response = array();
// //pr($response); die;
//           if ($_SERVER['REQUEST_METHOD'] === 'GET') {
//            $user_id = $this->userId()['id'];
//            $result = $this->UserAddresses->find()->where(['user_id' => $user_id])->toarray();
//            pr($result); die;
//            $user = array();
//            if (count($result) > 0)
//            {  
//             $response["success"] = true;
//             $user["address"]=$user['address'];
//            // $user["mobile"]=$result['mobile'];
             
//             $response["userAddresses"] = $user;  //pr($user); die;
//             echo json_encode(($response));
//           }
//           else
//           {
//             $response["success"] = false;
//             $response["message"] = "Address Not Found";
//             echo json_encode(($response));
//           }
//         }
//         else
//         {
//          $response["success"] = false;
//          $response["message"] = "Ivalid Method";
//          echo json_encode(($response));
//        }
//      }
     

     public function deleteAddress(){
      $this->loadModel('UserAddresses');
      $this->loadModel('Users');
      $this->autoRender = false;
      $response = array();
      $userid = $this->userId()['id'];
      $pid = $_POST['id']; 
      //pr($pid); die;
      $addressdel = $this->UserAddresses->deleteAll(['id' => $pid]);
  //pr($addressdel); die;
      $response["success"] = true;
      $response["message"] = "Address item removed successfully";
      echo json_encode(($response));
    
    }


    public function inviteFriend(){
      $userid = $this->userId()['id']; 
      if ($_SERVER['REQUEST_METHOD'] === 'GET') {
          $response = array();
          $usercheck = $this->Users->find()->where(['id'=>$userid])->toarray(); 
      if(count($usercheck) > 0){
          $response['success'] = true;
          $response['output'] = [];
          $response['output']['referralCode'] = null;
          $response['output']['referralAmount'] = null;
          $response['output']['shareInfo']['title'] = "Gaouri Brand";
          $response['output']['shareInfo']['message'] = "I am using Using Gaouri Brand App for best fodder fro my cattles kindly download and be improve your cattles nutrition";
          $response['output']['shareInfo']['androidUrl'] = "https://play.google.com/store/apps/details?id=com.doomshell.docguard";
          $response['output']['shareInfo']['iosUrl'] = "https://play.google.com/store/apps/details?id=com.doomshell.docguard";
  
          $response['output']['shareInfo']['image']['url'] = SITE_URL."images//logo_1.png";
          $response['output']['shareInfo']['image']['extension'] = "png";
          $this->response->type('application/json');
          $this->response->body(json_encode($response));
          return $this->response;
          }
      else{
          $response["success"] = false;
          $response["message"] = "Invalid User";
          echo json_encode(($response));
      }
      }
      else
      {
          $response["success"] = false;
          $response["message"] = "Invalid method";
          echo json_encode(($response));
      }
      $this->autoRender=false;									
  }
  





     
// public function addy()
//  {
//   $this->autoRender = false;
//   if ($this->request->is('post')) { 
//     $useradd['user_id']=$this->userId()['id'];
//    $useraddd['address']=$_POST['address'];
//     $response = array();
//     if (empty($this->request->getData()['user_id']) || empty($this->request->getData()['address']))  
//     {
//       $response['success'] = false;
//       $response['message'] = "Invalid Parameters";
//       $this->response->type('application/json');
//       $this->response->body(json_encode($response));
//       return $this->response;
//     }
//     extract($this->request->getData());
//             //pr($name); die;
//    // $mobileExist = $this->Users->exists(['OR'=>[['mobile'=>$mobile]], 'status' => 1]);
//     // if ($mobileExist) {
//     //   $response['success'] = false;
//     //   $response['message'] = "Mobile Number already Exist";
//     //   $this->response->type('application/json');
//     //   $this->response->body(json_encode($response));
//     //   return $this->response;
//     // }
//     $user = $this->userAddresses->newEntity();
//     $user['user_id'] = $user_id;
//     $user['address'] = $address;
//     // $user['villagename'] = $villageName;
//     // $user['mobile'] = $mobile;
//     // $user['animalCount'] = $animalCount;
//     // $user['milkQuantity'] = $milkQuantity;
//     // $user['email'] = $email;
//     $user['status'] = 1;
//             // $user['otp'] = 1234; //rand(1001, 9999);
//             // $user['role_id'] = 3;
            
//             if ($this->userAddresses->save($user)) {
//                // pr($user); die;
//               $response['success'] = true;
//                 //   $message = "OTP for Nusearch Pharma Registration is " . $user['otp'];
//                 //  $smsUrl = "http://alerts.prioritysms.com/api/web2sms.php?workingkey=Adbefca5cdb1c4ca5fe96bd90a639602c&to=" . trim($user['mobile']) . "&sender=PRIRTY&message=" . $message;
//                 //   $sendmsg =  file_get_contents($smsUrl);
//               $response['message'] = "Address saved Successfully";
//               $this->response->type('application/json');
//               $this->response->body(json_encode($response));
//               return $this->response;
//             }
//           } else {
//             $response['success'] = false;
//             $response['message'] = "Invalid Data Type";
//             echo json_encode($response);
//             return;
//           }
//         }


public function orderCart(){
  //echo "test"; die;
  $uid = $this->userId()['id'];
  $this->loadModel('UserAddresses');
  $this->loadModel('Users');
  extract($this->request->getData());
  $address = $this->UserAddresses->find()->where(['id'=>$addressId])->first();
  $user_address = $address['address'];
    //pr($user_address); die;

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $response = array();
  $result = $this->Carts->find()->contain(['Products','ProductAddons'])->where(['user_id'=>$uid])->toarray();
  //pr($result); die;
   $product = array();
   if (count($result) > 0){   
      $total_amount = 0;
      $total_quantity = 0;
      
      $response["success"] = true;
      foreach($result as $res) {
        $total_amount += number_format((float)$res['product_addon']['price'], 2, '.', '')*$res['quantity'];
        $total_quantity += $res['quantity'];
      }

     

      $order['user_id'] = $uid; 
      $order['sub_total'] = $total_amount;
      $order['total_amount'] = $total_amount;
      $order['slot_id'] = $slotId;
      $order['billng_address'] = $user_address;

      $newpack = $this->Orders->newEntity();
      $order_savepack = $this->Orders->patchEntity($newpack, $order);
      $order_result=$this->Orders->save($order_savepack);

      if($order_result){
        foreach($result as $res) {
          $orderDetail['user_id']=$uid;
          $orderDetail['order_id']=$order_result['id'];
          $orderDetail['product_id']=$res['product']['id'];
          $orderDetail['quantity']=$res['quantity'];
          $orderDetail['product_price']=$res['product_addon']['price'];
          $orderDetail['total_price']=$res['product_addon']['price']*$res['quantity'];
          $orderDetail['weight']=$res['product_addon']['name'];
          $newpack1 = $this->OrderDetails->newEntity();
          $orderdetail_savepack = $this->OrderDetails->patchEntity($newpack1, $orderDetail);
          $orderdetail_result=$this->OrderDetails->save($orderdetail_savepack);
        }
        $this->Carts->deleteAll(['user_id' => $uid]);
      }

      $response["success"] = true;
      $response["message"] = "Your booking has been successfully created";
      $userinfo["orderId"]= (int)$order_result['id'];
      $userinfo["amount"]= number_format((float)$order_result->total_amount, 2, '.', '');
      $response['orderInfo'] =$userinfo;
      echo json_encode(($response));
    }
    else
    {
     $response["success"] = false;
     $response["message"] = "Unfortunately Your Cart Is Empty Go Back And Add New Item";
     echo json_encode(($response));
   }
 }
 else
 {
  $response["success"] = false;
  $response["message"] = "Ivalid Method";
  echo json_encode(($response));
}
$this->autoRender=false;                              
}


public function orderDetail(){
  $user_id = $this->userId()['id']; 
  $this->loadModel('Slots');
  $this->loadModel('SlotsDay');
  $order = $this->Orders->find()->where(['user_id'=>$user_id])->order(['Orders.id'=>'desc'])->toarray();

 
  if(count($order)>0){
    foreach($order as $value){
      $slot_info = $this->Slots->find()->contain(['SlotsDay'])->where(['Slots.id'=>$value['slot_id']])->first();
      //pr($slot_info['slots_day'][0]['slots_day_hindi']); die;
      $orderdata['orderId'] = (int)$value['id'];
      $orderdata['orderDate'] = date('d-m-Y',strtotime($value['order_date']));
      $orderdata['orderStartTime'] = date('h:i',strtotime($slot_info['mintime']));
      $orderdata['orderEndTime'] = date('h:i',strtotime($slot_info['maxtime']));
      $orderdata['orderDay'] = $slot_info['slots_day']['slots_day_hindi'];
      $orderdata['status'] = $value['order_status'];
      $orderdata['billing_address'] = $value['billng_address'];
      $orderdata['totalAmount'] = number_format((float)$value['total_amount'], 2, '.', '');
      
      $cat_products = array();
      $orderdetails = $this->OrderDetails->find()->contain(['Products'])->where(['order_id'=>$value['id']])->toarray();
      foreach ($orderdetails as $values) {
        $data['productName'] = $values['product']['name'];
        $data['productPrice'] = number_format((float)$values['product_price'], 2, '.', '');
        $data['quantity'] = $values['quantity'];
        $data['weight'] = $values['weight'];
        $data['totalProductAmount'] = number_format((float)$values['total_price'], 2, '.', '');
        $cat_products[] = $data;
      }
      if($cat_products){

        $orderdata['product'] = $cat_products;
      }else{
        $orderdata['product'] = null;
      }
      $categories[] = $orderdata;
    }
    if($orderdata)
    {
      $body['success'] =true; 
      $body['Orders'] = $categories;
    }
  }
  else
  {
    $body['success'] =false; 
    $body['message'] ="No Order"; 
  }
  echo json_encode($body); die;
}

public function getNotificationCount(){
  $this->autoRender=false;
  $response = array();
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $userid = $this->userId()['id']; 
    $result = $this->Users->find()->where(['id'=>$userid])->first(); 
    if (count($result) > 0)
    { 
      $response["success"] = true;
      $response["notificationCount"]=(int)$result['notification_counter']; 
      echo json_encode(($response));
    }
    else
    {
      $response["success"] = false;
      $response["message"] = "Notification Not Found";
      echo json_encode(($response));
    }
  }
  else
  {
    $response["success"] = false;
    $response["message"] = "Ivalid Method";
    echo json_encode(($response));
  }
}

public function resetNotificationCount(){
  $this->autoRender=false;
  $response = array();
  $userid = $this->userId()['id']; 
  $usercheck = $this->Users->find()->where(['id'=>$userid])->first(); 

  if (count($usercheck) > 0) {
    $data['notification_counter']=0;
    $savepack = $this->Users->patchEntity($usercheck, $data);
    $result=$this->Users->save($savepack);

    $response["success"] = true;
    $response["message"] ="Notification count reseted successfully";
    echo json_encode(($response));
  }
  else
  {
    $response["success"] = false;
    $response["message"] = "User does not exist";
    echo json_encode(($response));
  }
}

// for invite friend 


public function cartCount(){
  $this->autoRender=false;
  $response = array();
  $userid = $this->userId()['id']; 
  $cartCount = $this->Carts->find()->select(['sum' => 'SUM(Carts.quantity)'])->where(['user_id' => $userid])->first();

  $response["success"] = true;
  $response["cartCount"] = (int)$cartCount['sum'];
  echo json_encode(($response));

}

public function deleteCart(){
  $this->autoRender=false;
  $response = array();
  $userid = $this->userId()['id']; 
  $pid = $_POST['productId']; 
  $cartCount = $this->Carts->deleteAll(['product_id' => $pid,'user_id' => $userid]);
  $cartCount = $this->Carts->find()->select(['sum' => 'SUM(Carts.quantity)'])->where(['user_id' => $userid])->first();
  $response["success"] = true;
  $response["message"] = "Cart item removed successfully";
  echo json_encode(($response));

}

public function send_email($to,$customer_mail,$message,$subject)
{
  $this->loadModel('Users');
  $admin_data=$this->Users->find('all')->where(['Users.role_id'=>'1'])->first();
  $mail = new \PHPMailer(True);
  $mail->isSMTP();
  // $mail->SMTPDebug = \SMTP::DEBUG_SERVER;
  $mail->Host ='smtp.zoho.in';
  $mail->SMTPAuth = true;
  $mail->Username = 'info@nusearchpharma.com';
  $mail->Password = 'Doom#123';
  $mail->SMTPSecure = \PHPMailer::ENCRYPTION_STARTTLS; 
//  $mail->tls = true;
  $mail->Port       = 587; 
  $mail->From = $admin_data['email'];
  $mail->FromName = 'Nusearch Pharma';
  $mail->addAddress($to);
  $mail->addCC($customer_mail);
  $mail->isHTML(true);
  $mail->Subject = $subject;
  $mail->Body    =  $message;
  if(!$mail->send()) {
    echo "helmjlo"; die;
    return 0;
  }
  return 1;
//   exit;

}


}
