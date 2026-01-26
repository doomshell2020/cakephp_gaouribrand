<?php
namespace App\Controller\Admin;
use App\Controller\AppController;
use Cake\Core\Configure; 
use Cake\Network\Exception\ForbiddenException;
use Cake\Network\Exception\NotFoundException;
use Cake\View\Exception\MissingTemplateException;

class StaticController extends AppController

{ 
	public function index(){ 
		$this->viewBuilder()->layout('admin');
		$this->loadModel('static');
		$static = $this->static->find('all')->order(['static.id']);
		$this->set('static', $this->paginate($static)->toarray());
	}

	public function add()
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('static');
		$newpack = $this->static->newEntity();
		if ($this->request->is(['post', 'put'])) { 			
      //pr($this->request->data); die;
			$this->request->data['slug'] = $this->request->data['slug'];
			$savepack = $this->static->patchEntity($newpack, $this->request->data);
			$results=$this->static->save($savepack);

			if ($results){
				$this->Flash->success(__('static has been saved.'));
				return $this->redirect(['action' => 'index']);	
			}else{
				$this->Flash->error(__('static not saved.'));
				return $this->redirect(['action' => 'index']);	
			}
		}
	}

	public function status($id,$status){

		//echo $id; die;
		$this->loadModel('static');
		if(isset($id) && !empty($id)){
			if(isset($id) && !empty($id)){
				$product = $this->static->get($id);
				$product->status = $status;
				if ($this->static->save($product)) {
				  if($status=='1'){
					$this->Flash->success(__('Static status has been Activeted.'));
				  }else{
					$this->Flash->success(__('Static status has been Deactiveted.'));
				  }
				  return $this->redirect(['action' => 'index']);  
				}
			  }
			}
	}

	public function delete($id)
	{
		$this->loadModel('static');
		$static = $this->static->get($id);
		
		if($static){
			$this->static->deleteAll(['Ourteams.id' => $id]); 
			$this->static->delete($static);

			$this->Flash->success(__('static has been deleted successfully.'));
			return $this->redirect(['action' => 'index']);
		}else{
			$this->Flash->error(__('static not  delete'));
			return $this->redirect(['action' => 'index']);
		}
	}

	public function edit($id)
	{
		$this->viewBuilder()->layout('admin');
		$this->loadModel('static');

		$newpack = $this->static->get($id);
		$this->set('newpack',$newpack);
		if ($this->request->is(['post', 'put'])) {
			//pr($this->request->data); die;
               if($this->request->data['slug']){
               $this->request->data['slug'] = $this->request->data['slug'];
               }

			$savepack = $this->static->patchEntity($newpack, $this->request->data);
			$results=$this->static->save($savepack);
			if ($results){
				$this->Flash->success(__('static has been updated.'));
				return $this->redirect(['action' => 'index']);	
			}else{
				$this->Flash->error(__('static not Updated.'));
				return $this->redirect(['action' => 'index']);	
			}		    
		}
	}
	
	public function isAuthorized($user)
{
    if (isset($user['id']) && ($user['id'] == 1)) {
        return true;
    }
    return false;
}
}