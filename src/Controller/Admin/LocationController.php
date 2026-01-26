<?php

namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;
use Cake\ORM\TableRegistry;
use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;

class LocationController extends AppController
{
	
	public function login(){ 
		$this->viewBuilder()->layout('login');
		return $this->redirect('/logins');
	}
	
	public function index(){ 
		$this->loadModel('Users');	
		$this->viewBuilder()->layout('admin');
		$user=$this->request->session()->read('Auth.User'); 
		$users = $this->Users->find('all')->where(['Users.role_id'=>'3'])->order(['Users.id' => 'DESC'])->toarray();
		$this->set('users', $users);
	}

	public function search(){ 
		$this->loadModel('Users'); 
		$user=$this->request->session()->read('Auth.User'); 
	   $name = $this->request->data['name'];
	   $mobile = $this->request->data['mobile'];
	  //pr($name); die;
	   $cond = [];   
		 if(isset($name) && $name!='')
		 {
	   $cond['Users.name LIKE']='%'.trim($name).'%';	
	   }

	   if(isset($mobile) && $mobile!='')
	   {
	 $cond['Users.mobile LIKE']='%'.trim($mobile).'%';	
	 }
	 // pr($cond); die;
	 
	$users = $this->Users->find('all')->where(['Users.role_id'=>'3',$cond])->order(['Users.id' => 'DESC'])->toarray();
	 $this->set('users', $users);
	
	  
	  }
	  public function status($id,$status){

		$this->loadModel('Users');
		if(isset($id) && !empty($id)){
		  $product = $this->Users->get($id);
		  $product->status = $status;
		  if ($this->Users->save($product)) {
			if($status=='1'){
			  $this->Flash->success(__('User status has been Activeted.'));
			}else{
			  $this->Flash->success(__('User status has been Deactiveted.'));
			}
			return $this->redirect(['action' => 'index']);  
		  }
		}
	  }

}