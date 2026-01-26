<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

include '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
include '../vendor/phpmailer/phpmailer/src/Exception.php';
include '../vendor/phpmailer/phpmailer/src/SMTP.php';
include '../vendor/phpmailer/phpmailer/src/OAuth.php';
include '../vendor/autoload.php';

class PagesController extends AppController
{
    public function beforeFilter(Event $e)
    {
        $this->Auth->allow(['terms', 'privacy', 'contactus', 'getreferralinfo']);
    }

    public function initialize()
    {
        $this->loadModel('Users');
        $this->loadModel('States');
        $this->loadModel('Products');
        $this->loadModel('Orders');
        $this->loadModel('Static');
        $this->loadModel('Contactus');
        parent::initialize();
    }

    public function home()
    {
        $this->viewBuilder()->layout('homepage');
    }

    public function terms()
    {
        $this->viewBuilder()->layout('frontend');
        $aboutus = $this->Static->find('all')->where(['Static.id' => 26])->first();
        $this->set('aboutus', $aboutus);
    }
    public function privacy()
    {
        $this->viewBuilder()->layout('frontend');
        $aboutus = $this->Static->find('all')->where(['Static.id' => 30])->first();
        // pr($aboutus['content']); die;
        $this->set('aboutus', $aboutus);
    }
    public function refund()
    {
        $this->viewBuilder()->layout('frontend');
        $aboutus = $this->Static->find('all')->where(['Static.id' => 32])->first();
        $this->set('aboutus', $aboutus);
    }
    public function contactus()
    {
        $this->viewBuilder()->layout('frontend');
        $aboutus = $this->Static->find('all')->where(['Static.id' => 31])->first();
        $this->set('aboutus', $aboutus);
    }

    public function getreferralinfo($id = null)
    {

        $this->viewBuilder()->layout('frontend');
        $this->loadModel('Referral');
        $app_url = "https://play.google.com/store/apps/details?id=com.doomshell.gaouribrand&hl=en-IN";
        $newpack = $this->Referral->newEntity();

        $this->set('user_id', $id);

        
        if ($this->request->is(['post', 'put'])) {

            $data['user_id'] = $this->request->data['user_id'];
            $data['name'] = $this->request->data['name'];
            $data['mobile_no'] = $this->request->data['mobile_no'];
            $savepack = $this->Referral->patchEntity($newpack, $data);
            if ($this->Referral->save($savepack)) {
                return $this->redirect($app_url);
            }
        }
    }
}
