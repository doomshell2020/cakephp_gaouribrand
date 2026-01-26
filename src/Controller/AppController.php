<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
  public $paginate = ['limit' => 50];
  
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();

        $this->loadComponent('RequestHandler', [
            'enableBeforeRedirect' => false,
        ]);
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
           //'authorize' => ['Controller'],
            'loginAction' => [
                'controller' => 'Logins',
                'action' => 'login'
            ],
            'logoutRedirect' => [
                'controller' => 'Logins',
                'action' => 'login'
             
            ],
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email','password'=>'password']
                ]
            ],
        ]);

        /*
         * Enable the following component for recommended CakePHP security settings.
         * see https://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
    }


    public function beforeFilter(Event $event)
    {    
        parent::beforeFilter($event);
        $this->loadComponent('Cookie');
        $this->Auth->allow(['move_images','FcCreateThumbnail','FcCreateThumbnail1']);
        
    }


    public function move_images($k='',$folder=null)
{   
  if(count($k['name'])==1){
    $filename=$k['name'];
    $ext=  end(explode('.', $filename));
    $name = md5(time($filename));
    $rnd=mt_rand();
    
    $imagename=trim($name.$rnd.$i.'.'.$ext," ");
   
    if(move_uploaded_file($k['tmp_name'],$folder."/". $imagename))
    {
      $kk[]=$imagename;
    }
  }else{

   foreach($k as $item)
   { 
     $filename=$item['name'];
     $ext=  end(explode('.', $filename));
     $name = md5(time($filename));
     $rnd=mt_rand();
     $imagename=trim($name.$rnd.$i.'.'.$ext," ");
            //print_r($imagename);
     if(move_uploaded_file($item['tmp_name'],$folder."/". $imagename))
     {
       $kk[]=$imagename;
     }
     $i++; 
   }
 }
 return $kk;
}


function FcCreateThumbnail($imgPath, $imgSmallPath, $fileName, $fileSmallName){


  /********************* getting the image in php *********************/
  $myImageFileName = $imgPath.'/'.$fileName;
  $myImageAttribs = @getimagesize($myImageFileName);
  $myThumbWidth = 323;
  $myThumbHeight =244;

  if($myImageAttribs[2] == 2){
    $myImageOld = imagecreatefromjpeg($myImageFileName);
  }else if($myImageAttribs[2] == 3){
    $myImageOld = imagecreatefrompng($myImageFileName);
  }
  //$myImageOld = imagecreatefromjpeg($myImageFileName);
  /**************** setting up the trumbnail object *****************/
  $myImageNew = imagecreatetruecolor($myThumbWidth,$myThumbHeight);
             //imageAntiAlias($myImageNew,true);
  /*************** write  image to disk **************************/
  // path + name of the file
  $myThumbFileName = $imgSmallPath.'/'.$fileSmallName;
  // if image is a GIF copy it
  if($myImageAttribs[2] == 1){   
  // copy the image as we do not have a function like this
   $response = copy($myImageFileName, $myThumbFileName);
  // else if the image JPG or PNG
 }else if($myImageAttribs[2] != 1){
  // resample image (only JPG, PNG)
   @imagecopyresampled($myImageNew, $myImageOld, 0, 0, 0, 0, $myThumbWidth, $myThumbHeight, $myImageAttribs[0], $myImageAttribs[1]);
  // JPG
   if($myImageAttribs[2] == 2){  
    $return = imagejpeg($myImageNew, $myThumbFileName, 100);
  // PNG
  }else if($myImageAttribs[2] == 3){
    $return = imagepng($myImageNew, $myThumbFileName);
  }

}


$myReturnArray = array($return);

return $myReturnArray; 
}

function FcCreateThumbnail1($imgPath, $imgSmallPath, $fileName, $fileSmallName, $newWidth, $newHeight){


  /********************* getting the image in php *********************/

  $myImageFileName = $imgPath.'/'.$fileName;
  $myImageAttribs = @getimagesize($myImageFileName);
  
  $myThumbWidth = $newWidth;
  $myThumbHeight = $newHeight;

  if($myImageAttribs[2] == 2){
    $myImageOld = imagecreatefromjpeg($myImageFileName);
  }else if($myImageAttribs[2] == 3){
    $myImageOld = imagecreatefrompng($myImageFileName);
  }


  //$myImageOld = imagecreatefromjpeg($myImageFileName);

  /**************** setting up the trumbnail object *****************/
  $myImageNew = imagecreatetruecolor($myThumbWidth,$myThumbHeight);
             //imageAntiAlias($myImageNew,true);

  /*************** write  image to disk **************************/

  // path + name of the file
  $myThumbFileName = $imgSmallPath.'/'.$fileSmallName;
  // if image is a GIF copy it
  if($myImageAttribs[2] == 1){   
  // copy the image as we do not have a function like this
   $response = copy($myImageFileName, $myThumbFileName);
  // else if the image JPG or PNG
 }else if($myImageAttribs[2] != 1){
  // resample image (only JPG, PNG)
   @imagecopyresampled($myImageNew, $myImageOld, 0, 0, 0, 0, $myThumbWidth, $myThumbHeight, $myImageAttribs[0], $myImageAttribs[1]);
  // JPG
   if($myImageAttribs[2] == 2){  
    $return = imagejpeg($myImageNew, $myThumbFileName, 100);
  // PNG
  }else if($myImageAttribs[2] == 3){
    $return = imagepng($myImageNew, $myThumbFileName);
  }


}


$myReturnArray = array($return);

return $myReturnArray; 
}
  
}
