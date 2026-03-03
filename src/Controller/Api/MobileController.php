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
require '../vendor/geometry-library/PolyUtil.php';
include '../vendor/autoload.php';
include 'phpqrcode/qrlib.php';



// include '../vendor/rncryptor/rncryptor/src/RNCryptor/Decryptor.php';

class MobileController extends AppController
{

  public function beforeFilter(Event $event)
  {
    // echo "test"; die;
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
    $this->loadModel('OrderDetails');
    $this->loadModel('Referral');
  }

  public function initialize()
  {
    parent::initialize();
    $this->Auth->allow(['registration', 'loginOtpVerify', 'loginOtpVerify2', 'prepareRequestBody', 'registrationOtpVerify', 'login', 'resendOtp', 'contactInformation', 'home', 'faqCategories', 'faqQuestion', 'couponsList', 'uploadToken', 'uploadToken2', 'checkreferralcode', 'enterReferralCoderegistration', 'contactUs', 'privacyPolicy', 'termsAndConditions', 'getLocations', 'versioncheck']);
  }


  public function file_get_contents_curl($url)
  {
    // $url="https://alerts.prioritysms.com/api/web2sms.php?workingkey=Abee8ed4a5be3d950b0ad01a69920fe58&to=8619561663&sender=JVARUN&message=OTP for your Gouribrand Account is 1234. Varun Trading Company";
    // $url="https://www.google.com/";
    //echo $url; die;
    // $ch = curl_init();
    // curl_setopt($ch, CURLOPT_HEADER, 0);
    // curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    // curl_setopt($ch, CURLOPT_URL, $url);
    // $data = curl_exec($ch);

    $ch = curl_init($url);
    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    // Execute cURL session and capture the response
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
  }



  public function get_loaction($lat, $long)
  {
    $latitude = $lat;
    $longitude = $long;
    $geolocation = $latitude . ',' . $longitude;

    $request = 'https://maps.googleapis.com/maps/api/geocode/json?latlng=' . $geolocation . '&sensor=false&key=AIzaSyC27M5hfywTEJa5_l-g0KHWe8m8lxu-rSI';
    // pr($request);exit;
    //pr($request); die;
    //$file_contents = file_get_contents($request);

    // $mesg = "DAAC test your OTP is 1234";
    // $sms='http://alerts.prioritysms.com/api/web2sms.php?workingkey=A2960bddf6f159a76d113973b6831bf79&to='.trim(8619561663).'&sender=DAACIN&message='.urlencode($mesg);
    // $result = $this->file_get_contents_curl($sms);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $request);
    $file_contents = curl_exec($ch);
    curl_close($ch);

    //return $data;

    $location_data = json_decode($file_contents);

    $explode_location = explode(",", $location_data->results[0]->formatted_address);

    return implode(",", $explode_location);

    // return  $explode_location[array_key_last($explode_location)];
  }

  public $helpers = ['CakeJs.Js'];

  public function _setPassword($password)
  {
    return (new DefaultPasswordHasher)->hash($password);
  }

