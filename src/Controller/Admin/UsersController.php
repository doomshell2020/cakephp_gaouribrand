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
class UsersController extends AppController
{
	
	public function login(){ 
		$this->viewBuilder()->layout('login');
		return $this->redirect('/logins');
	}
	
	public function index(){ 
		$this->loadModel('Users');	
		$this->viewBuilder()->layout('admin');
			$users = $this->Users->find('all')->order(['Users.id' => 'DESC'])->toarray();
			//pr($users); die;
			$this->set('users', $users);
	}


public function useradd()
{
  $this->viewBuilder()->layout('admin');
  
  // $store = $this->Stores->find('list')->where(['Stores.status' => '1'])->order(['Stores.id'=>'DESC'])->toarray();
  // $this->set('store',$store); 

  $newpack = $this->Users->newEntity();
  if ($this->request->is(['post', 'put'])) { 
  //pr($this->request->data);  die;
   if ($this->request->data['image']['name'] != '')
   {
	 $k = $this->request->data['image'];
	 $galls = $this->move_images($k);
	 $this->FcCreateThumbnail1("compress", "images/image", $galls[0], $galls[0], "100", "100");
	 $this->request->data['image'] = $galls[0];
	 unlink('compress/' . $galls[0]);
   }    
   $this->request->data['role_id']='2';
   $this->request->data['password']=(new DefaultPasswordHasher)->hash($this->request->data['password']);

    $savepack = $this->Users->patchEntity($newpack, $this->request->data);
    $results=$this->Users->save($savepack);
    
    if ($results){
      $this->Flash->success(__('User has been saved.'));
      return $this->redirect(['action' => 'index']);  
    }else{
      $this->Flash->error(__('User not saved.'));
      return $this->redirect(['action' => 'index']);  
    }
  }
}

public function useredit($id=null)
{
  $this->viewBuilder()->layout('admin');
  $this->loadModel('Users');  
 
  // $store = $this->Stores->find('list')->select(['address'])->where(['Stores.status' => '1'])->order(['Stores.id'=>'DESC'])->toarray();
  // $this->set('store',$store); 

  $users = $this->Users->get($id);
  //pr($users);die;
  $this->set('users',$users);
  if ($this->request->is(['post', 'put'])) { 
  //pr($this->request->data); die;  
   if ($this->request->data['image']['name'] != '')
   {
	 $k = $this->request->data['image'];
	 $galls = $this->move_images($k);
	 $this->FcCreateThumbnail1("compress", "images/image", $galls[0], $galls[0], "100", "100");
	 $this->request->data['image'] = $galls[0];
	 unlink('compress/' . $galls[0]);
   }else{
	$this->request->data['image'] = $users['image'];
   }  
   $this->request->data['role_id']='2';
   $this->request->data['password']=(new DefaultPasswordHasher)->hash($this->request->data['new_password']);

    $savepack = $this->Users->patchEntity($users , $this->request->data);
    $results=$this->Users->save($savepack);
    if ($results){
      $this->Flash->success(__('User has been updated.'));
      return $this->redirect(['action' => 'index']);  
    }else{
      $this->Flash->error(__('User not saved.'));
      return $this->redirect(['action' => 'index']);  
    }
  }
}

public function delete($id)
{
  $this->loadModel('Users');
  $catdelete = $this->Users->get($id);
    if($catdelete){
      unlink('images/image' . $catdelete['image']);
      $this->Users->deleteAll(['Users.id' => $id]); 
      $this->Users->delete($catdelete);

      $this->Flash->success(__('User has been deleted successfully.'));
      return $this->redirect(['action' => 'index']);
    }else{
      $this->Flash->error(__('User not  delete'));
      return $this->redirect(['action' => 'index']);
    }
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

public function add($id=null){ 
    $this->loadModel('Users');
    $this->viewBuilder()->layout('admin');

    
    
    $this->set(compact('branch_count','branch_list','default_branch'));
    $ntypes = $this->Users->get($id);
    //pr($ntypes); die;
    if ($this->request->is(['post', 'put'])) {
      // pr($this->request->data); die;
    $ntypes = $this->Users->patchEntity($ntypes, $this->request->data); 
   // pr($ntypes); die;
    $this->Users->save($ntypes);
     $this->Flash->success(__('User has been Updated'));
    return $this->redirect(['action' => 'index']);  
    
    
  }
  $this->set('ntypes', $ntypes);
}
   //  to change password
public function changepassword(){ 
	$this->viewBuilder()->layout('admin');
	$this->loadModel('Users');   
	$user =$this->Users->get($this->Auth->user('id')); 
	if ($this->request->is(['post', 'put'])) {
			//check old password and new password
		if((isset($this->request->data['new_password']) && !empty($this->request->data['new_password'])) && (isset($this->request->data['confirm_pass']) && !empty($this->request->data['confirm_pass']))){
			if($this->request->data['new_password'] == $this->request->data['confirm_pass']){
					$this->request->data['password'] = (new DefaultPasswordHasher)->hash($this->request->data['new_password']);			//change password
					$user = $this->Users->patchEntity($user, $this->request->data); 
					$this->Users->save($user);
					$this->Flash->success(__('Your password is successfully Changed.'));
					return $this->redirect(['controller'=>'visitors','action' => 'index']);
					
				}else{
					$this->Flash->error(__('Your new password and confirm password doesnot match, try again.'));
					return $this->redirect(['controller'=>'visitors','action' => 'index']);	
				}
			}	
		}
	}
  public function isAuthorized($user)
 {
     if (isset($user['role_id']) && ($user['role_id'] == 1) || $user['role_id'] == 2) {
         return true;
     }
     return false;
 }	
}


//add
    //   if((isset($this->request->data['new_password']) && !empty($this->request->data['new_password'])) && (isset($this->request->data['confirm_passs']) && !empty($this->request->data['confirm_passs']))){
    //       if($this->request->data['new_password'] == $this->request->data['confirm_passs']){
    //       $this->request->data['password'] = (new DefaultPasswordHasher)->hash($this->request->data['new_password']);     //change password
    //       $this->request->data['confirm_pass']=$this->request->data['confirm_passs'];
    // if ($this->request->data['image']['name'] != '')
    //   { 
    //     $this->request->data['image']=$this->request->data['image'];
    //   }
    //       $ntypes = $this->Users->patchEntity($ntypes, $this->request->data); 
    //       if ($this->Users->save($ntypes)) {
    //         $this->Flash->success(__('Your password is changed sucessfully, Please log in with new password'));
    //         return $this->redirect('/logout');  
    //       }
    //     }else{
    //       $this->Flash->error(__('Your new password and confirm password doesnot match, try again.'));
          
    //     }
    // }