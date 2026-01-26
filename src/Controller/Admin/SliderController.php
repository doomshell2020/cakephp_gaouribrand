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

class SliderController extends AppController
{
	
	public function login(){ 
		$this->viewBuilder()->layout('login');
		return $this->redirect('/logins');
	}
	


  public function index(){ 
	$this->viewBuilder()->layout('admin');
	$this->loadModel('Slider');  
	$slider=$this->Slider->find('all')->order(['id' => 'Desc']);
	$this->set('slider',$this->paginate($slider)->toarray());
  }
 
  
 public function add()
 {
   $this->viewBuilder()->layout('admin');
   $this->loadModel('Slider'); 
   $newpack = $this->Slider->newEntity();
   //pr($newpack); die;
   if ($this->request->is(['post', 'put'])) { 
	  
	   $this->request->data['slider_type'] = 'App';
	   if ($this->request->data['image']['name'] != '')
	   {
		
		$height = getimagesize($this->request->data['image']['tmp_name'])[1];
		$width = getimagesize($this->request->data['image']['tmp_name'])[0];

		if($height < 720 || $width < 373){
			$this->Flash->error(__('Please select min image size 720*373px'));
			return $this->redirect(['action' => 'add']);  
		}

		 $k = $this->request->data['image'];
		 $galls = $this->move_images($k,'images/image/');
		 // $this->FcCreateThumbnail1("compress", "images/subcategories", $galls[0], $galls[0], "78", "78");
		 $this->request->data['image'] = $galls[0];
		 unlink('compress/' . $galls[0]);
	   }    
	 $savepack = $this->Slider->patchEntity($newpack, $this->request->data);
	 $results=$this->Slider->save($savepack);
	 if ($results){
	   $this->Flash->success(__('Sliders has been saved.'));
	   return $this->redirect(['action' => 'index']);  
	 }else{
	   $this->Flash->error(__('Sliders not saved.'));
	   return $this->redirect(['action' => 'index']);  
	 }
   }
 }
 
 
 public function status($id,$status){
 
   $this->loadModel('Slider');
   if(isset($id) && !empty($id)){
	 $product = $this->Slider->get($id);
	 $product->status = $status;
	 if ($this->Slider->save($product)) {
	   if($status=='Y'){
		 $this->Flash->success(__('Slider status has been Activeted.'));
	   }else{
		 $this->Flash->success(__('Slider status has been Deactiveted.'));
	   }
	   return $this->redirect(['action' => 'index']);  
	 }
   }
 }
 
 public function delete($id)
 {
   $this->loadModel('Slider');
   $catdelete = $this->Slider->get($id);
	 if($catdelete){
	   unlink('images/image' . $catdelete['image']);
	   $this->Slider->deleteAll(['Slider.id' => $id]); 
	   $this->Slider->delete($catdelete);
 
	   $this->Flash->success(__('Slider has been deleted successfully.'));
	   return $this->redirect(['action' => 'index']);
	 }
 }
 
 public function edit($id)
 {
   $this->viewBuilder()->layout('admin');
   $this->loadModel('Slider');
 
   $slider = $this->Slider->get($id);
   $this->set('slider',$slider);
   if ($this->request->is(['post', 'put'])) {
	   if ($this->request->data['image']['name'] != '')
	   {
		$k = $this->request->data['image'];
		$galls = $this->move_images($k,'images/image/');
		// $this->FcCreateThumbnail1("compress", "images/subcategories", $galls[0], $galls[0], "78", "78");
		$this->request->data['image'] = $galls[0];
		 unlink('compress/' . $galls[0]);
	   }else{
		 $this->request->data['image'] = $slider['image'];
	   }    
	 
	 $savepack = $this->Slider->patchEntity($slider, $this->request->data);
	 //pr($savepack); die;
	 $results=$this->Slider->save($savepack);
	 if ($results){
	   $this->Flash->success(__('Slider has been updated.'));
	   return $this->redirect(['action' => 'index']);  
	 }else{
	   $this->Flash->error(__('Slider not Updated.'));
	   return $this->redirect(['action' => 'index']);  
	 }           
   }
 }
 
 
 
 }
 