  public function random_strings($length_of_string)
  {

    // String of all alphanumeric character
    $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    // Shufle the $str_result and returns substring
    // of specified length
    return substr(
      str_shuffle($str_result),
      0,
      $length_of_string
    );
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

  public function sendmsg($mobile, $msg)
  {

    $curl = curl_init();
    $mobil = "91" . $mobile;
    $msgs = $msg;

    $url = 'http://107.20.199.106/sms/1/text/query?username=veggie&password=Veggie302019&to=' . $mobil . '&text=' . urlencode($msgs);
    //pr($url); die;
    curl_setopt_array(
      $curl,
      array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "accept: application/json"
        ),
      )
    );

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
      echo "cURL Error #:" . $err;
      die;
    }
  }

  public function checkreferralcode($referal_code_data)
  {
    $this->autoRender = false;
    $referreduser = $this->Users->find()->where(['referral_code' => $referal_code_data, 'status' => '1'])->first();
    if (empty($referreduser)) {
      //echo "test"; die;
      $response['success'] = false;
      $response['message'] = "अमान्य रेफरल कोड";
      echo json_encode($response);
      die;
    }
  }

  public function enterReferralCoderegistration($referal_code_data = null, $userId)
  {
    $this->autoRender = false;
    $this->loadModel('Wallets');
    if ($this->request->is('post')) {
      $response = array();
      if ($referal_code_data) {
        $referal_code = $referal_code_data;
      } else {
        $referal_code = $this->request->data['referralCode'];
      }
      if (empty($referal_code)) {
        $response['success'] = false;
        $response['message'] = "Invalid Parameters";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }


      $referreduser = $this->Users->find()->where(['referral_code' => $referal_code_data, 'status' => '1'])->first();
      //pr($referreduser); die;
      if (empty($referreduser) || $referreduser->id == $userId) {
        $response['success'] = false;
        $response['message'] = "अमान्य रेफरल कोड
        ";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $user = $this->Users->find()->where(['id' => $userId])->first();
      if (empty($user)) {
        $response['success'] = false;
        $response['message'] = "अमान्य उपयोगकर्ता";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }

      $referralReward = $this->Users->find()->where(['role_id' => 1])->first()->referred_reward;
      $user->referred_user_id = $referreduser->id;
      $user->referred_reward = $referralReward;

      if ($this->Users->save($user)) {
        if (!empty($referreduser) && $referreduser->id != $userId) {
          $referreduser->referred_reward = $referralReward;
          $this->Users->save($referreduser);
        }

        $response['success'] = true;
        $response['message'] = "रेफ़रल कोड सफलतापूर्वक सहेजा गया";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $response['success'] = false;
      $response['message'] = "Error while saving Code, Please try after some times";
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


  public function registration()
  {
    $this->autoRender = false;
    if ($this->request->is('post')) {
      $response = array();
      if (empty($this->request->getData()['name']) || empty($this->request->getData()['address']) || empty($this->request->getData()['villageName']) || empty($this->request->getData()['mobile']) || empty($this->request->getData()['animalCount']) || empty($this->request->getData()['milkQuantity'])) {
        $response['success'] = false;
        $response['message'] = "Invalid Parameters";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }

      if (empty($this->request->getData()['locationId'])) {
        $response['success'] = false;
        $response['message'] = "कृपया अपना ऐप अपडेट करें!";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }

      extract($this->request->getData());

      $User_referral_Exist = $this->Referral->find()->contain(['Users'])->where(['Referral.mobile_no' => $mobile])->first();
      // pr($User_referral_Exist); die;
      $mobileExist = $this->Users->exists(['OR' => [['mobile' => $mobile]], 'status' => 1]);
      if ($mobileExist) {
        $response['success'] = false;
        $response['message'] = "मोबाइल नंबर पहले से मौजूद है";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $user = $this->Users->newEntity();
      $user['name'] = $name;
      $user['address'] = $address;
      $user['villagename'] = $villageName;
      $user['location_id'] = $locationId;
      $user['mobile'] = $mobile;
      $user['animalCount'] = $animalCount;
      $user['milkQuantity'] = $milkQuantity;
      $user['email'] = $email;
      //$user['device_id'] = $this->request->data['deviceId'];
      // $user['referral_code'] =  random_int(100000, 999999);
      if ($User_referral_Exist['user']['referral_code']) {
        $this->request->data['referralCode'] = $User_referral_Exist['user']['referral_code'];
      }


      $user['referral_code'] = random_int(100000, 999999);
      if (!empty($this->request->data['referralCode'])) {
        $this->checkreferralcode($this->request->data['referralCode']);
      }



      $user['status'] = 1;
      $user['otp'] = rand(1001, 9999);
      $user['role_id'] = 3;
      // pr($user);exit;
      if ($user_data = $this->Users->save($user)) {
        // pr($user); die;
        if (!empty($this->request->data['referralCode'])) {
          $this->enterReferralCoderegistration($this->request->data['referralCode'], $user_data['id']);
        }

        $response['success'] = true;
        //   $message = "OTP for Nusearch Pharma Registration is " . $user['otp'];
        //  $smsUrl = "http://alerts.prioritysms.com/api/web2sms.php?workingkey=Adbefca5cdb1c4ca5fe96bd90a639602c&to=" . trim($user['mobile']) . "&sender=PRIRTY&message=" . $message;
        //   $sendmsg =  file_get_contents($smsUrl);
        $response['message'] = "आपने सफलतापूर्वक पंजीकरण कर लिया है";
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
    // echo "test";die;
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
      $verifiedUser = $this->Users->find('all')->where(['mobile' => $this->request->getData()['mobile'], 'role_id' => "3"])->order(['id' => 'DESC'])->first();
      if (empty($verifiedUser)) {
        $response['success'] = false;
        $response['message'] = "यह उपयोगकर्ता पंजीकृत नहीं है";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      if ($verifiedUser->status != 1) {

        $response['success'] = false;
        $response['message'] = "खाता वर्तमान में निष्क्रिय है";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $response = array();
      $response['success'] = true;

      if ($verifiedUser->id == 2760) {
        $verifiedUser['otp'] = 1234;
      } else {
        $verifiedUser['otp'] = rand(1001, 9999);
      }
      // $verifiedUser['otp'] = 1234;
      // if ($verifiedUser) {
      //   $verifiedUser['device_id'] = $this->request->data['deviceId'];
      //   //$verfied_user['location'] = $this->request->data['location'];
      //   $this->Users->save($verifiedUser);
      // }

      $this->Users->save($verifiedUser);
      // pr($verifiedUser['otp']); die;
      // echo "test"; die;
      // $message = "OTP for your Gouribrand Account is " . $verifiedUser['otp'] . ". Varun Trading Company";
      // $message = urlencode($message);
      // $smsUrl = "https://alerts.prioritysms.com/api/web2sms.php?workingkey=Abee8ed4a5be3d950b0ad01a69920fe58&to=" . trim($verifiedUser['mobile']) . "&sender=JVARUN&message=" . $message;

      $smsUrl = "https://panel.sms.gen.in/fe/api/v1/send?"
        . "username=gouribrand.trans"
        . "&password=Gour@2024M"
        . "&unicode=false"
        . "&from=JVARUN"
        . "&to=" . trim($verifiedUser['mobile'])
        . "&dltPrincipalEntityId=1601392164257237695"
        . "&dltContentId=1607100000000188416"
        . "&text=" . urlencode("OTP for your Gouribrand Account is " . $verifiedUser['otp'] . ". Varun Trading Company");

      // echo $smsUrl; die;
      $sendmsg = $this->file_get_contents_curl($smsUrl);
      // pr($sendmsg); die;

      $response['message'] = "पंजीकृत नंबर पर ओटीपी सफलतापूर्वक भेज दिया गया है";
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
        $response['message'] = "ओटीपी अमान्य है";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $data = array();
      $response = array();
      $response['success'] = true;
      $response['message'] = 'ओटीपी सफलतापूर्वक सत्यापित हो गया';
      $response['userInfo']['id'] = $verifiedUser['id'];
      $response['userInfo']['role'] = 'Customer';

      $response['userInfo']['authToken'] = JWT::encode(
        [
          'sub' => $verifiedUser['id'],
          'exp' => time() + 2592000,
        ],
        Security::salt()
      );

      $udata['token'] = $response['userInfo']['authToken'];
      $usavepack = $this->Users->patchEntity($verifiedUser, $udata);
      $uresult = $this->Users->save($usavepack);
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


  public function loginOtpVerify2()
  {
    $this->loadModel('Devices');
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
        $response['message'] = "ओटीपी अमान्य है";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $data = array();
      $response = array();
      $response['success'] = true;
      $response['message'] = 'ओटीपी सफलतापूर्वक सत्यापित हो गया';
      $response['userInfo']['id'] = $verifiedUser['id'];
      $response['userInfo']['role'] = 'Customer';

      $response['userInfo']['authToken'] = JWT::encode(
        [
          'sub' => $verifiedUser['id'],
          'exp' => time() + 2592000,
        ],
        Security::salt()
      );

      $device_id = $this->request->data['deviceId'];

      if ($device_id) {
        $checkdeviced = $this->Devices->find('all')->where(['Devices.device_id' => $device_id])->first();
        if (empty($checkdeviced)) {
          $newentity['device_id'] = $device_id;
          $userDevice = $this->Devices->patchEntity($this->Device->newEntity(), $newentity);
          if ($device = $this->Devices->save($userDevice)) {
            $lstid = $device->id;
          }
        } else {
          $lstid = $checkdeviced['id'];
        }
        $udata['device_id'] = $lstid;
      }

      $udata['token'] = $response['userInfo']['authToken'];
      $usavepack = $this->Users->patchEntity($verifiedUser, $udata);
      $uresult = $this->Users->save($usavepack);

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
        $response['message'] = "यह मोबाइल नंबर पंजीकृत नहीं है";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $verifiedUser['otp'] = rand(1001, 9999);
      //$verifiedUser['otp'] = 1234;
      $this->Users->save($verifiedUser);

      // $message = "OTP for your Gouribrand Account is " . $verifiedUser['otp'] . ". Varun Trading Company";
      // $message = urlencode($message);

      // $smsUrl = "https://alerts.prioritysms.com/api/web2sms.php?workingkey=Abee8ed4a5be3d950b0ad01a69920fe58&to=" . trim($verifiedUser['mobile']) . "&sender=JVARUN&message=" . $message;

      $smsUrl = "https://panel.sms.gen.in/fe/api/v1/send?"
        . "username=gouribrand.trans"
        . "&password=Gour@2024M"
        . "&unicode=false"
        . "&from=JVARUN"
        . "&to=" . trim($verifiedUser['mobile'])
        . "&dltPrincipalEntityId=1601392164257237695"
        . "&dltContentId=1607100000000188416"
        . "&text=" . urlencode("OTP for your Gouribrand Account is " . $verifiedUser['otp'] . ". Varun Trading Company");
      $sendmsg = $this->file_get_contents_curl($smsUrl);
      //  $sendmsg =  file_get_contents($smsUrl);
      $response['success'] = true;
      $response['message'] = "पंजीकृत नंबर पर ओटीपी सफलतापूर्वक पुनः भेज दिया गया है।";
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

      $response['message'] = "टोकन सफलतापूर्वक अपडेट कर दिया गया है";
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


  public function uploadToken2()
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
      // pr($newDevice);die;
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

      $response['message'] = "टोकन सफलतापूर्वक अपडेट कर दिया गया है";
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


  function versioncheck()
  {
    $this->autoRender = false;
    // if ($this->request->is('post')) {
    //   $build_no = $this->request->data['build_no'];
    //   $token = $this->request->data['token'];

    //   try {
    //     $decoded = JWT::decode($token, Security::salt(), ['HS256']);
    //     $userId = $decoded->sub;
    //     $expirationTime = $decoded->exp;

    //     $findbuild = $this->Users->find()->where(['id' => $userId])->first();
    //     $findbuild['build_no'] = $build_no;
    //     $this->Users->save($findbuild);

    //     $response = array();
    //     $response['success'] = true;
    //     $this->response->type('application/json');
    //     $this->response->body(json_encode($response));
    //     return $this->response;
    //     return $this->response;
    //   } catch (\Exception $e) {
    //     echo "Error: " . $e->getMessage();
    //   }
    // }

    $findbuild = $this->Users->find()->where(['role_id' => 1])->first();

    if ($this->request->is('post')) {
      $build_no = $this->request->data['build_no'];
      $response = array();
      if ($findbuild['build_no'] == $build_no) {
        $response['success'] = true;
        $response['app_url'] = null;
        $response['message'] = 'Build No. Match';
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
        return $this->response;
      } else {
        $response['success'] = false;
        $response['app_url'] = 'https://play.google.com/store/apps/details?id=com.doomshell.gaouribrand&hl=en-IN';
        $response['message'] = 'एक अतिआवश्यक अपडेट किया गया है कृपया अपडेट करे जारी रखने के लिए..';
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
        return $this->response;
      }
    }
  }

  public function notifications()
  {
    $this->autoRender = false;
    $response = array();
    $userId = $this->userId()['id'];
    $role_id = $this->userId()['role_id'];
    // echo $userId; die;

    $notifications = $this->Notifications->find()->where(['OR' => [['user_id' => 0], ['user_id' => $userId]], 'status' => 1], ['OR' => [['role_id' => 0], ['role_id' => $role_id]], 'status' => 1])->order(['Notifications.id' => 'DESC'])->toarray();

    if (!empty($notifications)) {
      $response['success'] = true;
      foreach ($notifications as $notification) {
        $data = [];
        $data = ['userId' => $notification['user_id'], 'title' => $notification['title'], 'message' => $notification['message'], 'date' => date('d M,y', strtotime($notification['created']))];
        $response['notifications'][] = $data;
      }
    } else {
      $response['success'] = false;
      $response['message'] = "आपके पास कोई सूचना नहीं है";
    }
    $this->response->type('application/json');
    $this->response->body(json_encode($response));
    return $this->response;
  }

  public function termsAndConditions()
  {
    $this->autoRender = false;
    $response['success'] = true;
    $this->loadModel('Static');
    $policy = $this->Static->find()->where(['slug' => 'terms-and-conditions'])->first();
    //pr($policy); die;
    $response['description'] = $policy['content'];
    echo json_encode($response);
    return;
  }
  public function privacyPolicy()
  {
    $this->autoRender = false;
    $this->loadModel('Static');
    $policy = $this->Static->find()->where(['slug' => 'privacy-policy'])->first();
    $response['success'] = true;
    $response['description'] = $policy['content'];
    echo json_encode($response);
    return;
  }
  public function contactUs()
  {
    $this->autoRender = false;
    $response['success'] = true;
    $this->loadModel('Static');
    $policy = $this->Static->find()->where(['slug' => 'contact-us'])->first();
    $response['description'] = $policy['content'];
    echo json_encode($response);
    return;
  }

  // public function QRCodeGenerator($user_id, $URL)
  // {

  //   $dirname = 'temp';
  //   $PNG_TEMP_DIR = WWW_ROOT . 'QRImages' . DS . $dirname . DS;
  //   //$PNG_WEB_DIR = 'temp/';
  //   if (!file_exists($PNG_TEMP_DIR))
  //     mkdir($PNG_TEMP_DIR);
  //   $filename = $PNG_TEMP_DIR . 'GB.png';
  //   $name = $user_id . "," . $URL;

  //   $errorCorrectionLevel = 'M';
  //   $matrixPointSize = 4;

  //   $filename = $PNG_TEMP_DIR . 'GB' . md5($name . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
  //   // pr($filename);exit;
  //   \QRcode::png($name, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
  //   //display generated file
  //   $qrimagename = basename($filename);
  //   // pr($qrimagename);
  //   // exit;
  //   return $qrimagename;
  // }

  // public function viewProfile()
  // {

  //   $this->loadmodel('User');
  //   $this->autoRender = false;
  //   $response = array();
  //   if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  //     $user_id = $this->userId()['id'];
  //     $result = $this->Users->find()->where(['Users.id' => $user_id])->first();

  //     $product = array();
  //     if (count($result) > 0) {
  //       $response["success"] = true;
  //       $product["user_id"] = $result['id'];
  //       $product["name"] = $result['name'];
  //       $product["mobile"] = $result['mobile'];
  //       //$product["email"]=$result['email'];
  //       $product["url"] = "https://demo.gaouribrand.com/referral_info/";


  //       $test = $this->QRCodeGenerator($product["user_id"], $product["url"]);
  //       // pr($test);
  //       // exit;
  //       $response["userProfile"] = $product;
  //       echo json_encode(($response));
  //     } else {
  //       $response["success"] = false;
  //       $response["message"] = "प्रोफ़ाइल नहीं मिला";
  //       echo json_encode(($response));
  //     }
  //   } else {
  //     $response["success"] = false;
  //     $response["message"] = "In valid Method";
  //     echo json_encode(($response));
  //   }
  // }

  public function QRCodeGenerator($user_id, $URL)
  {

    $dirname = 'temp';
    $PNG_TEMP_DIR = WWW_ROOT . 'QRImages' . DS . $dirname . DS;
    //$PNG_WEB_DIR = 'temp/';
    if (!file_exists($PNG_TEMP_DIR))
      mkdir($PNG_TEMP_DIR);
    $filename = $PNG_TEMP_DIR . 'GB.png';
    $name = $URL;

    $errorCorrectionLevel = 'M';
    $matrixPointSize = 4;

    $filename = $PNG_TEMP_DIR . 'GB' . md5($name . '|' . $errorCorrectionLevel . '|' . $matrixPointSize) . '.png';
    // pr($filename);exit;
    \QRcode::png($name, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
    //display generated file
    $qrimagename = basename($filename);
    // pr($qrimagename);exit;
    return $qrimagename;
  }

  public function viewProfile()
  {

    $this->loadmodel('User');
    $this->autoRender = false;
    $response = array();
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $user_id = $this->userId()['id'];
      $result = $this->Users->find()->where(['Users.id' => $user_id])->first();

      $product = array();
      if (count($result) > 0) {
        $response["success"] = true;
        $id = $result['id'];
        $product["name"] = $result['name'];
        $product["mobile"] = $result['mobile'];
        $product["url"] = SITE_URL . "referral_info/$id";
        //$product["email"]=$result['email'];
        $qr_code = $this->QRCodeGenerator($product["user_id"], $product["url"]);
        $product["qrcode_image"] = SITE_URL . 'webroot/QRImages/temp/' . $qr_code;

        $response["userProfile"] = $product;
        echo json_encode(($response));
      } else {
        $response["success"] = false;
        $response["message"] = "प्रोफ़ाइल नहीं मिला";
        echo json_encode(($response));
      }
    } else {
      $response["success"] = false;
      $response["message"] = "In valid Method";
      echo json_encode(($response));
    }
  }





  public function contactInformation()
  {

    $this->loadmodel('User');
    $this->autoRender = false;
    $response = array();
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $user_id = $this->userId()['id'];
      $result = $this->Users->find()->where(['Users.role_id' => 1])->first();

      $product = array();
      if (count($result) > 0) {
        $response["success"] = true;
        $product["helplineNumber"] = $result['helpline_number'];
        $product["contactEmail"] = $result['contact_email'];
        $product["factoryAddress"] = $result['factroy_address'];
        $product["smsMobile"] = $result['sms_mobile'];
        $product["registerAddress"] = $result['address'];
        $product["address1"] = $result['address_1'];
        $product["pincode1"] = $result['pincode_1'];
        $product["address2"] = $result['address_2'];
        $product["pincode2"] = $result['pincode_2'];
        $product["address3"] = $result['address_3'];
        $product["pincode3"] = $result['pincode_3'];
        $product["accountName"] = $result['account_name'];
        $product["bankName"] = $result['bank_name'];
        $product["accountNumber"] = $result['account_number'];
        $product["ifsc"] = $result['ifsc'];
        $product["branch"] = $result['branch'];

        $response["contactInformation"] = $product;
        echo json_encode(($response));
      } else {
        $response["success"] = false;
        $response["message"] = "प्रोफ़ाइल नहीं मिला";
        echo json_encode(($response));
      }
    } else {
      $response["success"] = false;
      $response["message"] = "Ivalid Method";
      echo json_encode(($response));
    }
  }


  public function editProfile()
  {
    $this->autoRender = false;
    $response = array();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // pr($this->userId())
      $user_id = $this->userId()['id'];

      $name = $_POST["name"];
      //$email = $_POST["email"];
      $mobile = $_POST["mobile"];


      if ($name == '' || $mobile == '') {
        $response["success"] = false;
        $response["message"] = "कृपया सभी आवश्यक फ़ील्ड में डेटा भरें";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      //die;
      $user = $this->Users->find()->where(['id' => $user_id])->first();
      $check_mobile = $this->Users->find()->where(['mobile' => $mobile, 'id !=' => $user_id])->count();
      if ($check_mobile > 0) {
        $response["success"] = false;
        $response["message"] = "यह मोबाइल नंबर पहले से मौजूद है";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      if (count($user) > 0) {
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

        $data['name'] = $name;
        //  $data['email']= $email;
        $data['mobile'] = $mobile;
        // $data['firm_name']= $firm_name;
        // $data['gst_no']= $gst_no;
        // $data['state_id']= $state_id;
        // $data['user_address_id']= $address_results['id'];

        if ($image['name'] != '') {
          $imgname = $image['name'];
          $item = $image['tmp_name'];
          $ext = end(explode('.', $image['name']));
          $name = md5($image['name']);
          $imagename = $name . '.' . $ext;
          $dest = 'images/product_images/' . $imagename;
          if (move_uploaded_file($item, $dest)) {  //echo $imagename; die;
            $data['image'] = $imagename;
          }
        }


        $savepack = $this->Users->patchEntity($user, $data);
        //pr($savepack); die;
        $results = $this->Users->save($savepack);
        $response["success"] = true;
        $response["message"] = "Profile Updated Successfully";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      } else {
        $response["success"] = false;
        $response["message"] = "Profile Not Updated";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
    } else {
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
    $this->loadModel('Servicearea');

    $location_id = $_POST["location_id"];
    $referralAmount = $this->Users->find()->where(['role_id' => 1])->first()->referred_reward;
    //print_r($_POST['uniqueDeviceId']); die;
    $Sliders = $this->Sliders->find()->where(['status' => 'Y'])->order(['Sliders.id' => 'ASC'])->toarray();
    $response['success'] = true;
    //echo $_POST['uniqueDeviceId']; die;
    $newDevice = $this->Devices->find()->where(['id' => $_POST['userId']])->first();
    $deviceId = $this->request->getData()['userId'];
    // pr($_POST); die;
    //  //to find out user notification count
    $user_notify = $this->Users->find()->select(['notification_counter', 'wallet'])->where(['Users.id' => $deviceId])->first();
    //pr($user_notify);

    $response['details']['userNotificationCountStatus'] = $user_notify['notification_counter'] != '0' && $user_notify['notification_counter'] != '' ? true : false;

    $response['details']['userNotificationCount'] = $user_notify['notification_counter'];
    $response['details']['userWalletBalance'] = $user_notify['wallet'];

    if ($deviceId) {
      $cartCount = $this->Carts->find()->where(['user_id' => $deviceId])->count();
      //pr($cartCount); die;
      $response['details']['cartItemCount'] = ($cartCount) ? (int) $cartCount : 0;
      //pr($response); die;
    } else {
      $response['details']['cartItemCount'] = 0;
    }
    $response['details']['referralAmount'] = $referralAmount;

    if (empty($Sliders)) {
      $response['message'] = "प्रदर्शित करने के लिए कोई उत्पाद नहीं है";
      $response['categories'] = null;
      $this->response->type('application/json');
      $this->response->body(json_encode($response));
      return $this->response;
    }
    foreach ($Sliders as $slider) {
      $data = [];
      if (empty($slider['image'])) {
        $data['image'] = SITE_URL . 'images/image/default_category.jpg';
      } else {
        $data['image'] = SITE_URL . 'images/image/' . $slider['image'];
      }
      $response['sliders'][] = $data;
    }
    $response['success'] = true;

    //location base vendor product show
    $service_area = $this->Servicearea->find()->where(['location_id' => $location_id])->first();
    $vendor_id = $service_area['vendor_id'];


    if (empty($service_area)) {
      $response['message'] = "चयनित स्थान पर प्रदर्शित करने के लिए कोई भी उत्पाद जोड़े नहीं गए हैं";
      $response['product'] = null;
      $this->response->type('application/json');
      $this->response->body(json_encode($response));
      return $this->response;
    }




    $products = $this->Products->find()->where(['status' => 'Y', 'vendor_id' => $vendor_id])->order(['Products.id' => 'ASC'])->toarray();


    foreach ($products as $product) {

      $products_images = $this->ProductImages->find()->where(['product_id' => $product['id']])->toarray();
      $products_addons = $this->ProductAddons->find()->where(['product_id' => $product['id']])->toarray();
      $data_product = [];
      $data_product['id'] = $product['id'];
      $data_product['name'] = $product['name'];
      $data_product['brandName'] = $product['brand_name'];
      $data_product['description'] = $product['description'];

      if ($products_images[0]['image']) {
        $data_product['featuredImage'] = SITE_URL . 'images/product_images/' . $products_images[0]['image'];
      } else {
        $data_product['featuredImage'] = SITE_URL . 'images/no-image.png';
      }


      foreach ($products_images as $image) {
        if ($image['image']) {
          $data_product['productImage'][] = SITE_URL . 'images/product_images/' . $image['image'];
        }
      }

      if (empty($products_images)) {
        $data_product['productImage'][] = SITE_URL . 'images/no-image.png';
      }

      foreach ($products_addons as $addons) {
        $addons_data['id'] = $addons['id'];
        $addons_data['name'] = $addons['name'] . " Kg";
        $addons_data['price'] = $addons['price'];
        $data_product['productAddons'][] = $addons_data;
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
      $response['message'] = "कोई प्रश्न नहीं मिला";
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
        $response['message'] = "कोई प्रश्न नहीं मिला";
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
    $user_type = $this->userId()['user_type'];
    $this->loadModel('Coupons');
    $today = date('Y-m-d');
    $coupons = $this->Coupons->find()->where(['status' => 1])->toarray();
    //pr($coupons); die;
    $response = array();
    if (empty($coupons)) {
      $response['success'] = false;
      $response['message'] = "कोई कूपन नहीं मिला";
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

  public function products()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $category_id = $_POST['categoryId'];
      $response = array();
      $result = $this->Products->find()->where(['status' => 'Y', 'category_id' => $category_id])->order(['Products.name' => 'ASC'])->toarray();
      // pr($result); die;
      $product = array();
      if (count($result) > 0) {
        $response["success"] = true;
        $response["products"] = array();
        foreach ($result as $res) {
          $product["id"] = (int) $res['id'];
          $product["name"] = $res['name'];
          $product["mrp"] = number_format((float) $res['mrp'], 2, '.', '');
          $product["netPrice"] = number_format((float) $res['net_price'], 2, '.', '');
          $product["doctorMargin"] = number_format((float) $res['margin'], 2, '.', '');
          $product["description"] = trim($res['description']);
          if ($res['image']) {
            $product["image"] = SITE_URL . 'images/products/' . $res['image'];
          } else {
            $product["image"] = SITE_URL . 'images/noimage.png';
          }

          array_push($response["products"], $product);
        }
        echo json_encode(($response));
      } else {
        $response["success"] = false;
        $response["message"] = "कोई उत्पाद नहीं मिला";
        echo json_encode(($response));
      }
    } else {
      $response["success"] = false;
      $response["message"] = "Invalid method";
      echo json_encode(($response));
    }
    $this->autoRender = false;
  }


  public function slots()
  {
    $this->loadModel('SlotsDay');
    $this->loadModel('Slots');
    $response = array();
    $response["success"] = true;

    $current_date = date('d-M');
    $next_date = date('d-M', strtotime(' +1 day'));


    for ($ii = 0; $ii <= 6; $ii++) {
      $slot_data = [];
      $slot_data_name = date('l', strtotime("$ii day"));
      $slots = $this->SlotsDay->find('all')->where(['slots_day_english' => $slot_data_name])->first();
      $slot_data['id'] = $slots['id'];
      $slot_data['day'] = $slots['slots_day_hindi'];

      if ($current_date == date('d-M', strtotime("$ii day"))) {
        $slot_data['date'] = "आज";
      } else if ($next_date == date('d-M', strtotime("$ii day"))) {
        $slot_data['date'] = "कल";
      } else {
        $slot_data['date'] = date('d-M', strtotime("$ii day"));
      }

      $slots_time = $this->Slots->find('all')->toarray();
      $slot_data['slotDetails'] = [];
      foreach ($slots_time as $slot_detail_value) {
        $slots_detail_data = [];
        $slots_detail_data['slotdetail_id'] = $slot_detail_value['id'];
        $slots_detail_data['slotdetail'] = date('H', strtotime($slot_detail_value['mintime'])) . " बजे से " . date('H', strtotime($slot_detail_value['maxtime'])) . " बजे तक";
        $slot_data['slotDetails'][] = $slots_detail_data;
      }

      //$slot_data['slotDetails'] =  $slot_detail;
      $response['slots'][] = $slot_data;
    }
    // $response["slots"]=$slotresult;
    echo json_encode(($response));
    die;
  }

  public function viewCart()
  {
    $this->loadModel('ProductImages');
    $this->loadModel('ProductAddons');
    $this->loadModel('Coupons');
    $uid = $this->userId()['id'];
    // pr($uid); die;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $response = array();
      $result = $this->Carts->find()->contain(['Products', 'ProductAddons'])->where(['Carts.user_id' => $uid])->order(['Carts.id' => 'desc'])->toarray();
      //  pr($result);exit;

      $coupons = $this->Coupons->find()->where(['code' => $this->request->data['Coupon']])->first();
      //pr($coupons); die;
      // $products_images = $this->carts->find()->where(['image' => $product['id']])->toarray();
      $admin_state_id = $this->Users->find()->where(['id' => '1'])->first();
      $user_state_id = $this->Users->find()->where(['id' => $uid])->first();
      //pr($user_state_id);
      $product = array();
      if (count($result) > 0) {
        $sum = 0;
        $total_quantity = 0;
        $total_price = 0;

        $response["success"] = true;
        $response["walletAmount"] = $user_state_id['wallet'];
        foreach ($result as $res) {
          $product["id"] = $res['product']['id'];
          $product["name"] = $res['product']['name'];
          $product['brandName'] = $res['product']['brand_name'];
          $product['description'] = $res['product']['description'];
          //for validation
          $product['vendor_id'] = $res['product']['vendor_id'];
          $products_images = $this->ProductImages->find()->where(['product_id' => $res['product']['id']])->toarray();
          $products_addons = $this->ProductAddons->find()->where(['product_id' => $res['product']['id']])->toarray();

          $product["featuredImage"] = !empty($res['product_image']['image']) ? SITE_URL . 'images/product_images/' . $res['product_image']['image'] : SITE_URL . 'images/product_images/' . $products_images[0]['image'];

          $product['productImage'] = array();
          foreach ($products_images as $image) {
            $product['productImage'][] = SITE_URL . 'images/product_images/' . $image['image'];
          }
          $product['productAddons'] = array();
          foreach ($products_addons as $addons) {
            $addons_data['id'] = $addons['id'];
            $addons_data['name'] = $addons['name'] . " Kg";
            $addons_data['price'] = $addons['price'];
            $product['productAddons'][] = $addons_data;
          }

          $product["quantity"] = (int) $res['quantity'];
          $total_quantity += $res['quantity'];
          $product["addOnId"] = (int) $res['product_addon']['id'];
          $product["addOnWeight"] = (int) $res['product_addon']['name'];
          $product["addOnprice"] = (int) $res['product_addon']['price'] * $res['quantity'];
          $total_price += $res['product_addon']['price'] * $res['quantity'];
          $result1[] = $product;
        }

        if ($coupons) {
          if ($coupons['vendor_id'] != $product['vendor_id'] && $coupons['vendor_id'] != 1) {
            $response["success"] = false;
            $response["message"] = "आपका कूपन इस विक्रेता के प्रोडक्ट पर लागू नहीं है";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;
            die;
          }
          // pr($coupons['vendor_id']);exit;
          $today_date = date('Y-m-d');
          if (date('Y-m-d', strtotime($coupons['valid_to'])) >= $today_date) {
            if ($coupons['applicable_type'] == "amount") {
              if ($total_price >= $coupons['minimum_order_value']) {
                $discount = $coupons['maximum_discount'];
                $promoCodeMessage = "कूपन कोड सफलतापूर्वक लागू किया गया";
              } else {
                $$promoCodeMessage = "आपका ऑर्डर मूल्य कम है";
              }
            } else {
              $discount = $total_price * $coupons['discount_rate'] / 100;
              // echo $discount; die;
              if ($discount > $coupons['maximum_discount'] && $coupons['maximum_discount'] > 0) {
                $discount = $coupons['maximum_discount'];
              } else {
                $discount = $total_price * $coupons['discount_rate'] / 100;
              }
              // echo $discount; die;
              $promoCodeMessage = "कूपन कोड सफलतापूर्वक लागू किया गया";
            }
          } else {
            $promoCodeMessage = "आपका लागू कूपन कोड समाप्त हो गया है।";
          }
        } else {
          $promoCodeMessage = "अमान्य कूपन कोड।";
        }


        $body["productInfo"] = $result1;
        $body["totalQuantity"] = $total_quantity;
        $body["subtotal"] = number_format((float) $total_price, 2, '.', '');
        $body["promoCodeMessage"] = $promoCodeMessage;
        $body["discount"] = ($discount) ? $discount : 0;
        $body["deliveryCharges"] = 0;
        $body["totalAmount"] = number_format((float) $total_price, 2, '.', '') - $discount;
        $response["cartDetail"] = $body;
        echo json_encode(($response));
      } else {
        $response["success"] = false;
        $response["message"] = "आपके कार्ट में कोई आइटम नहीं मिला।";
        echo json_encode(($response));
      }
    } else {
      $response["success"] = false;
      $response["message"] = "Ivalid Method";
      echo json_encode(($response));
    }
    $this->autoRender = false;
  }

  public function walletIncome()
  {
    $this->autoRender = false;
    $this->loadModel('Users');
    $this->loadModel('Wallets');
    $userId = $this->userId()['id'];
    // pr($userId); die;
    $user = $this->Users->find('all')->where(['id' => $userId, 'Users.status' => 1])->first();
    if (empty($user)) {
      $response = array();
      $response['success'] = false;
      $response['message'] = "Invalid User";
      echo json_encode($response);
      return;
    }
    $incomes = $this->Wallets->find('all')->where(['type' => 'income', 'Wallets.user_id' => $userId, 'Wallets.payment_status' => 'approved'])->order(['Wallets.id' => 'DESC'])->toarray();
    if (empty($incomes)) {
      $response = array();
      $response['success'] = true;
      $response['wallet'] = 0;
      $response['message'] = "No Transaction Found";
      echo json_encode($response);
      return;
    }
    $response = array();
    $response['success'] = true;
    $response['wallet'] = $user['wallet'];
    foreach ($incomes as $income) {
      $data = [];

      $incomeData['amount'] = $income['amount'];
      $incomeData['date'] = date('d-m-Y', strtotime($income['created']));
      //$incomeData['couponReward'] = $income['coupon_amount'];
      //$incomeData['totalAmount'] = $income['total_amount'];
      $incomeData['transactionId'] = ucwords($income['descripton']);

      $response['income'][] = $incomeData;
    }
    echo json_encode($response);
    return;
  }

  public function userAddresses()
  {
    $this->loadModel('UserAddresses');
    $this->loadModel('Users');
    $this->loadModel('Servicearea');
    $this->autoRender = false;
    if ($this->request->is('post')) {

      $user_id = $this->userId()['id'];
      //requesting the data from table
      $useradd['user_id'] = $this->userId()['id'];      //fetching id from address table using relation
      $response = array();
      if (empty($this->request->getData()['address'])) {
        $response['success'] = false;
        $response['message'] = "Invalid Parameters";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      extract($this->request->getData());   //requesting the data from the data base and now can be seen by calling just variables
      //pr($address); die;
      $user = $this->UserAddresses->newEntity();  // connecting to data base if new data added should be added in user addresses table
      $user['user_id'] = $user_id;
      $user['address'] = $address;
      $user['latitude'] = $latitude;
      $user['longitude'] = $longitude;
      $user['address_type'] = $address_type;
      $user['name'] = $name;
      $user['is_permanent'] = $is_permanent;
      //pr($user); die;
      $user['status'] = 1;

      // $body['success'] =false;
      // $body['message'] = $latitude.'long'.$longitude;
      // echo json_encode($body); die;

      $userInfo = $this->Users->find()->where(['id' => $user_id])->first();

      $service_area = $this->Servicearea->find()->where(['location_id' => $userInfo['location_id']])->toarray();
      $serviceArea = [];
      foreach ($service_area as $serviceareakey => $serviceareavalue) {
        $data = [];
        $data['lat'] = $serviceareavalue['latitude'];
        $data['lng'] = $serviceareavalue['longitude'];
        $serviceArea[] = $data;
      }
      // pr($serviceArea);
      $response_location_track = \GeometryLibrary\PolyUtil::containsLocation(
        ['lat' => $_REQUEST['latitude'], 'lng' => $_REQUEST['longitude']],
        $serviceArea
      );

      //echo "testsedddd"; die;
      //    pr($response); die;
      if (empty($response_location_track)) {
        $body['success'] = false;
        $body['message'] = "सेवा क्षेत्र उपलब्ध नहीं है";
        echo json_encode($body);
        die;
      }
      if ($this->UserAddresses->save($user)) {    //if all the above fields are filled and satisfied the data themn it will save the data is database table
        $response['success'] = true;
        $response['message'] = "पता सफलतापूर्वक जोड़ा गया";
        //pr($response); die;
        echo json_encode($response);
        return;
      }
      $address_update = $this->UserAddresses->find()->where(['user_id' => $user_id, 'id !=' => $address_results['id']])->toarray();
      $status['is_permanent'] = 'N';
      foreach ($address_update as $value) {
        $result = $this->UserAddresses->patchEntity($value, $status);
        $address_result = $this->UserAddresses->save($result);
      }
    } else {
      $response['success'] = false;
      $response['message'] = "Invalid Data Type";
      echo json_encode($response);
      return;
    }
  }

  public function userAddresses2()
  {
    $this->loadModel('UserAddresses');
    $this->loadModel('Users');
    $this->loadModel('Servicearea');
    $this->autoRender = false;
    if ($this->request->is('post')) {

      $user_id = $this->userId()['id'];

      //requesting the data from table
      $useradd['user_id'] = $this->userId()['id'];      //fetching id from address table using relation
      $response = array();
      if (empty($this->request->getData()['address'])) {
        $response['success'] = false;
        $response['message'] = "Invalid Parameters";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }

      extract($this->request->getData());   //requesting the data from the data base and now can be seen by calling just variables
      $user = $this->UserAddresses->newEntity();  // connecting to data base if new data added should be added in user addresses table
      $user['user_id'] = $user_id;
      $user['address'] = $address;
      $user['latitude'] = $latitude;
      $user['longitude'] = $longitude;
      $user['address_type'] = 'Home';
      $user['name'] = $name;
      $user['is_permanent'] = $is_permanent;
      $user['status'] = 1;
      // $body['success'] =false;
      // $body['message'] = $latitude.'long'.$longitude;
      // echo json_encode($body); die;

      $userInfo = $this->Users->find()->where(['id' => $user_id])->first();
      $service_area = $this->Servicearea->find()->where(['location_id' => $userInfo['location_id']])->toarray();
      $serviceArea = [];
      foreach ($service_area as $serviceareakey => $serviceareavalue) {
        $data = [];
        $data['lat'] = $serviceareavalue['latitude'];
        $data['lng'] = $serviceareavalue['longitude'];
        $serviceArea[] = $data;
      }
      $response_location_track = \GeometryLibrary\PolyUtil::containsLocation(
        ['lat' => $_REQUEST['latitude'], 'lng' => $_REQUEST['longitude']],
        $serviceArea
      );

      $add = $this->UserAddresses->find()->where(['user_id' => $user_id])->first();
      if (empty($response_location_track)) {
        $body['success'] = false;
        $body['message'] = "सेवा क्षेत्र उपलब्ध नहीं है";
        echo json_encode($body);
        die;
      }
      if (empty($add)) {
        $this->UserAddresses->save($user);
        $response['success'] = true;
        $response['message'] = "पता सफलतापूर्वक जोड़ा गया";
      } else {
        $this->UserAddresses->deleteAll(['user_id' => $user_id]);
        $this->UserAddresses->save($user);
        $response['success'] = true;
        $response['message'] = "पता सफलतापूर्वक जोड़ा गया !!";
      }

      $dataa['address'] = $address;
      $savepack = $this->Users->patchEntity($userInfo, $dataa);
      $results = $this->Users->save($savepack);

      echo json_encode($response, $results);
      return;
    } else {
      $response['success'] = false;
      $response['message'] = "Invalid Data Type";
      echo json_encode($response);
      return;
    }
  }

  public function viewAddress()
  {
    $this->loadModel('UserAddresses');
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

      $response = array();
      $user_id = $this->userId()['id'];
      $result = $this->UserAddresses->find()->where(['user_id' => $user_id])->toarray();
      // pr($user_id);exit;
      $product = array();
      if (count($result) > 0) {
        $response["success"] = true;
        $response["useraddress"] = array();
        foreach ($result as $res) {
          $product["id"] = (int) $res['id'];
          $product["address"] = $res['address'];
          $product["address_type"] = $res['address_type'];
          $product["name"] = $res['name'];
          $product["latitude"] = $res['latitude'];
          $product["longitude"] = $res['longitude'];
          $product["is_permanent"] = $res['is_permanent'];

          array_push($response["useraddress"], $product);
        }
        echo json_encode(($response));
      } else {
        $response["success"] = false;
        $response["message"] = "कोई उपयोगकर्ता पता नहीं मिला";
        echo json_encode(($response));
      }
    } else {
      $response["success"] = false;
      $response["message"] = "Invalid method";
      echo json_encode(($response));
    }
    $this->autoRender = false;
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


  public function viewAddress2()
  {
    $this->loadModel('UserAddresses');
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {

      $response = array();
      $user_id = $this->userId()['id'];
      $res = $this->UserAddresses->find()->where(['user_id' => $user_id])->order(['id' => 'desc'])->first();
      // pr($user_id);exit;
      $product = array();
      if (count($res) > 0) {
        $response["success"] = true;
        $response["useraddress"] = array();
        // foreach ($result as $res) {
        $product["id"] = (int) $res['id'];
        $product["address"] = $res['address'];
        $product["address_type"] = $res['address_type'];
        $product["name"] = $res['name'];
        $product["latitude"] = $res['latitude'];
        $product["longitude"] = $res['longitude'];
        $product["is_permanent"] = $res['is_permanent'];

        array_push($response["useraddress"], $product);
        // }
        echo json_encode(($response));
      } else {
        $response["success"] = false;
        $response["message"] = "कोई उपयोगकर्ता पता नहीं मिला";
        echo json_encode(($response));
      }
    } else {
      $response["success"] = false;
      $response["message"] = "Invalid method";
      echo json_encode(($response));
    }
    $this->autoRender = false;
  }

  public function deleteAddress()
  {
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
    $response["message"] = "उपयोगकर्ता का पता सफलतापूर्वक हटा दिया गया है";
    echo json_encode(($response));
  }


  public function inviteFriend()
  {
    $userid = $this->userId()['id'];
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $response = array();
      $usercheck = $this->Users->find()->where(['id' => $userid])->first();
      $referralAmount = $this->Users->find()->where(['role_id' => 1])->first()->referred_reward;
      if (count($usercheck) > 0) {
        $response['success'] = true;
        $response['output'] = [];
        $response['output']['referralCode'] = $usercheck['referral_code'];
        $response['output']['referralAmount'] = $referralAmount;
        $response['output']['shareInfo']['title'] = "Gaouri Brand";
        $response['output']['shareInfo']['message'] = 'मैं अपने मवेशियों के लिए सर्वोत्तम चारे के लिए गौरी ब्रांड ऐप का उपयोग कर रहा हूं, कृपया इसे डाउनलोड करें और अपने मवेशियों के पोषण में सुधार करें। रेफरल कोड है ' . $usercheck['referral_code'];
        $response['output']['shareInfo']['androidUrl'] = "https://play.google.com/store/apps/details?id=com.doomshell.gaouribrand";
        $response['output']['shareInfo']['iosUrl'] = "";

        $response['output']['shareInfo']['image']['url'] = SITE_URL . "images/logo_1.png";
        $response['output']['shareInfo']['image']['extension'] = "png";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      } else {
        $response["success"] = false;
        $response["message"] = "Invalid User";
        echo json_encode(($response));
      }
    } else {
      $response["success"] = false;
      $response["message"] = "Invalid method";
      echo json_encode(($response));
    }
    $this->autoRender = false;
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

  public function onlinePaymentVerification()
  {
    $this->autoRender = false;
    $this->loadModel('Orders');
    $this->loadModel('Wallets');

    if ($this->request->is('post')) {
      $response = array();
      if (empty($this->request->data['orderId']) || empty($this->request->data['onlineOrderId'])) {
        $response['success'] = false;
        $response['message'] = "Invalid Parameters";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $userId = $this->userId()['id'];
      if (empty($this->request->data['onlinePaymentId']) || empty($this->request->data['onlineSignature'])) {
        $response['success'] = false;
        $response['message'] = "Payment Failed";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      extract($this->request->data);
      $order = $this->Orders->find()->where(['id' => $this->request->data['orderId'], 'razorpay_order_id' => $onlineOrderId])->first();
      if ($order['payment_status'] == "approved") {
        $response['success'] = false;
        $response['message'] = "Duplicate Entry";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      if (empty($order)) {
        $response['success'] = false;
        $response['message'] = "Invalid Request";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $api = new Api(RAZOR_API_KEY, RAZOR_API_SECRET);
      $attributes = array(
        'razorpay_order_id' => $onlineOrderId,
        'razorpay_payment_id' => $onlinePaymentId,
        'razorpay_signature' => $onlineSignature,
      );
      try {
        $paymentStatus = $api->utility->verifyPaymentSignature($attributes);
      } catch (SignatureVerificationError $e) {
        $success = false;
        $response['message'] = "Invalid Signatures";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $razorOrder = $api->order->fetch($onlineOrderId);
      $order = $this->Orders->find()->where(['id' => $this->request->data['orderId']])->first();
      if (!empty($this->request->data['onlinePaymentId']) && $razorOrder->status == 'paid') {


        $order->payment_status = "approved";
        $order->razorpay_payment_id = $onlinePaymentId;
        $order->razorpay_signature = $onlineSignature;
        $ordersave = $this->Orders->save($order);

        // $rechargeExist = $this->Orders->exists(['user_id' => $userId, 'payment_status' => 'approved', 'OR' =>['descripton not in ' => ['referral reward','First time registration'], ['descripton IS' =>NULL]], 'type' => 'income']); 
        // $order['razorpay_signature'] = $onlineSignature;
        // $order['razorpay_payment_id'] = $onlinePaymentId;
        // $order['payment_status'] = 'approved';
        // $this->Wallets->save($order);


        $user = $this->Users->find()->where(['id' => $userId])->first();
        $user->wallet += $order->total_amount;
        $this->Users->save($user);
        if (!$rechargeExist && !empty($user['referred_user_id'])) {
          $referredUser = $this->Users->find()->where(['id' => $user['referred_user_id']])->first();
          if ($referredUser) {
            $order_count = $this->Orders->find()->where(['user_id' => $userId])->count();
            if ($order_count == 1) {
              $referralWallet = $this->Wallets->newEntity();
              $referralWallet->user_id = $user['referred_user_id'];
              $referralWallet->amount = $user['referred_reward'];
              $referralWallet->total_amount = $user['referred_reward'];
              $referralWallet->type = 'income';
              $referralWallet->descripton = 'referral reward';
              $referralWallet->payment_status = 'approved';
              if ($this->Wallets->save($referralWallet)) {
                $referredUser->wallet += $user['referred_reward'];
                $this->Users->save($referredUser);
              }
              $referralWallet = $this->Wallets->newEntity();
              $referralWallet->user_id = $userId;
              $referralWallet->amount = $user['referred_reward'];
              $referralWallet->total_amount = $user['referred_reward'];
              $referralWallet->type = 'income';
              $referralWallet->descripton = 'referral reward';
              $referralWallet->payment_status = 'approved';
              if ($this->Wallets->save($referralWallet)) {
                $user = $this->Users->find()->where(['id' => $userId])->first();
                $user->wallet += $user['referred_reward'];
                $this->Users->save($user);
              }
            }
          }
        }
        $this->Carts->deleteAll(['user_id' => $userId]);
        $response['success'] = true;
        $response['message'] = 'आपकी बुकिंग सफलतापूर्वक बन गई है';
        $response['cartCount'] = '0';
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $order->razorpay_payment_id = $onlinePaymentId;
      $order->payment_status = "rejected";
      if ($this->Orders->save($order)) {
        $response['success'] = true;
        $response['message'] = "वॉलेट अपडेट किया गया";
        $this->response->type('application/json');
        $this->response->body(json_encode($response));
        return $this->response;
      }
      $response['success'] = false;
      $response['message'] = "कृपया कुछ देर बाद प्रयास करें";
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


  public function addToCart()
  {
    $this->loadModel('Servicearea');

    if ($this->request->is(['post', 'put'])) {
      $userdata['user_id'] = $this->userId()['id'];
      $addon_id = $_POST["addonId"];
      $is_cart_reset = $_POST["is_cart_reset"];


      $response['is_alert'] = false;
      //Lets check location is valid
      $last_cart_location = $this->Carts->find()->where(['user_id' => $userdata['user_id']])->first();
      if ($last_cart_location) {

        if ($last_cart_location['location_id'] != $_POST["location_id"]) {
          if ($is_cart_reset == "YES") {
            $this->Carts->deleteAll(['Carts.user_id' => $userdata['user_id']]);
          } else {
            $response['success'] = true;
            $response['is_alert'] = true;
            $response['message'] = "क्या आप अपना कार्ट खाली करना चाहते हैं,क्योंकि आप की लोकेशन चेंज हुई है";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;
          }
        }
      }

      if ($this->request->is(['post', 'put'])) {
        // $_POST["quantity"] = (($_POST["quantity"]) < 1) ? 1 : $_POST["quantity"];
        $userdata['user_id'] = $this->userId()['id'];
        $userdata['product_id'] = $_POST['productId'];
        $userdata['quantity'] = $_POST["quantity"];
        $userdata['location_id'] = $_POST["location_id"];

        $user = $this->Users->find()->where(['id' => $userdata['user_id']])->first();
        $cart_item_check = $this->Carts->find()->where(['user_id' => $userdata['user_id'], 'product_id' => $userdata['product_id'], 'product_addon_id' => $addon_id])->first();

        if (count($cart_item_check) > 0) {
          $data['quantity'] = ($userdata['quantity']) + $cart_item_check['quantity'];
          if ($data['quantity'] <= 0) {
            $this->Carts->deleteAll(['Carts.id' => $cart_item_check['id']]);
            $response = array();
            $response['success'] = true;
            //  $response['message'] = "Your Item has been deleted Successfully";
            $response['message'] = "आपका आइटम सफलतापूर्वक हटा दिया गया है";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;
          }
          $data["quantity"] = (($data["quantity"]) < 1) ? 1 : $data["quantity"];
          $data['product_addon_id'] = $addon_id;
          $quantity_savepack = $this->Carts->patchEntity($cart_item_check, $data);
          $quantity_results = $this->Carts->save($quantity_savepack);

          $response["success"] = true;
          //  $response["message"] = "Item successfully added in cart";
          $response["message"] = "आइटम सफलतापूर्वक कार्ट में जोड़ा गया";
          $response["cartItemCount"] = $quantity_results['quantity'];
          $this->response->type('application/json');
          $this->response->body(json_encode($response));
          return $this->response;
        } else {
          $userdata['product_addon_id'] = $addon_id;
          $newpack = $this->Carts->newEntity();
          $savepack = $this->Carts->patchEntity($newpack, $userdata);
          $results = $this->Carts->save($savepack);

          if ($results) {
            $response["success"] = true;
            // $response["message"] ="Your Cart updated Successfully";
            $response["message"] = "आपका कार्ट सफलतापूर्वक अपडेट हो गया";
            $response["cartItemCount"] = $results['quantity'];
          }
        }
      } else {
        $response["success"] = false;
        $response["message"] = "Invalid method";
      }
      $this->response->type('application/json');
      $this->response->body(json_encode($response));
      return $this->response;
    }
  }


  public function orderCart()
  {

    $uid = $this->userId()['id'];
    // pr($uid);exit;
    $this->loadModel('UserAddresses');
    $this->loadModel('ProductAddons');
    $this->loadModel('Servicearea');
    $this->loadModel('Users');
    $this->loadModel('Carts');
    $this->loadModel('Coupons');
    $this->loadModel('Locations');

    extract($this->request->getData());
    // pr($this->request->getData());exit;
    // $address = $this->UserAddresses->find()->where(['id'=>$addressId])->first();
    // $user_address = $address['address'];
    //pr($user_address); die;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $response = array();
      $wallet = $this->request->data['wallet'];


      // pr($uid);exit;
      $result = $this->Carts->find()->contain(['Products', 'ProductAddons'])->where(['Carts.user_id' => $uid])->toarray();



      $product = array();
      if (count($result) > 0) {
        $total_amount = 0;
        $total_quantity = 0;

        $$location_data['vendor_id'] = [];
        foreach ($result as $res) {

          $location_data['location_id'] = $res['location_id'];
          $location_data['vendor_id'] = $res['product']['vendor_id'];

          $total_amount += number_format((float) $res['product_addon']['price'], 2, '.', '') * $res['quantity'];
          $total_quantity += $res['quantity'];
        }

        $coupons = $this->Coupons->find()->where(['code' => $coupon])->first();


        $total_amount = $total_amount - $wallet;
        //  pr($total_amount); die;
        // $locality = "Parasrampura";
        $loca = $this->Locations->find()->where(['id' => $res['location_id']])->first();
        $locality = $loca['name'];

        // Sanjay Code
        // pr($location_data['location_id']);exit;
        $service_area = $this->Servicearea->find('all')->where(['location_id' => $location_data['location_id']])->toarray();
        // pr($service_area);exit;
        $serviceArea = [];
        foreach ($service_area as $serviceareakey => $serviceareavalue) {
          $data = [];
          $data['lat'] = $serviceareavalue['latitude'];
          $data['lng'] = $serviceareavalue['longitude'];
          $serviceArea[] = $data;
        }
        // get lat & long through API.
        $latitude = $this->request->data['latitude'];
        $longitude = $this->request->data['longitude'];


        $response_location_track = \GeometryLibrary\PolyUtil::containsLocation(
          ['lat' => $latitude, 'lng' => $longitude],
          $serviceArea
        );

        if (empty($response_location_track)) {
          $response['success'] = false;
          $response['message'] = "चयनित स्थान और पता मेल नहीं खाता.";
          $this->response->type('application/json');
          $this->response->body(json_encode($response));
          return $this->response;
        }

        if ($coupons) {
          // for check vendor id validation
          if ($coupons['vendor_id'] != $location_data['vendor_id'] && $coupons['vendor_id'] != 1) {
            $response["success"] = false;
            $response["message"] = "आपका कूपन इस विक्रेता के प्रोडक्ट पर लागू नहीं है";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;
            die;
          }

          $today_date = date('Y-m-d');
          if (date('Y-m-d', strtotime($coupons['valid_to'])) >= $today_date) {
            if ($coupons['applicable_type'] == "amount") {
              if ($total_amount >= $coupons['minimum_order_value']) {
                $discount = $coupons['maximum_discount'];
                $promoCodeMessage = "कूपन कोड सफलतापूर्वक लागू किया गया";
              } else {
                $promoCodeErrorMessage = "आपका ऑर्डर मूल्य कम है";
              }
            } else {
              $discount = $total_amount * $coupons['discount_rate'] / 100;
              if ($discount > $coupons['maximum_discount']) {
                $discount = $coupons['maximum_discount'];
              } else {
                $discount = $total_amount * $promo_code['discount_rate'] / 100;
              }
              $promoCodeMessage = "कूपन कोड सफलतापूर्वक लागू किया गया";
            }
          } else {
            $promoCodeErrorMessage = "आपका लागू कूपन कोड समाप्त हो गया है।";
          }
        }

        if ($promoCodeErrorMessage) {
          $response["success"] = false;
          $response["message"] = $promoCodeErrorMessage;
          $this->response->type('application/json');
          $this->response->body(json_encode($response));
          return $this->response;
          die;
        }

        $response["success"] = true;
        $order['user_id'] = $uid;
        $order['wallet'] = ($wallet) ? $wallet : 0;
        $order['discount'] = ($discount) ? $discount : 0;
        if (isset($coupons['code'])) {
          $order['coupon_applied'] = ($discount > 0) ? $coupons['code'] : 0;
        }
        $order['sub_total'] = $total_amount;
        $order['total_amount'] = $total_amount - $wallet - $discount;
        $order['slot_id'] = $slotId;
        $order['billng_address'] = $address;
        $order['address_type'] = $address_type;
        $order['latitude'] = $latitude;
        $order['longitude'] = $longitude;
        $order['locality'] = $locality;
        $order['payment_mode'] = $paymentMode;
        $order['location_id'] = $location_data['location_id'];
        $order['vendor_id'] = $location_data['vendor_id'];

        if ($delivery_date == "आज") {
          $order['delivery_date'] = date('Y-m-d');
        } else if ($delivery_date == "कल") {
          $order['delivery_date'] = date('Y-m-d', strtotime(' +1 day'));
        } else {
          $order['delivery_date'] = date('Y-m-d', strtotime($delivery_date));
        }

        $newpack = $this->Orders->newEntity();
        $order_savepack = $this->Orders->patchEntity($newpack, $order);
        // pr($order_savepack);
        // die;
        $order_result = $this->Orders->save($order_savepack);


        //echo "test"; die;
        if ($order_result) {
          foreach ($result as $res) {
            $orderDetail['user_id'] = $uid;
            $orderDetail['order_id'] = $order_result['id'];
            $orderDetail['product_id'] = $res['product']['id'];
            $orderDetail['quantity'] = $res['quantity'];
            $orderDetail['address_type'] = $res['address_type'];
            $orderDetail['product_price'] = $res['product_addon']['price'];
            $orderDetail['total_price'] = $res['product_addon']['price'] * $res['quantity'];
            $orderDetail['weight'] = $res['product_addon']['name'];
            $newpack1 = $this->OrderDetails->newEntity();
            $orderdetail_savepack = $this->OrderDetails->patchEntity($newpack1, $orderDetail);
            $orderdetail_result = $this->OrderDetails->save($orderdetail_savepack);
          }
        }


        if ($this->request->data['paymentMode'] == "COD") {
          $this->Carts->deleteAll(['user_id' => $uid]);
          $response["success"] = true;
          $response["message"] = "आपकी बुकिंग सफलतापूर्वक बन गई है";
          $response["cartCount"] = 0;
          $userinfo["orderId"] = (int) $order_result['id'];
          $userinfo["amount"] = number_format((float) $order_result->total_amount, 2, '.', '');
          $response['orderInfo'] = $userinfo;
          echo json_encode(($response));
          die;
        } else {


          $orderId = $order_result['id'];
          $api = new Api(RAZOR_API_KEY, RAZOR_API_SECRET);


          $razorPayorder = $api->order->create(
            array(
              'receipt' => (string) $orderId,
              'amount' => (string) $order_result->total_amount * 100,
              'payment_capture' => 1,
              'currency' => 'INR',
              // 'verify' => false,
            )
          );


          $order_result['razorpay_order_id'] = $razorPayorder->id;
          $order_result['payment_status'] = 'pending';
          // pr($order_result); die;

          $this->Orders->save($order_result);

          $response['success'] = true;
          $response['orderPlaced'] = false;
          $data_razorpay['orderId'] = $orderId;
          $data_razorpay['orderAmount'] = $order_result->total_amount;
          $data_razorpay['onlineKeyId'] = RAZOR_API_KEY;
          $data_razorpay['onlineOrderId'] = $razorPayorder->id;
          $data_razorpay['currency'] = "INR";
          $data_razorpay['description'] = "Gaouri Brand";
          $data_razorpay['merchantName'] = "Gaouri";
          $data_razorpay['merchantLogo'] = SITE_URL . "images/logo_1.png";
          $response['output'] = $data_razorpay;
          $this->response->type('application/json');
          $this->response->body(json_encode($response));
          return $this->response;
          die;
        }
      } else {
        $response["success"] = false;
        $response["message"] = "आपकी कार्ट खाली है, कृपया वापस जाएं और नई वस्तु जोड़ें";
        echo json_encode(($response));
      }
    } else {
      $response["success"] = false;
      $response["message"] = "Ivalid Method";
      echo json_encode(($response));
    }
    $this->autoRender = false;
  }

  public function orderCart1()
  {

    $uid = $this->userId()['id'];
    // pr($uid);exit;
    $this->loadModel('UserAddresses');
    $this->loadModel('Servicearea');
    $this->loadModel('Users');
    $this->loadModel('Carts');
    $this->loadModel('Coupons');
    $this->loadModel('Locations');

    extract($this->request->getData());
    // pr($this->request->getData());exit;
    // $address = $this->UserAddresses->find()->where(['id'=>$addressId])->first();
    // $user_address = $address['address'];
    //pr($user_address); die;


    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $response = array();
      $wallet = $this->request->data['wallet'];


      $result = $this->Carts->find()->contain(['Products', 'ProductAddons'])->where(['user_id' => $uid])->toarray();
      $product = array();
      if (count($result) > 0) {
        $total_amount = 0;
        $total_quantity = 0;

        $$location_data['vendor_id'] = [];
        foreach ($result as $res) {

          $location_data['location_id'] = $res['location_id'];
          $location_data['vendor_id'] = $res['product']['vendor_id'];

          $total_amount += number_format((float) $res['product_addon']['price'], 2, '.', '') * $res['quantity'];
          $total_quantity += $res['quantity'];
        }
        $coupons = $this->Coupons->find()->where(['code' => $coupon])->first();


        $total_amount = $total_amount - $wallet;
        // $locality = "Parasrampura";
        $loca = $this->Locations->find()->where(['id' => $res['location_id']])->first();
        $locality = $loca['name'];

        // Sanjay Code
        // pr($location_data['location_id']);exit;
        $service_area = $this->Servicearea->find('all')->where(['location_id' => $location_data['location_id']])->toarray();
        // pr($service_area);exit;
        $serviceArea = [];
        foreach ($service_area as $serviceareakey => $serviceareavalue) {
          $data = [];
          $data['lat'] = $serviceareavalue['latitude'];
          $data['lng'] = $serviceareavalue['longitude'];
          $serviceArea[] = $data;
        }
        // get lat & long through API.
        $latitude = $this->request->data['latitude'];
        $longitude = $this->request->data['longitude'];

        $response_location_track = \GeometryLibrary\PolyUtil::containsLocation(
          ['lat' => $latitude, 'lng' => $longitude],
          $serviceArea
        );
        if (empty($response_location_track)) {
          $response['success'] = false;
          $response['message'] = "चयनित स्थान और पता मेल नहीं खाता.";
          $this->response->type('application/json');
          $this->response->body(json_encode($response));
          return $this->response;
        }

        if ($coupons) {
          // for check vendor id validation
          if ($coupons['vendor_id'] != $location_data['vendor_id'] && $coupons['vendor_id'] != 1) {
            $response["success"] = false;
            $response["message"] = "आपका कूपन इस विक्रेता के प्रोडक्ट पर लागू नहीं है";
            $this->response->type('application/json');
            $this->response->body(json_encode($response));
            return $this->response;
            die;
          }

          $today_date = date('Y-m-d');
          if (date('Y-m-d', strtotime($coupons['valid_to'])) >= $today_date) {
            if ($coupons['applicable_type'] == "amount") {
              if ($total_amount >= $coupons['minimum_order_value']) {
                $discount = $coupons['maximum_discount'];
                $promoCodeMessage = "कूपन कोड सफलतापूर्वक लागू किया गया";
              } else {
                $promoCodeErrorMessage = "आपका ऑर्डर मूल्य कम है";
              }
            } else {
              $discount = $total_amount * $coupons['discount_rate'] / 100;
              if ($discount > $coupons['maximum_discount']) {
                $discount = $coupons['maximum_discount'];
              } else {
                $discount = $total_amount * $promo_code['discount_rate'] / 100;
              }
              $promoCodeMessage = "कूपन कोड सफलतापूर्वक लागू किया गया";
            }
          } else {
            $promoCodeErrorMessage = "आपका लागू कूपन कोड समाप्त हो गया है।";
          }
        }

        if ($promoCodeErrorMessage) {
          $response["success"] = false;
          $response["message"] = $promoCodeErrorMessage;
          $this->response->type('application/json');
          $this->response->body(json_encode($response));
          return $this->response;
          die;
        }

        $response["success"] = true;
        $order['user_id'] = $uid;
        $order['wallet'] = ($wallet) ? $wallet : 0;
        $order['discount'] = ($discount) ? $discount : 0;
        if (isset($coupons['code'])) {
          $order['coupon_applied'] = ($discount > 0) ? $coupons['code'] : 0;
        }
        $order['sub_total'] = $total_amount;
        $order['total_amount'] = $total_amount - $wallet - $discount;
        // $order['slot_id'] = $slotId;
        $order['slot_id'] = 1;
        $order['billng_address'] = $address;
        $order['address_type'] = $address_type;
        $order['latitude'] = $latitude;
        $order['longitude'] = $longitude;
        $order['locality'] = $locality;
        $order['payment_mode'] = $paymentMode;
        $order['location_id'] = $location_data['location_id'];
        $order['vendor_id'] = $location_data['vendor_id'];

        // if ($delivery_date == "आज") {
        //   $order['delivery_date'] = date('Y-m-d');
        // } else if ($delivery_date == "कल") {
        //   $order['delivery_date'] = date('Y-m-d', strtotime(' +1 day'));
        // } else {
        //   $order['delivery_date'] = date('Y-m-d', strtotime($delivery_date));
        // }

        $order['delivery_date'] = date('Y-m-d', strtotime('+1 day'));
        $newpack = $this->Orders->newEntity();
        $order_savepack = $this->Orders->patchEntity($newpack, $order);
        // pr($order_savepack);
        // die;
        $order_result = $this->Orders->save($order_savepack);


        //echo "test"; die;
        if ($order_result) {
          foreach ($result as $res) {
            $orderDetail['user_id'] = $uid;
            $orderDetail['order_id'] = $order_result['id'];
            $orderDetail['product_id'] = $res['product']['id'];
            $orderDetail['quantity'] = $res['quantity'];
            $orderDetail['address_type'] = $res['address_type'];
            $orderDetail['product_price'] = $res['product_addon']['price'];
            $orderDetail['total_price'] = $res['product_addon']['price'] * $res['quantity'];
            $orderDetail['weight'] = $res['product_addon']['name'];
            $newpack1 = $this->OrderDetails->newEntity();
            $orderdetail_savepack = $this->OrderDetails->patchEntity($newpack1, $orderDetail);
            $orderdetail_result = $this->OrderDetails->save($orderdetail_savepack);
          }
        }

        if ($this->request->data['paymentMode'] == "COD") {
          $this->Carts->deleteAll(['user_id' => $uid]);
          $response["success"] = true;
          $response["message"] = "आपकी बुकिंग सफलतापूर्वक बन गई है";
          $response["cartCount"] = 0;
          $userinfo["orderId"] = (int) $order_result['id'];
          $userinfo["amount"] = number_format((float) $order_result->total_amount, 2, '.', '');
          $response['orderInfo'] = $userinfo;
          echo json_encode(($response));
          die;
        } else {
          $orderId = $order_result['id'];
          $api = new Api(RAZOR_API_KEY, RAZOR_API_SECRET);
          $razorPayorder = $api->order->create(
            array(
              'receipt' => $orderId,
              'amount' => $order_result->total_amount * 100,
              'payment_capture' => 1,
              'currency' => 'INR',
            )
          );
          $order_result['razorpay_order_id'] = $razorPayorder->id;
          $order_result['payment_status'] = 'pending';
          //pr($newOrder); die;
          $this->Orders->save($order_result);

          $response['success'] = true;
          $response['orderPlaced'] = false;
          $data_razorpay['orderId'] = $orderId;
          $data_razorpay['orderAmount'] = $order_result->total_amount;
          $data_razorpay['onlineKeyId'] = RAZOR_API_KEY;
          $data_razorpay['onlineOrderId'] = $razorPayorder->id;
          $data_razorpay['currency'] = "INR";
          $data_razorpay['description'] = "Gaouri Brand";
          $data_razorpay['merchantName'] = "Gaouri";
          $data_razorpay['merchantLogo'] = SITE_URL . "images/logo_1.png";
          $response['output'] = $data_razorpay;
          $this->response->type('application/json');
          $this->response->body(json_encode($response));
          return $this->response;
          die;
        }
      } else {
        $response["success"] = false;
        $response["message"] = "आपकी कार्ट खाली है, कृपया वापस जाएं और नई वस्तु जोड़ें";
        echo json_encode(($response));
      }
    } else {
      $response["success"] = false;
      $response["message"] = "Ivalid Method";
      echo json_encode(($response));
    }
    $this->autoRender = false;
  }


  public function convert_day($day)
  {
    if ($day == "Monday") {
      return "सोमवार";
    } else if ($day == "Tuesday") {
      return "मंगलवार";
    } else if ($day == "Wednesday") {
      return "बुधवार";
    } else if ($day == "Thursday") {
      return "गुरूवार";
    } else if ($day == "Friday") {
      return "शुक्रवार";
    } else if ($day == "Saturday") {
      return "शनिवार";
    } else if ($day == "Sunday") {
      return "रविवार";
    }
  }

  public function convert_month($month)
  {
    if ($month == "January") {
      return "जनवरी";
    } else if ($month == "February") {
      return "फ़रवरी";
    } else if ($month == "March") {
      return "मार्च";
    } else if ($month == "April") {
      return "अप्रैल";
    } else if ($month == "May") {
      return "मई";
    } else if ($month == "June") {
      return "जून";
    } else if ($month == "July") {
      return "जुलाई";
    } else if ($month == "August") {
      return "अगस्त";
    } else if ($month == "September") {
      return "सितंबर";
    } else if ($month == "October") {
      return "अक्टूबर";
    } else if ($month == "November") {
      return "नवंबर";
    } else if ($month == "December") {
      return "दिसंबर";
    }
  }

  public function convert_time($time)
  {

    $hours = date("H", strtotime($time));
    if ($hours >= 1 && $hours <= 11) {
      $greeting = "सुबह";
    } else if ($hours <= 15) {
      $greeting = "दोपहर";
    } else if ($hours <= 20) {
      $greeting = "शाम";
    } else if ($hours <= 24) {
      $greeting = "रात";
    }
    return $greeting;
  }


  public function orderDetail()
  {
    $user_id = $this->userId()['id'];
    $this->loadModel('Slots');
    $this->loadModel('SlotsDay');
    $this->loadModel('ProductImages');
    $order = $this->Orders->find()->where(['user_id' => $user_id])->order(['Orders.id' => 'desc'])->toarray();
    if (count($order) > 0) {
      foreach ($order as $value) {
        $slot_info = $this->Slots->find()->contain(['SlotsDay'])->where(['Slots.id' => $value['slot_id']])->first();

        $order_day = $this->convert_day(date('l', strtotime($value['order_date'])));
        $order_month = $this->convert_month(date('F', strtotime($value['order_date'])));
        $order_am_pm = $this->convert_time($value['order_date']);

        $delivery_day = $this->convert_day(date('l', strtotime($value['delivery_date'])));
        $delivery_month = $this->convert_month(date('F', strtotime($value['delivery_date'])));
        $delivery_am_pm = $this->convert_time($value['delivery_date']);

        //echo $delivery_month; die;
        $orderdata['orderId'] = (int) $value['id'];
        $orderdata['orderDate'] = $order_day . ' ' . date('d', strtotime($value['order_date'])) . '-' . $order_month . '-' . date('Y') . ' को ' . $order_am_pm . ' ' . date('h', strtotime($slot_info['mintime'])) . ' बजे आर्डर किया गया';
        //pr($orderdata); die;
        $orderdata['tagline'] = "गौरी ब्रांड द्वार पहुचाया गया";
        $orderdata['delivery_date'] = $delivery_day . ' ' . date('d', strtotime($value['delivery_date'])) . '-' . $delivery_month . '-' . date('Y') . ' को ' . $delivery_am_pm . ' ' . date('h', strtotime($slot_info['mintime'])) . " को पहुंचाया जयगा";
        $orderdata['orderStartTime'] = date('h:i', strtotime($slot_info['mintime']));
        $orderdata['orderEndTime'] = date('h:i', strtotime($slot_info['maxtime']));
        //$orderdata['orderDay'] = $slot_info['slots_day']['slots_day_hindi'];
        $orderdata['status'] = $value['order_status'];
        $orderdata['address_type'] = $value['address_type'];
        $orderdata['billing_address'] = $value['billng_address'];
        $orderdata['subtotal'] = number_format((float) $value['sub_total'], 2, '.', '');
        $orderdata['discount'] = number_format((float) $value['discount'], 2, '.', '');
        $orderdata['delivery_charges'] = number_format((float) $value['delivery_charges'], 2, '.', '');
        $orderdata['totalAmount'] = number_format((float) $value['total_amount'], 2, '.', '');

        $cat_products = array();
        $orderdetails = $this->OrderDetails->find()->contain(['Products'])->where(['order_id' => $value['id']])->toarray();

        foreach ($orderdetails as $values) {


          $data = $this->ProductImages->find()->where(['product_id' => $values['product']['id']])->first();
          $data['featuredImage'] = SITE_URL . 'images/product_images/' . $data['image'];

          $data['productName'] = $values['product']['name'];
          $data['productPrice'] = number_format((float) $values['product_price'], 2, '.', '');
          $data['quantity'] = $values['quantity'];
          $data['weight'] = $values['weight'];
          $data['totalProductAmount'] = number_format((float) $values['total_price'], 2, '.', '');
          $cat_products[] = $data;
        }

        if ($cat_products) {

          $orderdata['product'] = $cat_products;
        } else {
          $orderdata['product'] = null;
        }
        $categories[] = $orderdata;
      }
      if ($orderdata) {
        $body['success'] = true;
        $body['Orders'] = $categories;
      }
    } else {
      $body['success'] = false;
      $body['message'] = "कोई ऑर्डर नहीं है";
    }
    echo json_encode($body);
    die;
  }

  public function getNotificationCount()
  {
    $this->autoRender = false;
    $response = array();
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      $userid = $this->userId()['id'];
      $result = $this->Users->find()->where(['id' => $userid])->first();
      if (count($result) > 0) {
        $response["success"] = true;
        $response["notificationCount"] = (int) $result['notification_counter'];
        echo json_encode(($response));
      } else {
        $response["success"] = false;
        $response["message"] = "अधिसूचना नहीं मिली.";
        echo json_encode(($response));
      }
    } else {
      $response["success"] = false;
      $response["message"] = "Ivalid Method";
      echo json_encode(($response));
    }
  }

  public function resetNotificationCount()
  {
    $this->autoRender = false;
    $response = array();
    $userid = $this->userId()['id'];
    $usercheck = $this->Users->find()->where(['id' => $userid])->first();

    if (count($usercheck) > 0) {
      $data['notification_counter'] = 0;
      $savepack = $this->Users->patchEntity($usercheck, $data);
      $result = $this->Users->save($savepack);

      $response["success"] = true;
      $response["message"] = "अधिसूचना संख्या सफलतापूर्वक रीसेट हो गई.";
      echo json_encode(($response));
    } else {
      $response["success"] = false;
      $response["message"] = "उपभोगकर्ता मौजूद नहीं";
      echo json_encode(($response));
    }
  }

  // for invite friend 


  public function cartCount()
  {
    $this->autoRender = false;
    $response = array();
    $userid = $this->userId()['id'];
    $cartCount = $this->Carts->find()->select(['sum' => 'SUM(Carts.quantity)'])->where(['user_id' => $userid])->first();

    $response["success"] = true;
    $response["cartCount"] = (int) $cartCount['sum'];
    echo json_encode(($response));
  }

  public function deleteCart()
  {
    $this->autoRender = false;
    $response = array();
    $userid = $this->userId()['id'];
    $pid = $_POST['productId'];
    $cartCount = $this->Carts->deleteAll(['product_id' => $pid, 'user_id' => $userid]);
    $cartCount = $this->Carts->find()->select(['sum' => 'SUM(Carts.quantity)'])->where(['user_id' => $userid])->first();
    $response["success"] = true;
    $response["message"] = "कार्ट आइटम को सफलतापूर्वक हटा दिया गया";
    echo json_encode(($response));
  }

  public function send_email($to, $customer_mail, $message, $subject)
  {
    $this->loadModel('Users');
    $admin_data = $this->Users->find('all')->where(['Users.role_id' => '1'])->first();
    $mail = new \PHPMailer(True);
    $mail->isSMTP();
    // $mail->SMTPDebug = \SMTP::DEBUG_SERVER;
    $mail->Host = 'smtp.zoho.in';
    $mail->SMTPAuth = true;
    $mail->Username = 'info@nusearchpharma.com';
    $mail->Password = 'Doom#123';
    $mail->SMTPSecure = \PHPMailer::ENCRYPTION_STARTTLS;
    //  $mail->tls = true;
    $mail->Port = 587;
    $mail->From = $admin_data['email'];
    $mail->FromName = 'Nusearch Pharma';
    $mail->addAddress($to);
    $mail->addCC($customer_mail);
    $mail->isHTML(true);
    $mail->Subject = $subject;
    $mail->Body = $message;
    if (!$mail->send()) {
      echo "helmjlo";
      die;
      return 0;
    }
    return 1;
    //   exit;

  }
  // get location in app headra
  public function getLocations()
  {

    $this->loadModel('Locations');
    $this->loadModel('Servicearea');
    $this->autoRender = false;

    $latitude = $_POST["latitude"];
    $longitude = $_POST["longitude"];
    $user_id = $_POST['userId'];
    if (!empty($user_id)) {
      $userData = $this->Users->find('all')->where(['id' => $user_id])->first();
      $locations = $this->Locations->find('all')->where([['status' => 'Y'], ['id' => $userData['location_id']]])->toarray();
    } else {
      $locations = $this->Locations->find('all')->where(['status' => 'Y'])->toarray();
    }

    $matchedLocationID = null;
    // pr($locations); die;
    foreach ($locations as $location) {
      $service_area = $this->Servicearea->find('all')->where(['location_id' => $location['id']])->toarray();
      $serviceArea = [];
      foreach ($service_area as $serviceareakey => $serviceareavalue) {
        $data = [];
        $data['lat'] = $serviceareavalue['latitude'];
        $data['lng'] = $serviceareavalue['longitude'];
        $serviceArea[] = $data;
      }

      $response_location_track = \GeometryLibrary\PolyUtil::containsLocation(
        ['lat' => $latitude, 'lng' => $longitude],
        $serviceArea
      );

      if (empty($response_location_track)) {
        continue;
      } else {
        $matchedLocationID = $location['id'];
      }
    }

    if (!empty($user_id)) {
      $matchedLocationID = $locations[0]['id'];
    }


    $response['success'] = true;
    $response['selectedId'] = empty($matchedLocationID) ? 1 : $matchedLocationID;
    $data = [];
    foreach ($locations as $locations) {
      $data['location_id'] = $locations['id'];
      $data['name'] = $locations['name'];
      $response['locations_list'][] = $data;
    }
    echo json_encode($response);
    return;
  }
}
